package oxoo2a;

import java.util.HashMap;

public class Main {

    public static void main(String[] args) throws InterruptedException {
        if (args.length != 2) {
            System.out.println("arguments: <number of nodes> <duration in seconds>");
            System.exit(-1);
        }
        int n_nodes = Integer.parseInt(args[0]);
        int duration = Integer.parseInt(args[1]); // in seconds

        System.out.printf("Simulate %d nodes for %d seconds\n",n_nodes,duration);

        // Create network
        Network network = new Network(n_nodes);

        // Create all nodes and start them
        HashMap<Integer, Node> nodes = new HashMap<Integer,Node>();
        for (int n_id=0; n_id<n_nodes; ++n_id)
            nodes.put(n_id,new Node(n_id,n_nodes,network));

        // Wait for the required duration
        Thread.sleep(duration * 1000);

        // Stop network - release nodes waiting in receive ...
        network.stop();

        // Tell all nodes to stop and wait for the threads to terminate
        for ( Node n : nodes.values() ) {
            n.stop();
        }

        System.out.println("All nodes stopped. Terminating.");
    }
}
