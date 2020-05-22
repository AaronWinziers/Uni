package winziers;

import java.sql.Timestamp;

public class Message {

	public enum MessageType {REQUEST, ACK, RELEASE}

	private Timestamp timestamp;
	private MessageType messageType;
	private Integer sender;

	public Message(Timestamp timestamp, MessageType messageType, Integer sender) {
		this.timestamp = timestamp;
		this.messageType = messageType;
		this.sender = sender;
	}

	public Integer getSender() {
		return sender;
	}

	public MessageType getMessageType() {
		return messageType;
	}

	public Timestamp getTimestamp() {
		return timestamp;
	}
}
