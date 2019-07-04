using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Raycaster : MonoBehaviour
{
    public Camera camera;
    public GameObject previewBlock;
    public GameObject world;

    private Queue<string> input = new Queue<string>();

    private int previewBlockDistance = 8;
    private int layerMask;
    private bool chatActive = false;

    float t;
    Vector3 startPosition;
    Vector3 target;
    float timeToReachTarget;


    void Start()
    {
        layerMask = 1 << 9;
        layerMask = ~layerMask;

        startPosition = target = transform.position;

    }
    void Update()
    {

        string buttonPressed = "";

        if (input.Count > 0)
        {
            buttonPressed = input.Dequeue();
        }

        if (buttonPressed.Equals("C"))
        {
            chatActive = true;
        }
        if (buttonPressed.Equals("Escape"))
        {
            chatActive = false;
        }

        if (!chatActive)
        {
            RaycastHit hit;
            Ray ray = new Ray(camera.transform.position, camera.transform.forward);

            Debug.DrawRay(camera.transform.position, camera.transform.forward*10, Color.green);
            Physics.Raycast(camera.transform.position, camera.transform.forward, out hit, Mathf.Infinity, layerMask);

            // Set the block to the previewBlockDistance
            // if a collider is hit, this is overwritten by the normal of the hit block

            Vector3 previewBlockPosition = ray.origin + (ray.direction * previewBlockDistance);
            previewBlockPosition = floorVector(previewBlockPosition);

            if (hit.collider != null)
            {
                Vector3 hitBlock = hit.transform.position;
                Vector3 hitBlockFloored = floorVector(hitBlock);
                previewBlockPosition = hitBlockFloored + hit.normal;



                // Delete Block
                if (buttonPressed.Equals("RightClick"))
                {
                    world.GetComponent<World>().deleteBlock(hitBlockFloored);
                }

                // Move infront of Block
                // TODO move smoothly
                if (buttonPressed.Equals("E"))
                {
                    transform.position = hit.transform.position + (hit.normal * 5);
                }

                // Change Texture
                if (buttonPressed.Equals("R"))
                {
                    GameObject block;
                    if ((block = world.GetComponent<World>().getBlock(hitBlockFloored)) != null)
                    {
                        block.GetComponent<Block>().nextTexture();
                    }
                }
            }

            

            //Create Block
            if (buttonPressed.Equals("LeftClick"))
            {
                world.GetComponent<World>().createBlock(previewBlockPosition, 0);
            }

            previewBlock.transform.rotation = Quaternion.identity;
            previewBlock.transform.position = previewBlockPosition;
        }

        
        
    }

    public void enqueue(string str)
    {
        input.Enqueue(str);
    }

    private Vector3 floorVector(Vector3 vector)
    {
        vector.x = (float)System.Math.Round(vector.x);
        vector.y = (float)System.Math.Round(vector.y);
        vector.z = (float)System.Math.Round(vector.z);

        return vector;
    }


}