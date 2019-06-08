list<node> dfs(graph& G, node s){
	list<node> result;
	stack<node> S;
	node n;
	edge e;
	for_each(n,G){
		G.set(n,0);	//unbesucht setzen
	}
	G.set(s,1);
	S.push(s);
	while (!S.empty()){
		s = S.pop();
		result.append(s);
		for_each(e,s){	//alle out edges
			n# = G.target(e);
			if(G.get(n) == 0){
				S.push(n);
				G.set(n,1);	//besucht setzen
			}
		}
	}
	return result;
}