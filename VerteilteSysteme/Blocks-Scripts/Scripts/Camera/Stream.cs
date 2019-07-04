using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Stream : MonoBehaviour
{

    public Camera cam;
    public Texture2D tex;
    public RenderTexture rt;
    Rect rectReadPicture = new Rect(0, 0, 256, 256);

    // Start is called before the first frame update
    void Start()
    {
        tex = new Texture2D(256, 256, TextureFormat.RGB24, false);

    }

    // Update is called once per frame
    void OnPostRender()
    {
        // Render to RenderTexture
        cam.targetTexture = rt;
        cam.Render();

        // Read pixels to texture
        RenderTexture.active = rt;
        tex.ReadPixels(rectReadPicture, 0, 0);

        // Read texture to array
        Color[] framebuffer = tex.GetPixels();

       
    }
}
