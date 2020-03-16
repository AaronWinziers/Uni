#include <stdio.h>
#include <stdbool.h>
#include <stdlib.h>
#include <time.h>
#include <math.h>

int millisecs(struct timespec start, struct timespec stop){
	int seconds = difftime(stop.tv_sec, start.tv_sec);

	int milliseconds = round((seconds * 1000) + ((start.tv_nsec - stop.tv_nsec) / 1.0e6));

	return milliseconds;
}

void cputest(int number){

	struct timespec start, stop;
	clock_gettime(CLOCK_REALTIME, &start);

	bool primes[number];

	for (int i = 0; i < number; i++) {
		primes[i] = true;
	}

	for (int i = 2; i < number; i++) {
		for (int j = 2; j < i; j++) {
			if (i % j == 0) {
				primes[i] = false;
				break;
			}
		}
	}

	clock_gettime(CLOCK_REALTIME, &stop);
	int milliseconds = millisecs(start, stop);

	printf("Calculating the primes took %d ms\n", milliseconds);
}

void iotest(int number){

	struct timespec start, stop;
	clock_gettime(CLOCK_REALTIME, &start);

	FILE * file;

	char filename[] = "file.txt";
	char data[] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eget.";

	for (int i = 0; i < number; ++i) {
		file = fopen(filename, "w");
		if (file == NULL){
			printf("Error creating file.\n");
			exit(EXIT_FAILURE);
		}
		for (int j = 0; j < 50; ++j) {
			fputs(data, file);
		}
		fclose(file);
		remove(filename);
	}

	clock_gettime(CLOCK_REALTIME, &stop);
	int milliseconds = millisecs(start, stop);

	printf("Creating, writing in and deleting the files took %d ms\n", milliseconds);
}

int main() {
	cputest(250000);
	iotest(400000);
	return 0;
}
