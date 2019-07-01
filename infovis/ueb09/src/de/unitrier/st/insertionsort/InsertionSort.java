package de.unitrier.st.insertionsort;

import de.unitrier.st.alg2svg.Animation;
import de.unitrier.st.alg2svg.Element;

import java.util.Arrays;

public class InsertionSort {
    private static int maxValue = 10;
    private static int[] values;
    private static Element[] elements;
    private static Animation animation;
    private static double elementWidth;
    private static double elementHeight;
    private static double offset;

    public static void main(String[] args) {
        values = new int[]{5, 2, 7, 9, 4, 8, 3, 1, 10, 6};
        animation = new Animation("animation_insertionsort.svg");
        initAnimation();
        sort();
        animation.close();
    }

    private static void initAnimation() {
        // ---------- begin animation code ----------
        elements = new Element[values.length];
        elementWidth = 1.0/(values.length + 4);
        offset = 0.005;
        elementHeight = 1.0/(2*maxValue + 2);

        // rectangles for values
        double elementXPos = offset + elementWidth;
        double elementYPos = elementHeight;
        for (int i = 0; i < values.length; i++) {
            int value = values[i];
            elementXPos =  elementXPos + offset + elementWidth;
            double elementHeight = InsertionSort.elementHeight * value;
            animation.rectangle(String.valueOf(i),"blue", elementXPos, elementYPos, elementWidth, elementHeight);
            elements[i] = animation.getElement(String.valueOf(i));
        }

        // dashed line for progress
        elementXPos = 3 * elementWidth + 2.5 * offset;
        double yPosEnd = elementYPos + elementHeight * maxValue;
        animation.pointLine("line","red",
                elementXPos, elementYPos,
                elementXPos, yPosEnd
        );

        // triangle for current position
        double triangleWidth = elementWidth - 2 * offset;
        double xLeft = 2 * elementWidth + 3 * offset;
        double xTop = xLeft + triangleWidth / 2.0;
        double xRight = xLeft + triangleWidth;
        animation.triangle("tri","green",
                xLeft, 0.0,
                xTop, elementHeight,
                xRight, 0.0
        );
        // ---------- end animation code ----------
    }

    private static void sort() {
        System.out.println(Arrays.toString(values));

        // ---------- begin animation code ----------
        double elementYOffset = maxValue * elementHeight + 2 * offset;
        double elementXOffset = elementWidth + offset;
        // ---------- end animation code ----------

        for (int i = 1; i < values.length; i++) {
            int currentValue = values[i];
            Element currentElement = elements[i];
            int j = i - 1;

            // ---------- begin animation code ----------
            // move progress line
            animation.moveRelative(animation.getElement("line"), elementXOffset,0.0);
            // move triangle to current position
            animation.moveTo(animation.getElement("tri"), elements[i].getXPos());
            // move rectangle upwards
            animation.moveRelative(elements[i], 0.0, elementYOffset);
            // ---------- end animation code ----------

            while (j >= 0 && values[j] > currentValue) {
                values[j+1] = values[j];

                // ---------- begin animation code ----------
                elements[j+1] = elements[j];
                // move rectangle to the right
                animation.moveRelative(elements[j], elementXOffset, 0.0);
                // move triangle to new position
                animation.moveRelative(animation.getElement("tri"), -elementXOffset,0.0);
                // ---------- end animation code ----------

                j--;
            }

            values[j+1] = currentValue;

            // ---------- begin animation code ----------
            elements[j+1] = currentElement;
            // move rectangle sideways
            animation.moveTo(currentElement, animation.getElement("tri").getXPos());
            // move rectangle downwards
            animation.moveRelative(currentElement,0.0, -elementYOffset);
            // ---------- end animation code ----------
        }

        System.out.println(Arrays.toString(values));
    }
}
