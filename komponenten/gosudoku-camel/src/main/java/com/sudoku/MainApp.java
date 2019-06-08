/*
*
* Arguments: http://localhost /home/michaelwolz/go/src/github.com/michaelwolz/gosudoku/cmd/sudokuSolver/sudokuSolver
*
* */

package com.sudoku;

import org.apache.camel.main.Main;

import com.sun.jersey.api.client.Client;
import com.sun.jersey.api.client.ClientResponse;
import com.sun.jersey.api.client.WebResource;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import static java.lang.System.exit;


public class MainApp {

    private static String boxmanagerURL;
    private static String gosudokuPath;

    public static void main(String... args) {
        if (args.length < 2) {
            System.err.println("Please provide boxmanager url and path to gosudoku!");
            exit(0);
        }
        boxmanagerURL = args[0];
        gosudokuPath = args[1];
        initialize();
    }

    // Sign in to boxmanager and receive initial config
    private static void initialize() {
        try {
            String result = getRequest(boxmanagerURL + "/api/initialize");
            if (result != null) {
                JSONObject json = new JSONObject(result);
                String boxID = json.get("box").toString().replace("sudoku/", "");
                String mqttHost = "tcp://" + json.get("mqtt-ip").toString() + ":" + json.get("mqtt-port").toString();
                JSONArray init = json.getJSONArray("init");

                StringBuilder initialConfig = new StringBuilder();
                for (int i = 0; i < init.length(); i++) {
                    JSONObject conf = init.getJSONObject(i);
                    Iterator<String> keys = conf.keys();
                    while(keys.hasNext()) {
                        String key = keys.next();
                        initialConfig.append(key).append(":").append(conf.get(key).toString());
                    }
                    if (i < init.length() - 1) {
                        initialConfig.append(",");
                    }
                }


                // Start gosudoku process
                startSolver(initialConfig.toString(), boxID);

                // Initializing camel routes
                Main main = new Main();
                main.addRouteBuilder(new SudokuRouteBuilder(mqttHost, boxID));
                main.run();

                // Tell boxmanager that we are ready
                getRequest(boxmanagerURL + "/api/ready?box=sudoku/" + boxID);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    // Starts gosudoku process with initial config
    private static void startSolver(String initialConfig, String boxID) {
        List<String> commands = new ArrayList<String>();
        commands.add(gosudokuPath);
        commands.add("-initialConfig=" + initialConfig);
        commands.add("-boxID=" + boxID);

        ProcessBuilder pb = new ProcessBuilder();
        pb.command(commands);
        System.out.println("Starting sudoku solver process: " + commands);
        try {
            Process p = pb.start();
        } catch (Exception e) {
            e.printStackTrace();
        }

    }

    private static String getRequest(String url) {
        try {

            Client client = Client.create();

            WebResource webResource = client.resource(url);

            ClientResponse response = webResource.accept("application/json").get(ClientResponse.class);

            if (response.getStatus() != 200) {
                throw new RuntimeException("Failed : HTTP error code : "
                        + response.getStatus());
            }

            return response.getEntity(String.class);

        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }

    /* private static void postRequest(String url, String result) {
        try {

            Client client = Client.create();

            WebResource webResource = client.resource(url);

            ClientResponse response = webResource.type("application/json").post(ClientResponse.class, result);

            if (response.getStatus() != 201) {
                throw new RuntimeException("Failed : HTTP error code : "
                        + response.getStatus());
            }

            String output = response.getEntity(String.class);
            System.out.println(output);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }*/
}


