using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.EventSystems;
using UnityEngine.UI;

public class ChatWrite : MonoBehaviour
{
    public NetworkController network;

    private InputField input;
   

    void Start()
    {
        input = gameObject.GetComponent<InputField>();
        var se = new InputField.SubmitEvent();
        se.AddListener(Submit);
        input.onEndEdit = se;

    }

    void Update()
    {
        if (EventSystem.current.currentSelectedGameObject == null)
        {
            EventSystem.current.SetSelectedGameObject(gameObject);
        }


    }

    private void Submit(string text)
    {
        network.SendMessage(text);
        input.text = "";

    }
}
