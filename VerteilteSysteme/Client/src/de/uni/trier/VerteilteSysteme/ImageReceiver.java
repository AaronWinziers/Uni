package de.uni.trier.VerteilteSysteme;

import javax.imageio.ImageIO;
import java.awt.image.BufferedImage;
import java.io.*;
import java.net.InetAddress;
import java.net.Socket;

public class ImageReceiver {

    Socket clientSocket;

    BufferedInputStream reader;

    public ImageReceiver(InetAddress ip, int port) throws Exception {

        clientSocket = new Socket(ip, port);

        reader = new BufferedInputStream(clientSocket.getInputStream());
    }

    public BufferedImage readImage() throws Exception {

        // Get first byte containing length of message to be received
        int msgLen = reader.read();

        // Wait until bytes have arrived
        while (reader.available() < msgLen) wait(1);

        // Read bytes from BufferedInputStream
        byte[] imgbytes = reader.readNBytes(msgLen);

        // Parse byte[] to BufferedImage
        BufferedImage img = ImageIO.read(new ByteArrayInputStream(imgbytes));

        return img;
    }

    public void closeSocket() throws Exception {
        clientSocket.close();
    }


}
