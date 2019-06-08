package com.sudoku;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class TelegramBot {
    private static Pattern pattern = Pattern.compile("/fieldconfig (box_a[147]),([0-2]),([0-2]):([1-9])");
    private static Pattern readyPattern = Pattern.compile("/ready (box_a[147]),(([1-9],)*([1-9]))");

    public String process(String message) {
        if (message == null) {
            return null;
        }

        if (message.startsWith("/ready")) {
            Matcher m = readyPattern.matcher(message);
            if (m.find()) {
                JSONArray resArr = new JSONArray();

                String[] rawRes = m.group(2).split(",");
                for (String el: rawRes) {
                    resArr.put(Integer.parseInt(el));
                }

                return new JSONObject()
                        .put("box", m.group(1))
                        .put("result", resArr)
                        .toString();
            }
        } else {
            Matcher m = pattern.matcher(message);
            if (m.find()) {
                return new JSONObject()
                        .put("box", "sudoku/" + m.group(1))
                        .put("r_column", m.group(2))
                        .put("r_row", m.group(3))
                        .put("value", m.group(4))
                        .toString();
            }
        }
        return null;
    }
}
