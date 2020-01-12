import java.io.File;
import java.io.FileWriter;
import java.io.IOException;

public class Main {

	public static void cputest(int number){

		if (number < 2) return;

		long start = System.currentTimeMillis();

		boolean[] primes = new boolean[number];
		for (int i = 0; i < number; i++) {
			primes[i] = true;
		}

		for (int i = 2; i < number; i++) {
			for (int j = 2; j < i; j++) {
				if (i % j == 0){
					primes[i] = false;
					break;
				}
			}
		}

		long end = System.currentTimeMillis();

		System.out.println("Calculating the primes took "+(end-start)+"ms");
	}

	public static void iotest(int number) throws IOException {
		long start = System.currentTimeMillis();

		String filename = "file.txt";

		for (int i = 0; i < number; i++) {
			File file = new File(filename);
			if (file.createNewFile()){
				FileWriter writer = new FileWriter(filename);
				for (int j = 0; j < 50; j++) {
					writer.write("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eget.");
				}
				file.delete();
			}
		}

		long end = System.currentTimeMillis();

		System.out.println("Creating, writing in and deleting the files took "+(end-start)+"ms");
	}

	public static void main(String[] args) {

		cputest(250000);

		try {
			iotest(400000);
		} catch (IOException e){
			e.printStackTrace();
		}

	}
}
