/* Already added to new db script*/

CREATE TABLE PROJECT_LEADERS (
  id bigint not null unique,
  employee bigint not null ,
  project varchar(40) not null ,

  created_at timestamp default CURRENT_TIMESTAMP,
  updated_at timestamp default current_timestamp,

  PRIMARY KEY (id) ,
  constraint fk_leader_employee_id foreign key (employee) references EMPLOYEES(id) ,
  constraint fk_leader_project_id foreign key (project) references PROJECTS(id)
);

ALTER TABLE EMPLOYEES add (remember_token varchar(100)) ;
