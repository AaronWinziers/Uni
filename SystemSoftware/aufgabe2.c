#include <stdio.h>
#include <sys/types.h>
#include <unistd.h>

int main() {
	int pid_num = 3;


	pid_t pids[pid_num]  ;
  pid_t parent = getpid();

	int fd[pid_num*2];

  printf("The parent PID: %d\n", parent);

	for (int i = 0; i < pid_num; i++){
		if (getpid() == parent){
			pids[i] = fork();
			pipe(&fd[2*i]);
			if (getpid() == parent) {
				printf("New PID: %d\n", pids[i]);
			}
		}
  }


	for(int i = 0; i<pid_num; i++){
		if (getpid() == parent){
			write(fd[2*i + 1], i, sizeof(i));
		} else{
			read(fd[2*i], ,size),
		}
	}

  if (getpid() != parent) {
    printf("This is the child with PID: %d\n", (int)getpid());
  }


}
