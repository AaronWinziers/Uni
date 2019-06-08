class int_stack{
private:
	int* A; 	//Feld 1
	int size;	//Länge von A
	int t;

public:

	//Default-Konstruktor
	int_stack();

	//Konstruktor
	int_stack(int size);	//Erzeugt einen Stack mit max. Größe size

	//Destruktor
	~int_stack();
	//Löscht den Stack

	void push(int x);
	//Fügt x als letztes Element an die Folge an

	int top() const;
	//Liefert das letzte Element. Precondition: Stack nicht leer

	int pop();
	//Liefert das letzte Element der Folge und gibt es zurück

	bool empty() const;
	//true, wenn Stack leer ist, sonst false
};