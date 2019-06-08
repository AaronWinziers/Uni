class dictionary{
	//Instanz vom Typ dictionary <String, int> ist eine partielle Ableitung Abb d:String->int, mit dom(d) ist Definitionsbereich

public:
	//Konstruktor, erstellt leeres Wörterbuch
	dictionary();

	//Destruktor, löscht Wörterbuch
	~dictionary();

	void insert(String k, int i);

	void delete(String k);

	bool empty();	//true, falls dom(d)=leere Menge, sonst false

	int lookup(String k);

	bool defined(String k);	//true, falls k /in dom(d), sonst false
};