#include <fcntl.h>
#include <stdio.h>
#include <sys/stat.h>
#include <unistd.h>

#define MAX_BUF 1024

int main()
{
    int fd;
	int fd2;
    char * myfifo = "/tmp/myfifo";
	char * myfifo2 = "/tmp/myfifo2";
	
	char buf[MAX_BUF];
	
	mkfifo(myfifo, 0666);
	mkfifo(myfifo2, 0666);
	
    /* open, read, and display the message from the FIFO */
    fd = open(myfifo, O_RDONLY);
	fd2 = open(myfifo2, O_WRONLY);
	
	while(1){
		read(fd, buf, MAX_BUF);
		//printf("Received: %s\n", buf);
		write(fd2, "Hi2", sizeof("Hi2"));
		
	}

    
    close(fd);
	close(fd2);
	
    unlink(myfifo2);
	unlink(myfifo);
	
    return 0;
}