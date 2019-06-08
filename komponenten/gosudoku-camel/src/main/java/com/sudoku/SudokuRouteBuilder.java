package com.sudoku;

import org.apache.camel.Exchange;
import org.apache.camel.Processor;
import org.apache.camel.builder.RouteBuilder;

import java.util.HashMap;

public class SudokuRouteBuilder extends RouteBuilder {
    private String mqttHost;
    private String boxID;

    private static HashMap<String, String[]> neighbors = new HashMap<String, String[]>() {
        {
            put("box_a1", new String[]{"box_a4", "box_d1"});
            put("box_a4", new String[]{"box_a1", "box_a7", "box_d4"});
            put("box_a7", new String[]{"box_a4", "box_d7"});
            put("box_d1", new String[]{"box_a1", "box_d4", "box_g1"});
            put("box_d4", new String[]{"box_a4", "box_d1", "box_d7", "box_g4"});
            put("box_d7", new String[]{"box_d4", "box_a7", "box_g7"});
            put("box_g1", new String[]{"box_d1", "box_g4"});
            put("box_g4", new String[]{"box_g1", "box_d4", "box_g7"});
            put("box_g7", new String[]{"box_g4", "box_d7"});
        }
    };

    SudokuRouteBuilder(String mqttHost, String boxID) {
        this.mqttHost = mqttHost;
        this.boxID = boxID;
    }

    public void configure() {
        // ICH WEIß, DASS DIE KEYS NICHT INS ÖFFENTLICHE GIT SOLLTEN! IST MIR ABER EGAL. NACH DEM PROJEKT WERDEN DIE BOTS GELÖSCHT
        System.out.println("Setting up camel-routes");

        // Build Subscribe URI
        StringBuilder subscribeTopics = new StringBuilder();
        String sep = "";
        for (String neighbor: neighbors.get(this.boxID)) {
            subscribeTopics.append(sep).append("sudoku/").append(neighbor);
            sep = ",";
        }

        box .deb


        // Publish with own id
        from("telegram:bots/681997552:AAG-Ht8fMywQu6JtjerNdTPwZSrF8G1jBJY")
                .log("Received Telegram message. Forwarding it to MQTT-Topic.")
                .choice()
                    .when(body().startsWith("/ready"))
                        .bean(TelegramBot.class)
                        .to("mqtt:sudoku?host=" + this.mqttHost + "&publishTopicName=sudoku/" + boxID + "/result")
                    .otherwise()
                        .bean(TelegramBot.class)
                        .to("mqtt:sudoku?host=" + this.mqttHost + "&publishTopicName=sudoku/" + boxID);

        // Start Message
        from("mqtt:sudoku?subscribeTopicNames=sudoku/start")
                .log("Received start signal via MQTT from")
                .process(new Processor() {
                    public void process(Exchange exchange) throws Exception {
                        exchange.getIn().setBody("/start");
                    }
                })
                .to("telegram:bots/681997552:AAG-Ht8fMywQu6JtjerNdTPwZSrF8G1jBJY?chatId=-1001457965485");
    }
}
