package com.sudoku;

import org.json.JSONObject;

public class MQTTConverter {

    public String process(String message) {
        if (message == null) {
            return null;
        }

        JSONObject json = new JSONObject(message);

        return "/fieldconfig " +
                json.get("box").toString().replace("sudoku/", "") +
                "," +
                json.get("r_column") +
                "," +
                json.get("r_row") +
                ":" +
                json.get("value");
    }
}
