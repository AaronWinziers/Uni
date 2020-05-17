import java.io.IOException;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.conf.Configured;
import org.apache.hadoop.fs.*;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.util.Tool;
import org.apache.hadoop.util.ToolRunner;

public class Grep extends Configured implements Tool {

	public static class Map
			extends Mapper<Object, Text, IntWritable, IntWritable> {

		private final IntWritable docid = new IntWritable();

		public void map(Object key, Text value, Context context
		) throws IOException, InterruptedException {
			String input = value.toString().toLowerCase();
			String word = context.getConfiguration().get("word").toLowerCase();

			if (input.contains(word)) {
				docid.set(Integer.parseInt(input.substring(0, input.indexOf(":")).replaceAll("\\s","")));
				context.write(docid, null);
			}
		}
	}

	@Override
	public int run(String[] args) throws Exception {
		Configuration conf = getConf();
		conf.set("word", args[2]);

		FileSystem fs = FileSystem.get(conf);
		if (fs.exists(new Path(args[1])))
			fs.delete(new Path(args[1]), true);

		Job job = Job.getInstance(conf, "grep");
		job.setJarByClass(Grep.class);
		job.setMapperClass(Map.class);
		job.setNumReduceTasks(0);
		job.setOutputKeyClass(IntWritable.class);
		job.setOutputValueClass(IntWritable.class);
		FileInputFormat.addInputPath(job, new Path(args[0]));
		FileOutputFormat.setOutputPath(job, new Path(args[1]));
		return job.waitForCompletion(true) ? 0 : 1;
	}

	public static void main(String[] args) throws Exception {
		ToolRunner.run(new Configuration(), new Grep(), args);
	}
}