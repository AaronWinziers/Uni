#include "int_stack.h"

int_stack::int_stack(int n) {
	size = n;	//Länge des Feldes
	A = new int[size];
	t = -1;	//Leeres Array
}

int_stack::int_stack() {
	int_stack(2);
}

int_stack::~int_stack() {
	delete[] A;
}

int_stack::push(int x) {
	if (t == size-1){
		//Stack ist voll
		int* B = new int[2*size];
		size = size*2;
		for (int i = 0; i <= t; i++) {
			B[i] = A[i];
		}
		delete[] A;
		A = B;	//Verschiebe Pointer
	}
	A[++t] = x;	//Die eigentliche Push-Operation
}

int_stack::pop() {
	if (t == -1){
		EXCEPTION("Empty Stack");
	}
	return A[t--];
}

int_stack::top() {
	if (t == -1){
		EXCEPTION("Empty Stack");
	}
	return A[t];
}

int_stack::empty() {
	return (t == -1);
}