using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using System.Linq;

public class GameController : MonoBehaviour
{

    public GameObject player;
    public GameObject hud;
    public GameObject homeWorld;
    public GameObject world;
    public string playerName;

    private int currentWorldIndex = 0;
    private Dictionary<string, GameObject> worlds;
    private Queue<KeyValuePair<string, Vector3>> worldQ= new Queue<KeyValuePair<string, Vector3>>();

    // Start is called before the first frame update
    void Start()
    {

        worlds = new Dictionary<string, GameObject>();
        worlds.Add("home", homeWorld);

    }

    // Update is called once per frame
    void Update()
    {
        while (worldQ.Count > 0)
        {
            KeyValuePair<string, Vector3> worldPair = worldQ.Dequeue();

            GameObject createdWorld = Instantiate(world, worldPair.Value, Quaternion.identity);
            createdWorld.GetComponent<GenericWorld>().worldName.text = worldPair.Key;
            worlds.Add(worldPair.Key, createdWorld);

            Debug.Log("World created");
        }

    }

    public void createWorld(string name, Vector3 position)
    {
        if (name == playerName) name = "home";

        if (!worlds.ContainsKey(name))
        {
            worldQ.Enqueue(new KeyValuePair<string, Vector3>(name, position));
            
        }
        
    }

    public bool moveWorld(string name, Vector3 position)
    {
        if (name == playerName) name = "home";

        if (worlds.ContainsKey(name))
        {
            worlds[name].GetComponent<GenericWorld>().MoveTo(position);
            return true;
        }

        return false;
    }

    public bool updateWorlds()
    {
        return true;
    }

    public GameObject nextWorld()
    {
        string[] names = worlds.Keys.ToArray();
        
        currentWorldIndex = (currentWorldIndex + 1) % names.Length;
        return worlds[names[currentWorldIndex]];

    }

}
