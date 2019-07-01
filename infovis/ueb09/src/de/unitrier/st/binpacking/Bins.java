package de.unitrier.st.binpacking;

class Bins {

    private Bin[] bins;

    Bins(int amount, int capacity) {
        bins = new Bin[amount];

        for (int i = 0; i < amount; i++) {
            bins[i] = new Bin(capacity);
        }
    }

    boolean fill(Items items) {
        Item[] array = items.getArray();

        for (Item item : array) {
            int i = 0;

            while (!bins[i].insert(item)) {
                i++;
                if (i == bins.length) {
                    System.out.println("Item " + item + " could not be stored.");
                    return false;
                }
            }
        }

        System.out.println("All items stored.");
        return true;
    }

    Bin[] getArray() {
        return bins;
    }
}
