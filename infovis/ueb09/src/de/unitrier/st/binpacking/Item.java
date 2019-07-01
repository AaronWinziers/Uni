package de.unitrier.st.binpacking;

class Item {

    private final int size;

    Item(int size) {
        this.size = size;
    }

    int getSize() {
        return size;
    }

    public String toString() {
        return Integer.toString(size);
    }
}
