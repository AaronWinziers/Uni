using UnityEngine;
using System.Collections;
using System.IO;
using UnityEngine.UI;
using System;
using System.Text;
using System.Net;
using System.Net.Sockets;
using System.Threading;
using System.Collections.Generic;

public class TcpRecorder : MonoBehaviour
{
    public RenderTexture renderTexture;
    public RawImage myImage;
    public bool enableLog = false;
    Texture2D currentTexture;


    private TcpListener listener;
    private const int port = 8185;
    private bool stop = false;
    private TcpClient client;
    private bool startSender = true;

    //This must be the-same with SEND_COUNT on the client
    const int SEND_RECEIVE_COUNT = 15;

    private void Start()
    {
        Application.runInBackground = true;

        //Start Coroutine
        StartCoroutine(init());
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

    IEnumerator init()
    {
        listener = null;
        
        currentTexture = new Texture2D(renderTexture.width, renderTexture.height);

        // Connect to the server
        listener = new TcpListener(IPAddress.Any, port);

        listener.Start();

        while (renderTexture.width < 100)
        {
            yield return null;
        }

        //Start sending coroutine
        StartCoroutine(senderCOR());
    }

    WaitForEndOfFrame endOfFrame = new WaitForEndOfFrame();
    IEnumerator senderCOR()
    {
        startSender = false;
        Debug.Log("Start Sender COR");
        bool isConnected = false;

        client = null;
        NetworkStream stream = null;

        try
        {
            // Wait for client to connect in another Thread 
            Thread listenerThread = new Thread(() =>
            {
                while (!stop)
                {
                // Wait for client connection
                client = listener.AcceptTcpClient();

                    isConnected = true;
                    stream = client.GetStream();
                }
            });
            listenerThread.IsBackground = true;
            listenerThread.Start();

        }
        catch (Exception e)
        {
            Debug.Log("On client connect exception " + e);
        }

        //Wait until client has connected
        while (!isConnected)
        {
            yield return null;
        }

        LOG("Connected!");

        bool readyToGetFrame = true;

        byte[] frameBytesLength = new byte[SEND_RECEIVE_COUNT];



        while (isConnected)
        {
            //Wait for End of frame
            yield return endOfFrame;

            Texture2D tex = new Texture2D(renderTexture.height, renderTexture.width, TextureFormat.RGB24, false);
            RenderTexture.active = renderTexture;
            tex.ReadPixels(new Rect(0, 0, renderTexture.width, renderTexture.height), 0, 0);
            tex.Apply();
            currentTexture.SetPixels(tex.GetPixels());
            byte[] pngBytes = currentTexture.EncodeToPNG();
            //Fill total byte length to send. Result is stored in frameBytesLength
            byteLengthToFrameByteArray(pngBytes.Length, frameBytesLength);

            //Set readyToGetFrame false
            readyToGetFrame = false;


            //Connect to server from another Thread
            Thread bufferWriteThread = new Thread(() =>
            {               
                try
                {
                    //Send total byte count first
                    stream.Write(frameBytesLength, 0, frameBytesLength.Length);
                    LOG("Sent Image byte Length: " + frameBytesLength.Length);

                    //Send the image bytes
                    stream.Write(pngBytes, 0, pngBytes.Length);
                    LOG("Sending Image byte array data : " + pngBytes.Length);

                    //Sent. Set readyToGetFrame true
                    readyToGetFrame = true;
                }
                catch (Exception e)
                {
                    
                    Debug.Log("Client disconnected");
                    Debug.Log("Restarting Coroutine...");

                    isConnected = false;
                    startSender = true;
                } 
                       
            });
            bufferWriteThread.IsBackground = true;
            bufferWriteThread.Start();


            //Wait until we are ready to get new frame(Until we are done sending data)
            while (!readyToGetFrame)
            {
                LOG("Waiting To get new frame");
                yield return null;
            }
        }
        
    }


    void LOG(string messsage)
    {
        if (enableLog)
            Debug.Log(messsage);
    }

    private void Update()
    {
        if (startSender)
        {
            StartCoroutine(senderCOR());
        }
    }

    // stop everything
    private void OnApplicationQuit()
    {


        if (listener != null)
        {
            listener.Stop();
        }

    }
}