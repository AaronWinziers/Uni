using System;
using UnityEngine;

[Serializable]

public class HelloMsg: Message
{
    public string name;

    public HelloMsg(string name)
    {
        this.name = name;
        this.type = "hello";
    }
}
