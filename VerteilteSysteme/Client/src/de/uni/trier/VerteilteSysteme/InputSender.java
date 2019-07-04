package de.uni.trier.VerteilteSysteme;

import java.net.*;

public class InputSender {

    private DatagramSocket socket;
    private InetAddress address;
    private int port;

    public InputSender(String IP, String port) throws Exception {
        this.socket = new DatagramSocket();

        this.address = InetAddress.getByName(IP);

        this.port = Integer.parseInt(port);
    }

    public void sendInput(String input) throws Exception {
        // Convert input string to byte array
        byte[] buf = input.getBytes();

        // Build UDP DatagramPacket
        DatagramPacket packet
                = new DatagramPacket(buf, buf.length, address, port);

        // Send packet
        socket.send(packet);
    }

    public void closeSocket() {
        socket.close();
    }
}
