using System.Collections.Generic;
using UnityEngine;

public class GenericWorld : MonoBehaviour
{

    public TextMesh worldName;

    private Queue<Vector3> movement = new Queue<Vector3>();

    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        if (movement.Count > 0)
        {
            gameObject.transform.position = movement.Dequeue();
        }
    }
    public void MoveTo(Vector3 vector)
    {
        movement.Enqueue(vector);
    }


}
