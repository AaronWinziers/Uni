package oxoo2a;

import java.util.Random;

public class Node {

    public Node ( int my_id, int n_nodes, Network network ) {
        id = my_id;
        this.n_nodes = n_nodes;
        this.network = network;
        stop = false;
        random = new Random();
        t_main = new Thread(this::main);
        t_main.start();
    }

    private void sleep ( long millis ) {
        try {
            Thread.sleep(millis);
        }
        catch (InterruptedException e) {};
    }

    // Sample implementation is a a token ring simulation with node 0 issuing the first token
    private void main () {
        if (id == 0) {
            // I am node 1 and will create the token
            Message m = new Message()
                    .add("token","true")
                    .add("hopcount",0);
            network.unicast(id,(id+1) % n_nodes, m.toJson());
        }

        int loops = 0;
        while (true) {
            loops++;
            if (stop) break;
            Network.Message rm = network.receive(id);
            if (rm == null) break;

            Message m = Message.fromJson(rm.payload);

            int hopcount = Integer.parseInt(m.query("hopcount"));
            hopcount++;
            m.add("hopcount", hopcount);

            if ((id == 0) && (loops % 1000 == 0))
                System.out.printf("hopcount is %d\n",hopcount);

            network.unicast(id,(id+1) % n_nodes, m.toJson());
        }
    }

    public void stop () {
        stop = true;
        try {
            t_main.join();
        }
        catch (InterruptedException e) {};
    }

    private final int id;
    private final int n_nodes;
    private final Network network;
    private final Thread t_main;
    private boolean stop;
    private final Random random;
}
