import org.apache.hadoop.io.DoubleWritable;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.WritableComparable;

import java.io.DataInput;
import java.io.DataOutput;
import java.io.IOException;
import java.util.Objects;

public class Stats implements WritableComparable<Stats> {

	private IntWritable min, max, median;
	private DoubleWritable average;

	public void set(IntWritable min, IntWritable max, IntWritable median, DoubleWritable average) {
		this.min = min;
		this.max = max;
		this.median = median;
		this.average = average;
	}

	@Override
	public int compareTo(Stats stats) {
		int cmp = min.compareTo(stats.min);
		if (cmp == 0
				&& max.compareTo(stats.max) == 0
				&& median.compareTo(stats.median) == 0
				&& average.compareTo(stats.average) == 0) return 0;
		else return 1;
	}

	@Override
	public void write(DataOutput out) throws IOException {
		min.write(out);
		max.write(out);
		median.write(out);
		average.write(out);
	}

	@Override
	public void readFields(DataInput in) throws IOException {
		min.readFields(in);
		max.readFields(in);
		median.readFields(in);
		average.readFields(in);
	}

	@Override
	public boolean equals(Object o) {
		if (this == o) return true;
		if (!(o instanceof Stats)) return false;
		Stats stats = (Stats) o;
		return Objects.equals(min, stats.min) &&
				Objects.equals(max, stats.max) &&
				Objects.equals(median, stats.median) &&
				Objects.equals(average, stats.average);
	}

	@Override
	public int hashCode() {
		return Objects.hash(min, max, median, average);
	}

	@Override
	public String toString() {
		return "min=" + min.toString() +
				" max=" + max.toString() +
				" median=" + median.toString() +
				" average=" + average.toString();
	}
}