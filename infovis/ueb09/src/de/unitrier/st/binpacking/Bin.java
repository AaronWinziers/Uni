package de.unitrier.st.binpacking;

import java.util.LinkedList;
import java.util.List;

class Bin {
    private int maxCapacity;
    private int remainingCapacity;
    private List<Item> content;

    Bin(int capacity) {
        maxCapacity = capacity;
        remainingCapacity = capacity;
        content = new LinkedList<>();
    }

    boolean insert(Item i) {
        if (i.getSize() <= remainingCapacity) {
            content.add(i);
            remainingCapacity -= i.getSize();
            return true;
        } else {
            return false;
        }
    }

    public String toString() {
        StringBuilder result = new StringBuilder();
        result.append("---\n")
                .append(maxCapacity)
                .append("\n")
                .append("---\n");
        for (Item i : content) {
            result.append(i.toString())
                    .append("\n");
        }
        result.append("---\n")
                .append(remainingCapacity).append("\n")
                .append("---\n");
        return result.toString();
    }
}
