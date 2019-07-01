package de.unitrier.st.alg2svg;

import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.HashMap;
import java.util.Map;

public class Animation {
    private PrintWriter out;
    private Map<String, Element> elements; // SVG id -> SVG element
    private int portWidth;
    private int portHeight;
    private double time;
    private double step;

    public Animation(String filename) {
        this(filename, 520, 520);
    }

    public Animation(String filename, int portWidth, int portHeight) {
        this.elements = new HashMap<>();
        this.portWidth = portWidth;
        this.portHeight = portHeight;
        this.time = 0.0;
        this.step = 0.5;

        try {
            out = new PrintWriter(new FileWriter(filename));

            // GENERATE HEADER OF SVG-FILE
            out.println("<?xml version=\"1.0\"?>");
            out.println("<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\" \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">");
            out.println("<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"");
            out.printf("     version=\"1.1\" baseProfile=\"full\" width=\"%d\" height=\"%d\" viewport=\"0 0 %d %d\">\n",
                    portWidth, portHeight, portWidth, portHeight
            );
            out.println("");

        } catch (IOException e) {
            System.err.println("Problem when opening file " + e.getMessage());
        }
    }

    public void close() {
        out.println("</svg>");
        out.close();
    }

    private String quote(int value) {
        return "\"" + value + "\"";
    }

    private String quote(double value) {
        return "\"" + (int) value + "\"";
    }

    private String quote(String value) {
        return "\"" + value + "\"";
    }

    private int scaleX(double normalizedXPos) {
        return Math.round((float)(normalizedXPos * portWidth));
    }

    private int scaleY(double value) {
        return Math.round((float)(value * portHeight));
    }

    private int transformYPoint(double normalizedYPos) {
        return portHeight - scaleY(normalizedYPos);
    }

    private int transformYLine(double normalizedYPos, double normalizedHeight) {
        return portHeight - scaleY(normalizedYPos) - scaleY(normalizedHeight);
    }

    private void newElement(String id, double xPos, double yPos) {
        elements.put(id, new Element(id, xPos, yPos));
    }

    public Element getElement(String id) {
        return elements.get(id);
    }

    public void rectangle(String id, String color, double xPos, double yPos, double width, double height) {
        newElement(id, xPos, yPos);
        out.println("<rect id="+ quote(id) + " x=" + quote(scaleX(xPos)) + " y=" + quote(transformYLine(yPos, height))
                + " width=" + quote(scaleX(width)) + " height=" + quote(scaleY(height))
        );
        out.println("      style=\"fill:" + color + "\" />");
    }

    public void triangle(String id, String color,
                  double xPos1, double yPos1,
                  double xPos2, double yPos2,
                  double xPos3, double yPos3) {
        newElement(id, xPos1, yPos1);
        out.print("<polygon id=" + quote(id) + " style=\"fill:" + color + "\" ");
        out.println("points=\"" + scaleX(xPos1) + "," + transformYPoint(yPos1) + ","
                + scaleX(xPos2) + "," + transformYPoint(yPos2) + ","
                + scaleX(xPos3) + "," + transformYPoint(yPos3) + "\" />");
    }

    public void pointLine(String id, String color, double xPos1, double yPos1, double xPos2, double yPos2) {
        newElement(id, xPos1, yPos1);
        out.println("<line id=\"line\" stroke=\"" + color + "\" stroke-width=\"2\" stroke-dasharray=\"4 4\" ");
        out.println(" x1=" + quote(scaleX(xPos1)) + " y1=" + quote(transformYPoint(yPos1))
                + " x2=" + quote(scaleX(xPos2)) + " y2=" + quote(transformYPoint(yPos2)) + " />"
        );
    }

    private void step() {
        time = time + step;
    }

    public void moveRelative(Element element, double deltaX, double deltaY) {
        step();

        element.setXPos(element.getXPos() + deltaX);
        element.setYPos(element.getYPos() + deltaY);

        int deltaXScaled = scaleX(deltaX);
        int deltaYScaled = -scaleY(deltaY);
        out.println("<animateTransform xlink:href=\"#" + element.getId() + "\" begin=\"" + time + "s\" dur=\"" + step + "s\" fill=\"freeze\" additive=\"sum\"");
        out.println("  attributeName=\"transform\" attributeType=\"XML\" type=\"translate\" from=\"0,0\" to=\""
                + deltaXScaled + "," + deltaYScaled + "\" />"
        );
    }

    public void moveTo(Element element, double xPos, double yPos) {
        step();

        double deltaX = xPos - element.getXPos();
        double deltaY = yPos - element.getYPos();

        moveRelative(element, deltaX, deltaY);
    }

    public void moveTo(Element element, double xPos) {
        moveTo(element, xPos, element.getYPos());
    }
}
