package de.unitrier.st.binpacking;

import de.unitrier.st.alg2svg.Animation;

public class BinPacking {
    private static Animation animation;

    public static void main (String[] args) {
        animation = new Animation("animation_binpacking.svg");

        Bins bins = new Bins(5, 100);
        bins.fill(new Items(30, 1, 32));

        System.out.println();
        System.out.println("Bins:");
        System.out.println();
        for (Bin b : bins.getArray()) {
            System.out.println(b);
            System.out.println();
        }

        animation.close();
    }
}
