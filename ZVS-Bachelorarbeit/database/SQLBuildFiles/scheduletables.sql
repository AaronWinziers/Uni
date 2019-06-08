create table SCHEDULE_PATTERNS (
  id int unique ,
  name varchar(30) unique ,

  hours_work integer ,
  hours_break integer ,
  hours_vacation integer ,

  created_at timestamp,
  updated_at timestamp,

  PRIMARY KEY (id)
);

CREATE TABLE STANDARD_HOURS (
  id bigint not null unique,
  employee bigint not null ,
  pattern int not null ,

  hours int not null ,

  start_date date not null ,
  end_date date ,

  created_at timestamp,
  updated_at timestamp,

  PRIMARY KEY (id) ,
  constraint fk_standard_pattern_id foreign key (pattern) references SCHEDULE_PATTERNS(id) ,
  constraint fk_standard_employee_id foreign key (employee) references EMPLOYEES(id)
);

create table EXCEPTIONAL_HOURS (
  id bigint not null unique,
  employee bigint not null ,
  pattern int not null ,

  from date not null ,
  until date not null ,

  created_at timestamp,
  updated_at timestamp,

  PRIMARY KEY (id) ,
  constraint fk_standard_pattern_id foreign key (pattern) references SCHEDULE_PATTERNS(id) ,
  constraint fk_standard_employee_id foreign key (employee) references EMPLOYEES(id)
);



