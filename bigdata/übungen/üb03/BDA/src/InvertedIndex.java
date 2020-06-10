import java.io.IOException;
import java.util.*;

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

public class InvertedIndex extends Configured implements Tool {

	public static class Map
			extends Mapper<Object, Text, Text, IntWritable> {

		private final static IntWritable one = new IntWritable(1);
		private Text word = new Text();

		public void map(Object key, Text value, Context context
		) throws IOException, InterruptedException {
			String input = value.toString();
			int docnum = Integer.parseInt(input.substring(0, input.indexOf(":")).replaceAll("\\s", ""));

			input = input.replace('\"', ' ')
					.replace('!', ' ')
					.replace('\'', ' ')
					.replace('?', ' ')
					.replace('(', ' ')
					.replace(')', ' ')
					.replace('-', ' ')
					.replace('.', ' ')
					.replace(':', ' ')
					.replace(';', ' ')
					.replace('=', ' ')
					.replace(',', ' ')
					.replace('[', ' ')
					.replace(']', ' ')
					.toLowerCase();

			String[] words = Collections.list(new StringTokenizer(input)).stream().distinct().toArray(String[]::new);
			IntWritable docid = new IntWritable(docnum);
			for (String term : words) {
				word.set(term);
				context.write(word, docid);
			}
		}
	}

	public static class Reduce
			extends Reducer<Text, IntWritable, Text, Text> {

		public void reduce(Text key, Iterable<IntWritable> values,
								 Context context
		) throws IOException, InterruptedException {

			ArrayList<String> docList = new ArrayList<>();
			values.iterator().forEachRemaining(i -> {
				docList.add(i.toString());
			});

			if (docList.size() >= 3) {
				String docs = String.join(",", docList);
				context.write(key, new Text(docs));
			}
		}
	}

	@Override
	public int run(String[] args) throws Exception {
		Configuration conf = getConf();

		FileSystem fs = FileSystem.get(conf);
		if (fs.exists(new Path(args[1])))
			fs.delete(new Path(args[1]), true);

		Job job = Job.getInstance(conf, "inverted index");
		job.setJarByClass(InvertedIndex.class);
		job.setMapperClass(Map.class);
		job.setReducerClass(Reduce.class);
		job.setMapOutputKeyClass(Text.class);
		job.setMapOutputValueClass(IntWritable.class);
		job.setOutputKeyClass(Text.class);
		job.setOutputValueClass(Text.class);
		FileInputFormat.addInputPath(job, new Path(args[0]));
		FileOutputFormat.setOutputPath(job, new Path(args[1]));
		return job.waitForCompletion(true) ? 0 : 1;
	}

	public static void main(String[] args) throws Exception {
		ToolRunner.run(new Configuration(), new InvertedIndex(), args);
	}
}