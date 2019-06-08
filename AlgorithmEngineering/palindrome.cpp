template <class T>
bool palindrom (Iterator a, Iterator b){
	--b;	//zeigt sonst auf "\o"
	while (a < b && a* == b*){
		++a;
		--b;
	}
	return a >= b;
}