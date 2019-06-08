class int_stack {

public:
	class stack_element{	//Listenelement
		int value;
		stack_element* next;
		stack_element(int x, stack_element* p){
			value = x;
			next = p;
		}
	};

private:
	stack_element* first;

public:

	int_stack() {
		first = NULL;
	}

	~int_stack() {
		//Aufgabe 1
		while (!empty()){
			pop();
		}
		//Aufgabe 4
		delete first;
	}

	int pop() {
		if (first == NULL) {return first;}
		stack_element* p = first;
		first = first->next;
		return p;
	}

	void push(stack_element* p) {
		p->next = first;
		first = p;
	}

	int_stack top() {return first;}

	bool empty() {return (first == NULL);}
};