import java.io.DataInput;
import java.io.DataOutput;
import java.io.IOException;
import java.util.*;
import java.util.stream.Collectors;
import java.util.stream.StreamSupport;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.conf.Configured;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.DoubleWritable;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.io.WritableComparable;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.util.Tool;
import org.apache.hadoop.util.ToolRunner;

public class AggregationB extends Configured implements Tool {

	public static class Map
			extends Mapper<Object, Text, IntWritable, IntWritable> {

		private final IntWritable userID = new IntWritable();
		private final IntWritable length = new IntWritable();
		private int count = 0;

		public void map(Object key, Text value, Context context
		) throws IOException, InterruptedException {
			HashMap<String, String> input = (HashMap<String, String>) MRDPUtils.transformXmlToMap(value.toString());

			if (input.containsKey("OwnerUserId") && input.containsKey("Title")) {
				count++;
				userID.set(Integer.parseInt(input.get("OwnerUserId")));
				String title = input.get("Title");
				length.set(title.length());
				context.write(userID, length);
			}
		}
	}

	public static class Reduce
			extends Reducer<IntWritable, IntWritable, IntWritable, Stats> {

		private IntWritable min = new IntWritable();
		private IntWritable max = new IntWritable();
		private IntWritable median = new IntWritable();
		private DoubleWritable average = new DoubleWritable();
		private Stats result = new Stats();

		public void reduce(IntWritable key, Iterable<IntWritable> values,
								 Context context
		) throws IOException, InterruptedException {
			ArrayList<Integer> vals = StreamSupport.stream(values.spliterator(), false).map(IntWritable::get).collect(Collectors.toCollection(ArrayList::new));

			min.set(vals.stream().min(Integer::compare).get());
			max.set(vals.stream().max(Integer::compare).get());
			average.set(vals.stream().mapToDouble(a -> a).average().getAsDouble());
			Collections.sort(vals);
			median.set(vals.get((int) Math.ceil(vals.size() / 2)));

			result.set(min, max, median, average);
			context.write(key, result);
		}
	}

	@Override
	public int run(String[] args) throws Exception {
		Configuration conf = getConf();

		FileSystem fs = FileSystem.get(conf);
		if (fs.exists(new Path(args[1])))
			fs.delete(new Path(args[1]), true);

		Job job = Job.getInstance(conf, "Aggregate part b");
		job.setJarByClass(AggregationB.class);
		job.setMapperClass(Map.class);
		job.setReducerClass(Reduce.class);
		job.setMapOutputKeyClass(IntWritable.class);
		job.setMapOutputValueClass(IntWritable.class);
		job.setOutputKeyClass(IntWritable.class);
		job.setOutputValueClass(Stats.class);
		FileInputFormat.addInputPath(job, new Path(args[0]));
		FileOutputFormat.setOutputPath(job, new Path(args[1]));
		return job.waitForCompletion(true) ? 0 : 1;
	}

	public static void main(String[] args) throws Exception {
		ToolRunner.run(new Configuration(), new AggregationB(), args);
	}
}