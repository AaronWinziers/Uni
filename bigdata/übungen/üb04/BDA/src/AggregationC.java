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

public class AggregationC extends Configured implements Tool {

	public static class Map
			extends Mapper<Object, Text, IntWritable, Sclength> {

		private final IntWritable id = new IntWritable(1);
		private final IntWritable score = new IntWritable();
		private final IntWritable length = new IntWritable();
		private final Sclength sclength = new Sclength();

		public void map(Object key, Text value, Context context
		) throws IOException, InterruptedException {
			HashMap<String, String> input = (HashMap<String, String>) MRDPUtils.transformXmlToMap(value.toString());

			if (input.containsKey("Score") && input.containsKey("Body")) {
				int temp = Integer.parseInt(input.get("Score"));
				String body = input.get("Body");

				score.set(temp);
				length.set(body.length());
				sclength.set(score, length);
				context.write(id, sclength);
			}

		}
	}

	public static class Reduce
			extends Reducer<IntWritable, Sclength, Text, DoubleWritable> {

		public void reduce(IntWritable key, Iterable<Sclength> values,
								 Context context
		) throws IOException, InterruptedException {
			ArrayList<Integer> scores = new ArrayList<>();
			ArrayList<Integer> lengths = new ArrayList<>();
			values.forEach(val -> {
				scores.add(val.score.get());
				lengths.add(val.length.get());
			});

			Double scoreMean = scores.stream().mapToDouble(x -> x).average().getAsDouble();
			Double lengthMean = lengths.stream().mapToDouble(x -> x).average().getAsDouble();

			Double scoreStDev = Math.sqrt(scores.stream().mapToDouble(x -> Math.pow((x - scoreMean), 2)).average().getAsDouble());
			Double lengthStDev = Math.sqrt(scores.stream().mapToDouble(x -> Math.pow((x - lengthMean), 2)).average().getAsDouble());

			List<Double> scoreStVals = scores.stream().mapToDouble(x -> (x - scoreMean) / scoreStDev).boxed().collect(Collectors.toList());
			List<Double> lengthStVals = scores.stream().mapToDouble(x -> (x - lengthMean) / lengthStDev).boxed().collect(Collectors.toList());

			Double sum = 0.0;
			for (int i = 0; i < scoreStVals.size(); i++) {
				sum += scoreStVals.get(i) * lengthStVals.get(i);
			}

			Double corrCoeff = sum / (scoreStVals.size() - 1);

			context.write(new Text("Correlation Coefficient"), new DoubleWritable(corrCoeff));
		}
	}

	@Override
	public int run(String[] args) throws Exception {
		Configuration conf = getConf();

		FileSystem fs = FileSystem.get(conf);
		if (fs.exists(new Path(args[1])))
			fs.delete(new Path(args[1]), true);

		Job job = Job.getInstance(conf, "Aggregate part c");
		job.setJarByClass(AggregationC.class);
		job.setMapperClass(Map.class);
		job.setReducerClass(Reduce.class);
		job.setMapOutputKeyClass(IntWritable.class);
		job.setMapOutputValueClass(Sclength.class);
		job.setOutputKeyClass(Text.class);
		job.setOutputValueClass(DoubleWritable.class);
		FileInputFormat.addInputPath(job, new Path(args[0]));
		FileOutputFormat.setOutputPath(job, new Path(args[1]));
		return job.waitForCompletion(true) ? 0 : 1;
	}

	public static void main(String[] args) throws Exception {
		ToolRunner.run(new Configuration(), new AggregationC(), args);
	}
}