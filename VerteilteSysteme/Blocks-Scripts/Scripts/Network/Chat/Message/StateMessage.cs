using System;
using System.Collections.Generic;
using Newtonsoft.Json;
using UnityEngine;

class StateMessage : Message
{

    public string positions;

    public Dictionary<string, string> getPositions()
    {
        return JsonConvert.DeserializeObject<Dictionary<string, string>>(positions);
    }

    public Dictionary<string, Vector3> getPostionVectors()
    {
        Dictionary<string, string> positionsStr = getPositions();
        Dictionary<string, Vector3> positionsVector = new Dictionary<string, Vector3>();

        foreach (KeyValuePair<string, string> item in positionsStr)
        {
            string[] sArray =item.Value.Split(',');

            // store as a Vector3
            Vector3 vector = new Vector3(
                float.Parse(sArray[0]),
                float.Parse(sArray[1]),
                float.Parse(sArray[2]));

            positionsVector.Add(item.Key, vector);
        }

        return positionsVector;
     


    }
}

