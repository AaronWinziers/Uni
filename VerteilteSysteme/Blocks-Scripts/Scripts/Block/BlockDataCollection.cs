using System;
using System.Collections;
using System.Collections.Generic;

[Serializable]
public class BlockDataCollection
{
    public List<BlockData> data;

    public BlockDataCollection()
    {
        data = new List<BlockData>();
    }
    
}
