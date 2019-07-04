using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Net.Sockets;
using System.Net;
using System.IO;
using System;
using System.Threading;
using System.Collections.Generic;

public class TcpDisplayer : MonoBehaviour
{
    public RawImage image;
    public bool enableLog = false;

    const int port = 8185;
    public string IP = "136.199.126.180";
    TcpClient client;

    Texture2D tex;

    Queue<byte[]> receivedImageBytesQueue = new Queue<byte[]>();

    private bool stop = false;

    //This must be the-same with SEND_COUNT on the server
    const int SEND_RECEIVE_COUNT = 15;

    // Use this for initialization
    void Start()
    {
        tex = new Texture2D(0, 0);
        init();
    }

    void init()
    {

        client = new TcpClient();
        try
        {
            //Connect to server from another Thread
            Thread imageReceiveThread = new Thread(() =>
            {
                Debug.Log("Connecting to server...");

                client.Connect(IPAddress.Parse(IP), port);

                Debug.Log("Connected!");

                imageReceiver();
            });
            imageReceiveThread.IsBackground = true;
            imageReceiveThread.Start();

        }
        catch (Exception e)
        {
            Debug.Log("On client connect exception " + e);
        }
    }



    void imageReceiver()
    {
        //While loop in another Thread is fine so we don't block main Unity Thread

        while (!stop)
        {
            //Read Image Count
            int imageSize = readImageByteSize(SEND_RECEIVE_COUNT);
            LOGWARNING("Received Image byte Length: " + imageSize);

            //Read Image Bytes and Display it
            readFrameByteArray(imageSize);
        }

    }


    //Converts the data size to byte array and put result to the fullBytes array
    void byteLengthToFrameByteArray(int byteLength, byte[] fullBytes)
    {
        //Clear old data
        Array.Clear(fullBytes, 0, fullBytes.Length);
        //Convert int to bytes
        byte[] bytesToSendCount = BitConverter.GetBytes(byteLength);
        //Copy result to fullBytes
        bytesToSendCount.CopyTo(fullBytes, 0);
    }

    //Converts the byte array to the data size and returns the result
    int frameByteArrayToByteLength(byte[] frameBytesLength)
    {
        int byteLength = BitConverter.ToInt32(frameBytesLength, 0);
        return byteLength;
    }


    /////////////////////////////////////////////////////Read Image SIZE from Server///////////////////////////////////////////////////
    private int readImageByteSize(int size)
    {
        bool disconnected = false;

        NetworkStream serverStream = client.GetStream();

        //while (serverStream == null) serverStream = client.GetStream();

        byte[] imageBytesCount = new byte[size];
        var total = 0;
        do
        {
            var read = serverStream.Read(imageBytesCount, total, size - total);
            //Debug.LogFormat("Client recieved {0} bytes", total);
            if (read == 0)
            {
                disconnected = true;
                break;
            }
            total += read;
        } while (total != size);

        int byteLength;

        if (disconnected)
        {
            byteLength = -1;
        }
        else
        {
            byteLength = frameByteArrayToByteLength(imageBytesCount);
        }
        return byteLength;
    }

    /////////////////////////////////////////////////////Read Image Data Byte Array from Server///////////////////////////////////////////////////
    private void readFrameByteArray(int size)
    {
        bool disconnected = false;

        NetworkStream serverStream = client.GetStream();
        byte[] imageBytes = new byte[size];
        var total = 0;
        do
        {
            var read = serverStream.Read(imageBytes, total, size - total);
            //Debug.LogFormat("Client recieved {0} bytes", total);
            if (read == 0)
            {
                disconnected = true;
                break;
            }
            total += read;
        } while (total != size);

        bool readyToReadAgain = false;

        //Display Image
        if (!disconnected)
        {
            //Display Image on the main Thread

                displayReceivedImage(imageBytes);
                readyToReadAgain = true;
            
        }

        //Wait until old Image is displayed
        while (!readyToReadAgain)
        {
            System.Threading.Thread.Sleep(1);
        }
    }


    void displayReceivedImage(byte[] receivedImageBytes)
    {
        receivedImageBytesQueue.Enqueue(receivedImageBytes);
    }


    // Update is called once per frame
    void Update()
    {
        if (receivedImageBytesQueue.Count > 0)
        {
            tex.LoadImage(receivedImageBytesQueue.Dequeue());
            image.texture = tex;
            
        }

    }


    void LOG(string messsage)
    {
        if (enableLog)
            Debug.Log(messsage);
    }

    void LOGWARNING(string messsage)
    {
        if (enableLog)
            Debug.LogWarning(messsage);
    }

    void OnApplicationQuit()
    {
        LOGWARNING("OnApplicationQuit");
        stop = true;

        if (client != null)
        {
            client.GetStream().Close();
            client.Close();
        }
    }
}