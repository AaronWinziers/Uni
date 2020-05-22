package winziers;

import java.util.HashMap;

public class Network {

	private HashMap<Integer, Node> nodes;

	public Network(int nodeCount) {
		this.nodes = new HashMap<Integer, Node>();
		for (int i = 0; i < nodeCount; i++) {
			try {
				Thread.sleep(5);
			} catch (InterruptedException ignored) {}
			this.nodes.put(i, new Node(i, this, nodeCount));
		}
	}

	public void unicast(Integer receiver, Message message) {
		nodes.get(receiver).addMessage(message);
	}

	public void broadcast(Message message) {
		for (Node node : nodes.values()) {
			node.addMessage(message);
		}
	}

	// Purposely poorly written function that tries to provoke issues in the mutual exclusion
	public void criticalSection(String text) throws InterruptedException {
		for (char i : text.toCharArray()) {
			System.out.print(i);
			Thread.sleep(10);
		}
		System.out.println();
	}

	public void stop() {
		for (Node node: nodes.values()) {
			node.stop();
		}
	}
}
