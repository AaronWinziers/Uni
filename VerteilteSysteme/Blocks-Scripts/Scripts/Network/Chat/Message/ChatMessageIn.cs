using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

class ChatMessageIn : Message
{
    public string sender;
    public string content;
    public bool world;

    public ChatMessageIn(string sender, string content, bool world)
    {
        this.sender = sender;
        this.content = content;
        this.world = world;
    }
}

