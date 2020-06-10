import java.io.IOException;
import java.util.*;
import java.util.stream.StreamSupport;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.conf.Configured;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.util.Tool;
import org.apache.hadoop.util.ToolRunner;

public class AggregationA extends Configured implements Tool {

	public static class Map
			extends Mapper<Object, Text, IntWritable, IntWritable> {

		private IntWritable userID = new IntWritable();
		private final IntWritable one = new IntWritable(1);

		public void map(Object key, Text value, Context context
		) throws IOException, InterruptedException {
			HashMap<String, String> input = (HashMap<String, String>) MRDPUtils.transformXmlToMap(value.toString());

			if (input.containsKey("OwnerUserId")) {
				userID.set(Integer.parseInt(input.get("OwnerUserId")));
				context.write(userID, one);
			}
		}
	}

	public static class Reduce
			extends Reducer<IntWritable, IntWritable, IntWritable, IntWritable> {

		private IntWritable count = new IntWritable();

		public void reduce(IntWritable key, Iterable<IntWritable> values,
								 Context context
		) throws IOException, InterruptedException {
			count.set((int) StreamSupport.stream(values.spliterator(), false).count());
			context.write(key, count);
		}
	}

	@Override
	public int run(String[] args) throws Exception {
		Configuration conf = getConf();

		FileSystem fs = FileSystem.get(conf);
		if (fs.exists(new Path(args[1])))
			fs.delete(new Path(args[1]), true);

		Job job = Job.getInstance(conf, "Aggregate part a");
		job.setJarByClass(AggregationA.class);
		job.setMapperClass(Map.class);
		job.setReducerClass(Reduce.class);
		job.setMapOutputKeyClass(IntWritable.class);
		job.setMapOutputValueClass(IntWritable.class);
		job.setOutputKeyClass(IntWritable.class);
		job.setOutputValueClass(IntWritable.class);
		FileInputFormat.addInputPath(job, new Path(args[0]));
		FileOutputFormat.setOutputPath(job, new Path(args[1]));
		return job.waitForCompletion(true) ? 0 : 1;
	}

	public static void main(String[] args) throws Exception {
		ToolRunner.run(new Configuration(), new AggregationA(), args);
	}
}