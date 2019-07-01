package de.unitrier.st.binpacking;

import java.util.Random;

class Items {
    private Item[] items;

    Items(int amount, int minSize, int maxSize) {
        items = new Item[amount];
        Random rand = new Random();

        for (int i=0; i<amount; i++) {
            // nextInt is normally exclusive of the top value,
            // so add 1 to make it inclusive
            items[i] = new Item(rand.nextInt((maxSize-minSize)+1) + minSize);
        }
    }

    Item[] getArray() {
        return items;
    }
}
