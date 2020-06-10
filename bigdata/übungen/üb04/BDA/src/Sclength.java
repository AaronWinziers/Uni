import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.WritableComparable;

import java.io.DataInput;
import java.io.DataOutput;
import java.io.IOException;
import java.util.Objects;

public class Sclength implements WritableComparable<Sclength> {

	IntWritable score, length;

	public Sclength(){
		this.score = new IntWritable();
		this.length = new IntWritable();
	}

	public void set(IntWritable score, IntWritable length){
		this.score = score;
		this.length = length;
	}

	@Override
	public String toString() {
		return "Sclength{" +
				"score=" + score.toString() +
				", length=" + length.toString() +
				'}';
	}

	@Override
	public int compareTo(Sclength sclength) {
		int cmp = score.compareTo(sclength.score);
		if (cmp!=0){
			return cmp;
		} else {
			return length.compareTo(sclength.length);
		}
	}

	@Override
	public void write(DataOutput out) throws IOException {
		score.write(out);
		length.write(out);
	}

	@Override
	public void readFields(DataInput in) throws IOException {
		score.readFields(in);
		length.readFields(in);
	}

	@Override
	public boolean equals(Object o) {
		if (this == o) return true;
		if (!(o instanceof Sclength)) return false;
		Sclength sclength = (Sclength) o;
		return Objects.equals(score, sclength.score) &&
				Objects.equals(length, sclength.length);
	}

	@Override
	public int hashCode() {
		return Objects.hash(score, length);
	}
}
