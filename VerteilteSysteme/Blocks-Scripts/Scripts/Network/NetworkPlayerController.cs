using System;
using System.Collections;
using System.Collections.Generic;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using UnityEngine;

public class NetworkPlayerController : MonoBehaviour
{
    public string IP = "136.199.126.180";

    IPEndPoint remoteEndPoint;
    const int port = 8182;
    UdpClient client;

    private Vector3 m_movement;
    private float horizontalSpeed = 2.0f;
    private float verticalSpeed = 2.0f;


    // Start is called before the first frame update
    void Start()
    {
        init();
    }

    private void init()
    {
        remoteEndPoint = new IPEndPoint(IPAddress.Parse(IP), port);
        client = new UdpClient();
    }

    private void SendData(String data)
    {
        try
        {
            byte[] message= Encoding.UTF8.GetBytes(data);
            // Den message zum Remote-Client senden.
            client.Send(message, message.Length, remoteEndPoint);
        } catch (Exception e)
        {
            Debug.Log(e.ToString());
        }
    }


    // Update is called once per frame
    void Update()
    {
        // Chat Open
        if (Input.GetKeyDown(KeyCode.C))
        {
            SendKey(KeyCode.C); 
        }
        // Chat Close
        if (Input.GetKeyDown(KeyCode.Escape))
        {
            SendKey(KeyCode.Escape);
        }
        // Jump between world
        if (Input.GetKeyDown(KeyCode.Tab))
        {
            SendKey(KeyCode.Tab);
        }

        // Vertical Movement
        if (Input.GetKey(KeyCode.Space))
        {
            SendKey(KeyCode.Space);

        }
        if (Input.GetKey(KeyCode.LeftShift))
        {
            SendKey(KeyCode.LeftShift);
        }

        // Delete Block
        if (Input.GetMouseButtonDown(1))
        {
            SendKey("RightClick");
        }

        //Create Block
        if (Input.GetMouseButtonDown(0))
        {
            SendKey("LeftClick");
        }


        // Movement
        float horizontal = Input.GetAxis("Horizontal");
        float vertical = Input.GetAxis("Vertical");

        if(horizontal != 0f || vertical != 0f) SendMovement(new Vector2(horizontal, vertical));
        

        // Camera controls
        float h = horizontalSpeed * Input.GetAxis("Mouse X");
        float v = verticalSpeed * Input.GetAxis("Mouse Y");
        
        // X = Horizontal, Y = Vertical
        //SendRoation(new Vector2(h, v));        
    }

    void SendMovement(Vector2 vector)
    {
        string message = "vector:";
        message += vector.ToString("G4");

        SendData(message);
    }

    void SendRoation(Vector2 q)
    {
        string message = "quaternion:";
        message += q.ToString("G4");

        SendData(message);
    }

    void SendKey(KeyCode key)
    {
        SendKey(key.ToString());
    }

    void SendKey(string str)
    {
        string message = "key:";
        message += str;

        SendData(message);
    }


}
