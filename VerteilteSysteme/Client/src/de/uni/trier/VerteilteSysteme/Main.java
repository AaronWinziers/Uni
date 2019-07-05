package de.uni.trier.VerteilteSysteme;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.WindowEvent;
import java.awt.image.BufferedImage;
import java.net.InetAddress;
import java.net.UnknownHostException;

public class Main {

    static InetAddress ip;

    static int sendPort;
    static int receivePort;

    public static void main(String[] args) throws Exception {

        // create a new frame to stor text field and button
        JFrame f = new JFrame("Client Connector");


        JTextField ipField = new JTextField("IPAddress", 16);
        JTextField sendPortField = new JTextField("Send to Port", 16);
        JTextField receivePortField = new JTextField("Send to Port", 16);

        // create a new buttons
        JButton b = new JButton("Connect");

        b.addActionListener(actionEvent -> {
            try {
                ip = InetAddress.getByName(ipField.getText());

                sendPort = Integer.parseInt(sendPortField.getText());
                receivePort = Integer.parseInt(receivePortField.getText());

                System.out.println("Connecting to IP:sendPort:receivePort :: " + ip.toString() + ":" + sendPort + ":" + receivePort);

                f.dispatchEvent(new WindowEvent(f, WindowEvent.WINDOW_CLOSING));

                f = new DisplayWindow(new ImageReceiver(ip, receivePort), new InputSender(ip, sendPort));

            } catch (Exception e) {
                e.printStackTrace();
            }
        });

        // create a panel to add buttons
        JPanel p = new JPanel();

        // add buttons and textfield to panel
        p.add(ipField);
        p.add(sendPortField);
        p.add(receivePortField);
        p.add(b);


        // add panel to frame
        f.add(p);

        // set the size of frame
        f.setSize(300, 300);

        f.show();

         ImageReceiver imageReceiver = new ImageReceiver(address, "8083");
         InputSender inputSender = new InputSender(address, port);

         JFrame frame = new JFrame();

         frame.setSize(512, 512);

         JLabel imageLabel = new JLabel(new ImageIcon(imageReceiver.readImage()));
    }

}
