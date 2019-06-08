template <class T>
class queue{
	#include "queue.h"

public:
	queue::queue(int t){
		size = x;
		A = new T[size];
		t = -1
	}

	queue::queue(){
		queue(10);
	}

	queue::~queue(){
		delete[] A;
	}

	void queue::append(T* x){
		if (t == size-1){
			size = 2*size;
			int i;
			for (int i = 0; i <= t; i++) {
				B[i] = A[i];
			}
			delete[] A;
			A = B;
		}
		A[++t] = x;
	}

	T queue::pop(){
		if (t == -1){
			EXCEPTION("Leere Queue");
		} else { //Warum hier else und bei Stack nicht???
			int i:
			T x = A[0];
			for (i = 0; i < t; i++) {
				A[i] = A[i+1];
			}
			t--;
			return x;
		}
	}

	bool queue::empty(){return (t==1);}

	int queue::length(){return t;}

};