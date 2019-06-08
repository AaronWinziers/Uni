template <class Iterator>
void MERGE(Iterator a, Iterator b, Iterator c, Iterator d, Iterator e){
	while (a != b || c != d){
		*e++ = (c == d || (*a < *c && a != b)) ? *a++ : *c++;
	}
}