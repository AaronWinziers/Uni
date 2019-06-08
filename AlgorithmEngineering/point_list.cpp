stack_list point_list;
point* p = new point(x,y);
point_list->push(p);
point* q = (point*) point_list->top();
point* q = (point*) point_list->pop();

1.Leite point von list_element ab: class point: public slist_elem{...};
2.list kann nun für point verwendet werden