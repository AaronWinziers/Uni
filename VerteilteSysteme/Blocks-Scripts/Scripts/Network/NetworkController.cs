using System;
using System.Collections;
using System.Collections.Generic;
using System.Linq;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using UnityEngine;



public class NetworkController : MonoBehaviour
{
    public Chat chat;
    public World world;
    public GameObject netWorld;
    public GameController gameController;

    private TcpClient socketConnection;
    private Thread clientReceiveThread;

   
    // Setup socket connection. 	
    private void ConnectToTcpServer(string ipAddress, int port)
    {
        try
        {
            clientReceiveThread = new Thread(() => ListenForData(ipAddress, port));
            clientReceiveThread.IsBackground = true;
            clientReceiveThread.Start();

        }
        catch (Exception e)
        {
            Debug.Log("On client connect exception " + e);
        }
    }
    
    // Runs in background clientReceiveThread; Listens for incomming data. 	
    private void ListenForData(string ipAddress, int port)
    {
        try
        {

            socketConnection = new TcpClient(ipAddress, port);
            chat.addMessage($"Verbunden mit {ipAddress}:{port}");
            Byte[] bytes = new Byte[1024];
            while (true)
            {
                // Get a stream object for reading 				
                using (NetworkStream stream = socketConnection.GetStream())
                {
                    int length;
                    // Read incomming stream into byte arrary. 					
                    while ((length = stream.Read(bytes, 0, bytes.Length)) != 0)
                    {
                        var incommingData = new byte[length];
                        Array.Copy(bytes, 0, incommingData, 0, length);
                        // Convert byte array to string message. 						
                        string serverMessage = Encoding.UTF8.GetString(incommingData);
                        Message message = JsonUtility.FromJson<Message>(serverMessage);
                        
                        ReceiveMessage(message.type, serverMessage);

                    }
                }
            }
        }
        catch (SocketException socketException)
        {
            chat.addMessage("Could not connect to " + ipAddress);
            Debug.Log("Socket exception: " + socketException);
        }
    }
    
    private bool SendData(string data)
    {
        if (socketConnection != null)
        {
            try
            {
                // Get a stream object for writing. 			
                NetworkStream stream = socketConnection.GetStream();
                if (stream.CanWrite)
                {
                    data += "\n";
                    // Convert string message to byte array.                 
                    byte[] clientMessageAsByteArray = Encoding.UTF8.GetBytes(data);
                    // Write byte array to socketConnection stream.                 
                    stream.Write(clientMessageAsByteArray, 0, clientMessageAsByteArray.Length);
                    Debug.Log("Message Sent: " + data);
                    return true;
                }
            }
            catch (SocketException socketException)
            {
                Debug.Log("Socket exception: " + socketException);
            }
        }
        chat.addMessage("Nachricht konnte nicht gesendet werden");
        return false;
    }

    // Send message to server using socket connection. 	
    public new bool SendMessage(string message)
    {

        string[] tokens = message.Split(' ');
        if (!tokens[0].StartsWith("/")) return false;

        switch (tokens[0])
        {
            case "/connect":
                if (tokens.Length < 3) return false;

                try
                {
                    int result = Int32.Parse(tokens[2]);
                    ConnectToTcpServer(tokens[1], result);
                    return true;

                }
                catch (FormatException)
                {
                    Console.WriteLine($"Unable to parse '{tokens[2]}'");
                }
                return false;


            case "/all":
                if (tokens.Length < 2) return false;
                ChatMessageOut worldMsg;
                worldMsg = new ChatMessageOut("world", string.Join(" ", tokens.Skip(1)));
                if (SendData(JsonUtility.ToJson(worldMsg))) chat.addMessage(string.Format("[Ich an alle]: {0}", worldMsg.content));
                break;

            case "/hello":
                if (tokens.Length < 2) return false;
                HelloMsg helloMsg = new HelloMsg(tokens[1]);
                if (SendData(JsonUtility.ToJson(helloMsg)))
                {
                    chat.addMessage("Hallo Server, ich heiße " + tokens[1]);
                    gameController.playerName = tokens[1];
                }
                break;

            case "/to":
                ChatMessageOut chatMsg;
                if (tokens.Length > 2)
                {
                    chatMsg = new ChatMessageOut(tokens[1], string.Join(" ", tokens.Skip(2)));
                } else
                {
                    chatMsg = new ChatMessageOut(tokens[1], "");
                }
                if (SendData(JsonUtility.ToJson(chatMsg))) chat.addMessage(string.Format("[Ich an {0}]: {1}", chatMsg.receiver, chatMsg.content));
                break;

            case "/clear":
                chat.clearMessages();
                break;

            case "/getstate":
                GetStateMessage getStateMessage = new GetStateMessage();
                SendData(JsonUtility.ToJson(getStateMessage));
                break;

        }
        return false;
    }

    public void ReceiveMessage(string type, string message)
    {
        switch (type)
        {
            case "welcome":
                WelcomeMsg welcomeMsg = JsonUtility.FromJson<WelcomeMsg>(message);
                chat.addMessage($"[Server]: Du bist an Position ({welcomeMsg.position})");
                world.MoveTo(StringToVector3(welcomeMsg.position));
                break;

            case "chat":
                ChatMessageIn chatMsg = JsonUtility.FromJson<ChatMessageIn>(message);
                chat.addMessage(string.Format("[{0}]: {1}", chatMsg.world ? chatMsg.sender + " an Alle": chatMsg.sender, chatMsg.content));
                break;

            case "end":
                chat.addMessage("[Sever]: Verbindung beendet");
                break;

            case "state":
                StateMessage stateMsg = JsonUtility.FromJson<StateMessage>(message);
                chat.addMessage("[Server]: Neue Positionen");

                foreach (KeyValuePair<string, string> item in stateMsg.getPositions())
                {
                    chat.addMessage($"[Server]: {item.Key} bei {item.Value}");
                }

                foreach (KeyValuePair<string, Vector3> item in stateMsg.getPostionVectors())
                {
                    gameController.createWorld(item.Key, item.Value);
                }



                break;
        }
    }
    
    public static Vector3 StringToVector3(string sVector)
    {
        // split the items
        string[] sArray = sVector.Split(',');

        // store as a Vector3
        Vector3 result = new Vector3(
            float.Parse(sArray[0]),
            float.Parse(sArray[1]),
            float.Parse(sArray[2]));

        return result;
    }

}