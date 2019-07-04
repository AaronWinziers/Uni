using System;
using UnityEngine;

public class ChatMessageOut : Message
{
    public string receiver;
    public string content;

    public ChatMessageOut(string receiver, string content)
    {
        this.receiver = receiver;
        this.content = content;
        this.type = "chat";
    }
}