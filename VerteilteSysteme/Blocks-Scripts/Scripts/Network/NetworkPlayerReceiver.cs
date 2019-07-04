using System;
using System.Collections;
using System.Collections.Generic;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using UnityEngine;

public class NetworkPlayerReceiver : MonoBehaviour
{

    public float speedAmp = 5;
    public GameController gameController;
    public Raycaster raycaster;

    private Vector3 m_movement;
    private float horizontalSpeed = 2.0f;
    private float verticalSpeed = 2.0f;
    private bool chatActive = false;


 
    private const int port = 8182;

    Thread receiveThread;
    UdpClient client;

    Queue<Vector2> movementQueue = new Queue<Vector2>();
    Queue<Vector2> rotationQueue = new Queue<Vector2>();
    Queue<string> keyQueue = new Queue<string>();

    // Start is called before the first frame update
    void Start()
    {
           init();
    }

    // Start Receiver thread and open the port
    private void init()
    {

        Debug.Log("Starting Control Server...");

        receiveThread = new Thread(new ThreadStart(ListenForData));
        receiveThread.IsBackground = true;
        receiveThread.Start();

        Debug.Log("Control Server started...");

    }


    void ListenForData()
    {

        client = new UdpClient(port);
        while (true)
        {
            try
            {
                // Bytes empfangen.
                IPEndPoint anyIP = new IPEndPoint(IPAddress.Any, 0);
                byte[] data = client.Receive(ref anyIP);

                // Bytes mit der UTF8-Kodierung in das Textformat kodieren.
                string message = Encoding.UTF8.GetString(data);

                ParseData(message);

            }
            catch (Exception e)
            {
                Debug.Log(e.ToString());
            }

        }
    }



    // Update is called once per frame
    void Update()
    {
        string buttonPressed = "";

        if (keyQueue.Count > 0)
        {
            buttonPressed = keyQueue.Dequeue();
            raycaster.enqueue(buttonPressed);
        }


        if (buttonPressed == "C")
        {
            chatActive = true;
        }
        if (buttonPressed == "Escape")
        {
            chatActive = false;
        } 

        if (!chatActive)
        {

            m_movement = new Vector3(0f, 0f, 0f);

            // Jump to Nextworld
            if (buttonPressed == "Tab")
            {
                transform.position = gameController.nextWorld().transform.position + new Vector3(0, 0, -4f);
                transform.rotation = Quaternion.identity;

            }

            // Vertical Movement
            if (buttonPressed == "Space")
            {
                m_movement += Vector3.up;

            }
            
            // Horizontal Movement
            if (buttonPressed == "LeftShift")
            {
                m_movement += Vector3.down;
            }

                       
            if(movementQueue.Count > 0)
            {
                Vector2 moveInput = movementQueue.Dequeue();

                m_movement += new Vector3(moveInput.x, 0f, moveInput.y);
                m_movement.Normalize();

            }

            transform.Translate(m_movement * speedAmp * Time.deltaTime);

            // Camera controls
            if (rotationQueue.Count > 0)
            {
                Vector2 valuePair = rotationQueue.Dequeue();

                // X = Horizontal, Y = Vertical
                transform.Rotate(-valuePair.y, valuePair.x, 0f);

                // Prevent z-axis rotation
                Quaternion q = transform.rotation;
                q.eulerAngles = new Vector3(q.eulerAngles.x, q.eulerAngles.y, 0);

                transform.rotation = q;
            }    

        }
    }


    void ParseData(string str)
    {
        string[] message = str.Split(':');
        if (str == "" || message.Length < 1) return;
        
        string type = message[0];
        string data = message[1];
        switch(type)
        {
            case "vector":
                if (movementQueue.Count < 5) movementQueue.Enqueue(StringToVector2(data));
                break;
            case "quaternion":
                rotationQueue.Enqueue(StringToVector2(data));
                break;
            case "key":
            default:
                keyQueue.Enqueue(data);
                break;
        }
    }


    Vector2 StringToVector2(string str)
    {
        // Remove the parentheses
        if (str.StartsWith("(") && str.EndsWith(")"))
        {
            str = str.Substring(1, str.Length - 2);
        }

        // split the items
        string[] sArray = str.Split(',');

        float tmp;
        foreach (string s in sArray)
        {
            if (!float.TryParse(s, out tmp)) return new Vector2();
        }

        // store as a Vector2
        Vector2 result = new Vector2(
            float.Parse(sArray[0]),
            float.Parse(sArray[1]));


        return result;
    }


    Vector3 StringToVector3(string str)
    {
        // Remove the parentheses
        if (str.StartsWith("(") && str.EndsWith(")"))
        {
            str = str.Substring(1, str.Length - 2);
        }

        // split the items
        string[] sArray = str.Split(',');

        float tmp;
        foreach (string s in sArray)
        {
            if (!float.TryParse(s, out tmp)) return new Vector3();
        }

        // store as a Vector3
        Vector3 result = new Vector3(
            float.Parse(sArray[0]),
            float.Parse(sArray[1]),
            float.Parse(sArray[2]));

        return result;
    }

}
