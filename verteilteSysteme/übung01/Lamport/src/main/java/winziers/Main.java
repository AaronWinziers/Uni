package winziers;

public class Main {

	public static void main(String[] args) throws InterruptedException {
		if (args.length != 2) {
			System.out.println("arguments: <number of nodes> <duration in seconds>");
			System.exit(-1);
		}

		int nodeCount = Integer.parseInt(args[0]);
		int duration = Integer.parseInt(args[1]);

		System.out.printf("Simulate %d nodes for %d seconds\n", nodeCount, duration);

		Network network = new Network(nodeCount);
		Thread.sleep(1000 * duration);
		network.stop();

	}
}
