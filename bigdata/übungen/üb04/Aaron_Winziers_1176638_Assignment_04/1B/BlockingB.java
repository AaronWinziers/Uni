import java.io.IOException;
import java.util.*;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.conf.Configured;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.util.Tool;
import org.apache.hadoop.util.ToolRunner;

public class BlockingB extends Configured implements Tool {

	public static class Map
			extends Mapper<Object, Text, Text, Text> {

		private final Text name = new Text();
		private final Text block = new Text();

		public void map(Object key, Text value, Context context
		) throws IOException, InterruptedException {
			String input = value.toString();
			if (input.equals("# OLD_NAME, NEW_NAME")) {
				// Does not read any lines in file after the first without this
				// BlockingA works fine, but this one doesn't want to
				input = "";
			}

			String[] pair = input.split(",");

			for (String entry : pair) {
				String[] parts = entry.trim().split("\\s");
				try {
					String blockName = parts[0].toCharArray()[0] + parts[parts.length - 1];
					name.set(entry);
					block.set(blockName);
					context.write(block, name);
				} catch (IndexOutOfBoundsException ignored) { //Had to be caught because of improperly formatted data
				}
			}

		}
	}

	public static class Reduce
			extends Reducer<Text, Text, Text, Text> {

		private final Text output = new Text();

		public void reduce(Text key, Iterable<Text> values,
								 Context context
		) throws IOException, InterruptedException {

			ArrayList<String> names = new ArrayList<>();
			boolean found = false;
			for (Text value : values) {
				names.add(value.toString());
				if (value.toString().contains("Michael") && value.toString().contains("Miller")) {
					found = true;
				}
			}
			if (found) {
				for (String val : names) {
					output.set(val);
					context.write(key, output);
				}
			}
		}
	}

	@Override
	public int run(String[] args) throws Exception {
		Configuration conf = getConf();

		FileSystem fs = FileSystem.get(conf);
		if (fs.exists(new Path(args[1])))
			fs.delete(new Path(args[1]), true);

		Job job = Job.getInstance(conf, "blocking hybrid key");
		job.setJarByClass(BlockingB.class);
		job.setMapperClass(Map.class);
		job.setReducerClass(Reduce.class);
		job.setMapOutputKeyClass(Text.class);
		job.setMapOutputValueClass(Text.class);
		job.setOutputKeyClass(Text.class);
		job.setOutputValueClass(Text.class);
		FileInputFormat.addInputPath(job, new Path(args[0]));
		FileOutputFormat.setOutputPath(job, new Path(args[1]));
		return job.waitForCompletion(true) ? 0 : 1;
	}

	public static void main(String[] args) throws Exception {
		ToolRunner.run(new Configuration(), new BlockingB(), args);
	}
}