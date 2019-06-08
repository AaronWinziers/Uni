#include <stdio.h>
#include <sys/types.h>
#include <unistd.h>
#include <stdlib.h>
#include <string.h>

int main() {
	int pid_num = 3;
	char* readbuffer;
	char* writebuffer;


	pid_t pids;
  pid_t parent = getpid();

	int fd[2];

  printf("The parent PID: %d\n", parent);

	if (getpid() == parent){
		pids = fork();
		pipe(&fd[2]);
		if (getpid() == parent) {
			printf("New PID: %d\n", pids);
		}
	}


	if (getpid() == parent){
		int i = 100;

		//sprintf (writebuffer, "%d", i);
		writebuffer = "Why wont this work\0";
		printf("Here\n");
		write(fd[1], writebuffer, sizeof(writebuffer));
		// printf("Writing\n");

	} else {
		sleep(10);
		read(fd[0], readbuffer , 21);
		// int x = atoi(readbuffer);
		printf("Reading\n");
		//printf("This is child number %d\n", x);
		printf("%s\n", readbuffer);
	}


}
