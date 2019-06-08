list<node> bfs(graph& G, node s){
	list<node> result;
	queue<node> Q;
	node n;
	edge e;
	for_each(n,G){
		G.set(n,0);	//unbesucht setzen
	}
	G.set(s,1);
	Q.append(s);
	while (!Q.empty()){
		s = Q,pop();
		result.append(s);
		for_each(e,s){	//alle out edges
			n# = G.target(e);
			if(G.get(n) == 0){
				Q.append(n);
				G.set(n,1);	//besucht setzen
			}
		}
	}
	return result;
}