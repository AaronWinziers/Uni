using System;
using System.Collections;
using System.Collections.Generic;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.UI;

public class UdpDisplayer : MonoBehaviour
{
    #region TextureStuff
    public RawImage image;
    Queue<byte[]> receivedImageBytesQueue = new Queue<byte[]>();
    Texture2D tex;
    #endregion

    #region NetworkStuff
    private UdpClient listener;
    private int listenerPort = 8083;


    private UdpClient loginSender;
    public string loginServerIP = "136.199.126.180";
    private string myIP;
    private int loginSenderPort = 8081;
    IPEndPoint remoteEndPoint;

    private Thread receiveThread;
    private Thread loginSenderThread;


    private bool tryLogin = true;

    const int SEND_RECEIVE_COUNT = 15;
    #endregion


    // Start is called before the first frame update
    void Start()
    {
        tex =  new Texture2D(0, 0);
        myIP = LocalIPAddress();
        init();
    }

    // Start Receiver thread and open the port
    private void init()
    {
        Debug.Log("Starting Login Thread...");
        receiveThread = new Thread(new ThreadStart(Login));
        receiveThread.IsBackground = true;
        receiveThread.Start();
        Debug.Log("Receiver Login started...");


        Debug.Log("Starting Receiver Thread...");
        receiveThread = new Thread(new ThreadStart(ListenForData));
        receiveThread.IsBackground = true;
        receiveThread.Start();
        Debug.Log("Receiver Thread started...");

    }


    void Login()
    {
        remoteEndPoint = new IPEndPoint(IPAddress.Parse(loginServerIP), loginSenderPort);
        loginSender = new UdpClient();

        while(tryLogin)
        {
            try
            {
                byte[] message = Encoding.UTF8.GetBytes(myIP);
                // Den message zum Remote-Client senden.
                loginSender.Send(message, message.Length, remoteEndPoint);
            } catch (Exception e)
            {
                Debug.Log("On client connect exception " + e);
            }


        }

    }

    void ListenForData()
    {

        listener = new UdpClient(listenerPort);
        while (true)
        {
            try
            {
                // Get Bytes
                IPEndPoint anyIP = new IPEndPoint(IPAddress.Any, 0);
                byte[] imageBytes = listener.Receive(ref anyIP);
                if (imageBytes != null)
                {
                    tryLogin = false;
                }

                receivedImageBytesQueue.Enqueue(imageBytes);

            }
            catch (Exception e)
            {
                Debug.Log(e.ToString());
            }

        }
    }


    private void Update()
    {
        if (receivedImageBytesQueue.Count > 0)
        {
            tex.LoadImage(receivedImageBytesQueue.Dequeue());
            image.texture = tex;

        }
    }

    public static string LocalIPAddress()
    {
        IPHostEntry host;
        string localIP = "0.0.0.0";
        host = Dns.GetHostEntry(Dns.GetHostName());
        foreach (IPAddress ip in host.AddressList)
        {
            if (ip.AddressFamily == AddressFamily.InterNetwork)
            {
                localIP = ip.ToString();
                break;
            }
        }
        return localIP;
    }

}
