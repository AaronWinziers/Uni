using System;
using UnityEngine;

[Serializable]

public class BlockData
{
    public string x;
    public string y;
    public string z;
    public int templateId;

    public BlockData(string x, string y, string z, int templateId)
    {
        this.x = x;
        this.y = y;
        this.z = y;
        this.templateId = templateId;
    }

    public static BlockData create(Vector3 pos, int templateId)
    {
        return new BlockData(pos.x.ToString("N4"), pos.y.ToString("N4"), pos.z.ToString("N4"), templateId);
    }

    public static BlockData createFromGameObject(GameObject go)
    {
        Block block = go.GetComponent<Block>();
        Vector3 pos = block.transform.position;
        int templateId = block.getTextureIndex();

        return new BlockData(pos.x.ToString("N4"), pos.y.ToString("N4"), pos.z.ToString("N4"), templateId);
    }

    public static BlockData CreateFromJSON(string jsonString)
    {
        return JsonUtility.FromJson<BlockData>(jsonString);
    }

}
