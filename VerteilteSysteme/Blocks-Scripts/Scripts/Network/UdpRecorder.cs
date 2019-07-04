using System;
using System.Collections;
using System.Collections.Generic;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using UnityEngine;

public class UdpRecorder : MonoBehaviour
{
    #region TextureStuff
    public RenderTexture renderTexture;
    Texture2D currentTexture;
    #endregion

    #region NetworkStuff
    private UdpClient listener;
    private int listenerPort = 8081;

    private UdpClient sender;
    private int senderPort  = 8083;
    IPEndPoint remoteEndPoint;

    private IPAddress clientAddress;
    private bool clientConnected = false;

    private Thread listenerThread;
    private Thread senderThread;

    #endregion

    // Start is called before the first frame update
    void Start()
    {
        init();
    }


    private void init()
    {
        listenerThread = new Thread(new ThreadStart(WaitForClient));
        listenerThread.IsBackground = true;
        listenerThread.Start();

        StartCoroutine(StreamBytes());
    }

    private void WaitForClient()
    {
        listener = new UdpClient(listenerPort);
        while (!clientConnected)
        {
            try
            {
                // Bytes empfangen.
                IPEndPoint anyIP = new IPEndPoint(IPAddress.Any, 0);

                // Blocks until message is received
                byte[] data = listener.Receive(ref anyIP);

                // Bytes to UTF8 then parse data and get IP
                ParseLogin(Encoding.UTF8.GetString(data));
                
            }
            catch (Exception e)
            {
                Debug.Log(e.ToString());
            }

        }
    }
    private void ParseLogin(string message)
    {
        clientAddress = IPAddress.Parse(message);
        clientConnected = true;

        Debug.Log("Client with IP " + message + " connected...");
        Debug.Log("Start streaming...");

    }


    WaitForEndOfFrame endOfFrame = new WaitForEndOfFrame();
    IEnumerator StreamBytes()
    {
        while(!clientConnected)
        {
            yield return null;
        }

        remoteEndPoint = new IPEndPoint(clientAddress, senderPort);
        sender = new UdpClient();


        currentTexture = new Texture2D(renderTexture.width, renderTexture.height);
        bool readyToGetFrame = true;

        while (clientConnected)
        {

            //Wait for End of frame
            yield return endOfFrame;

            Texture2D tex = new Texture2D(renderTexture.height, renderTexture.width, TextureFormat.RGB24, false);
            RenderTexture.active = renderTexture;
            tex.ReadPixels(new Rect(0, 0, renderTexture.width, renderTexture.height), 0, 0);
            tex.Apply();
            currentTexture.SetPixels(tex.GetPixels());
            byte[] pngBytes = currentTexture.EncodeToPNG();

            //Set readyToGetFrame false
            readyToGetFrame = false;

            try
            {
                Thread writerThread = new Thread(() =>
                {
                    Debug.Log("Sending: " + pngBytes.Length + " Bytes");
                    sender.Send(pngBytes, pngBytes.Length, remoteEndPoint);
                    //Sent. Set readyToGetFrame true
                    readyToGetFrame = true;
                });

                writerThread.IsBackground = true;
                writerThread.Start();

            } catch (Exception e)
            {
                Debug.Log(e.ToString());
            }

            //Wait until we are ready to get new frame(Until we are done sending data)
            while (!readyToGetFrame)
            {
                yield return null;
            }

        }

    }


    // Update is called once per frame
    void Update()
    {
        
    }
}
