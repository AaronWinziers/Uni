package winziers;

import java.sql.Timestamp;
import java.util.TreeMap;
import java.util.concurrent.Semaphore;

public class Node {

	private final Network network;
	private final int nodeCount;
	private final MessageQueue messageQueue;
	private final Thread accessThread;
	private final Semaphore sem;

	private boolean stop;
	private int id;

	private Timestamp currentRequest;

	public Node(int id, Network network, int nodeCount) {
		this.id = id;
		this.network = network;
		this.nodeCount = nodeCount;
		this.stop = false;
		this.messageQueue = new MessageQueue();
		this.sem = new Semaphore(0);
		this.accessThread = new Thread(this::access);
		this.accessThread.start();
	}

	private void access() {
		while (!stop) {
			try {
				sleep();

				currentRequest = new Timestamp(System.currentTimeMillis());
				Message message = new Message(currentRequest, Message.MessageType.REQUEST, this.id);
				this.network.broadcast(message);

				this.sem.acquire(nodeCount - 1);
				while (!this.messageQueue.isFirst(message)) {
				}
				network.criticalSection(String.format("Node %2d @" + currentRequest.toString(), this.id));

				Timestamp timestamp = new Timestamp(System.currentTimeMillis());
				message = new Message(timestamp, Message.MessageType.RELEASE, this.id);
				network.broadcast(message);

			} catch (InterruptedException ignored) {
			}
		}
	}

	// Sleeps for a random amount of time 0-1000ms
	private void sleep() {
		try {
			Thread.sleep((long) (Math.random() * 1000));
		} catch (InterruptedException ignored) {
		}
	}

	public synchronized void addMessage(Message incoming) {
		switch (incoming.getMessageType()) {
			case ACK:
				if (incoming.getTimestamp().after(currentRequest)) {
					sem.release();
				}
				break;
			case REQUEST:
				Timestamp timestamp = new Timestamp(System.currentTimeMillis());
				Message message = new Message(timestamp, Message.MessageType.ACK, this.id);
				this.network.unicast(incoming.getSender(), message);
				messageQueue.put(incoming);
				break;
			case RELEASE:
				messageQueue.remove();
				break;
		}
	}

	public void stop() {
		System.out.format("Stopping Node %2d\n", this.id);
		stop = true;
		try {
			accessThread.join();
		} catch (InterruptedException ignored) {
		}
	}

	private class MessageQueue {
		final TreeMap<Timestamp, Message> queue;

		public MessageQueue() {
			this.queue = new TreeMap<>();
		}

		public void put(Message message) {
			synchronized (queue) {
				queue.put(message.getTimestamp(), message);
			}
		}

		public void remove() {
			synchronized (queue) {
				queue.remove(queue.firstKey());
			}
		}

		public boolean isFirst(Message message) {
			synchronized (queue) {
				return queue.firstKey().equals(message.getTimestamp());
			}
		}

	}
}
