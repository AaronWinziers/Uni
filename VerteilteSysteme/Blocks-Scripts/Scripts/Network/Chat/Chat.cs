using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.EventSystems;
using UnityEngine.UI;
public class Chat : MonoBehaviour
{
    public GameObject chatRead;
    public GameObject chatWrite;


    private List<string> chatMessages = new List<string>();

    // Start is called before the first frame update
    void Start()
    {
        chatWrite.SetActive(false);
    }

    // Update is called once per frame
    void Update()
    {

        if (Input.GetKeyDown(KeyCode.C))
        {
            chatWrite.SetActive(true);
            //chatWrite.GetComponent<InputField>().Select();
            EventSystem.current.SetSelectedGameObject(chatWrite);
        }
        if (Input.GetKeyDown(KeyCode.Escape))
        {        
            chatWrite.SetActive(false);
        }
            

        chatRead.GetComponent<Text>().text = string.Join("\n", chatMessages);
    }

    public void addMessage(string msg)
    {
        chatMessages.Add(msg);
    }
    public void clearMessages()
    {
        chatMessages.Clear();
    }


}
