using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class PlayerMovement : MonoBehaviour
{

    public float speedAmp;
    public GameController gameController;

    private Vector3 m_movement;
    private float horizontalSpeed = 2.0f;
    private float verticalSpeed = 2.0f;
    private bool chatActive = false;

    // Start is called before the first frame update
    void Start()
    {

    }

    // Update is called once per frame
    void Update()
    {
        if (Input.GetKeyDown(KeyCode.C))
        {
            chatActive = true;
        }
        if (Input.GetKeyDown(KeyCode.Escape))
        {
            chatActive = false;
        }

        if (!chatActive)
        {
            m_movement = new Vector3(0f, 0f, 0f);


            // Jump to Nextworld
            if (Input.GetKeyDown(KeyCode.Tab))
            {
                transform.position = gameController.nextWorld().transform.position + new Vector3(0, 0, -4f);
                transform.rotation = Quaternion.identity;

            }

            // Vertical Movement
            if (Input.GetKey(KeyCode.Space))
            {
                m_movement += Vector3.up;

            }
            if (Input.GetKey(KeyCode.LeftShift))
            {
                m_movement += Vector3.down;
            }
            // Horizontal Movement

            float horizontal = Input.GetAxis("Horizontal");
            float vertical = Input.GetAxis("Vertical");

            m_movement += new Vector3(horizontal, 0f, vertical);
            m_movement.Normalize();

            // Camera controls
            float h = horizontalSpeed * Input.GetAxis("Mouse X");
            float v = verticalSpeed * Input.GetAxis("Mouse Y");

            transform.Rotate(-v, h, 0f);

            // Prevent z-axis rotation
            Quaternion q = transform.rotation;
            q.eulerAngles = new Vector3(q.eulerAngles.x, q.eulerAngles.y, 0);
            transform.rotation = q;
           
            transform.Translate(m_movement * speedAmp * Time.deltaTime);
        }


        
    }
}
