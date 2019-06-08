template <class T>
		
class queue{

private:
	T* A;
	int size;
	int t;

public:

	//Default-Konstruktor erzeugt leere Queue
	queue();

	//Konstruktor erzeugt leere Queue der Größe x
	queue(int size);

	//Destruktor, löscht die Queue
	~queue();

	void append(T* x);
	//Fügt x am Ende der Queue an

	T pop();
	//Precondition: Queue nicht leer

	bool empty() const;
	//true, wenn Queue leer ist, sonst false

	int length();
	//Gibt die Länge der Queue zurück
};