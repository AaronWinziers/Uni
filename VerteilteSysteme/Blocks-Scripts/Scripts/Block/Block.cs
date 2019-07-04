using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Block : MonoBehaviour
{
    private int m_textureIndex;
    public Texture[] textures;

    // Start is called before the first frame update
    void Start()
    {
        m_textureIndex = 0;
        GetComponent<Renderer>().material.mainTexture = textures[m_textureIndex];
    }

    // Update is called once per frame
    void Update()
    {
        
    }

    public void setTextureIndex(int index)
    {
        m_textureIndex = index;
    }

    public int getTextureIndex() => m_textureIndex;

    public void nextTexture()
    {
        m_textureIndex = (m_textureIndex + 1) % (textures.Length);

        GetComponent<Renderer>().material.mainTexture = textures[m_textureIndex];
    }
    
}
