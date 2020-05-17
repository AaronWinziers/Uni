package chap03;

import java.util.Arrays;
import java.util.List;
import java.util.stream.Collectors;

public class JavaStreamsExample {

	public static void main(String[] args) {
		List<Integer> list = Arrays.asList(1, 2, 3, 4, 5);
		System.out.println(list.stream().map(x -> x * x).collect(Collectors.toList()));

		System.out.println(list.stream().reduce(0, (a, b) -> a + b));
	}

}
