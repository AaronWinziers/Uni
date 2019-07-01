package de.unitrier.st.alg2svg;

public class Element {
    private String id;
    private double xPos;
    private double yPos;

    public Element(String id, double xPos, double yPos) {
        this.id = id;
        this.xPos = xPos;
        this.yPos = yPos;
    }

    public String getId() {
        return id;
    }

    public double getXPos() {
        return xPos;
    }

    public void setXPos(double xPos) {
        this.xPos = xPos;
    }

    public double getYPos() {
        return yPos;
    }

    public void setYPos(double yPos) {
        this.yPos = yPos;
    }
}