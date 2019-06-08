void wordcount() {
	dictionary<String, int> D;
	String s;
	for (s:Eingabe) {
		if (!D.defined(s)){
			D.insert(s,1);
		} else {
			D.insert(s,D.lookup(s)+1);
		}
	}
	for (s:D){
		cout<<s<<":"<<D.lookup(s)<<"/n";
	}
}
