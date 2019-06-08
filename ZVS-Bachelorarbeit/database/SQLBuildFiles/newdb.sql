CREATE TABLE EMPLOYEES (
  id bigint not null unique,
  first_name varchar(20) not null,
  last_name varchar(20) not null,
  username varchar(20) unique,
  password varchar(191),
  transponder int unique,
  admin boolean,
  manager boolean,
  employee boolean,
  active boolean,
  scanner boolean,

  created_at timestamp,
  updated_at timestamp,

  remember_token varchar(100) ,

  PRIMARY KEY (id)
);

create table CLIENTS (
  id varchar(20) unique,
  name varchar(30) unique ,

  created_at timestamp DEFAULT CURRENT_TIMESTAMP ,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ,

  PRIMARY KEY (id)
);

create table JOBS (
  id varchar(40) unique not null ,
  name varchar(40),
  client_id varchar(40),
  client_name varchar(40),

  created_at timestamp DEFAULT CURRENT_TIMESTAMP ,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ,

  PRIMARY KEY (id),
  constraint fk_job_client_id foreign key (client_id) references CLIENTS (id),
  constraint fk_job_client_name foreign key (client_name) references CLIENTS (name)
);

CREATE TABLE PROJECTS (
  id varchar(40) not null unique,
  name varchar(40) not null,
  client_id varchar(40),
  client_name varchar(40),
  description text,
  active boolean,
  start date,
  deadline date,
  job varchar(40),


  created_at timestamp DEFAULT CURRENT_TIMESTAMP ,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ,

  PRIMARY KEY (id),
  constraint fk_project_client_id foreign key (client_id) references CLIENTS(id),
  constraint fk_project_job_id foreign key (job) references JOBS(id)
);

CREATE TABLE TASKS (
  id bigint NOT NULL unique AUTO_INCREMENT,
  number int not null,
  project varchar(40) not null ,
  time_allotted int not null,

  created_at timestamp DEFAULT CURRENT_TIMESTAMP ,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ,


  primary key (id),
  constraint fk_task_project_id foreign key (project) references PROJECTS(id),
  CONSTRAINT uc_task UNIQUE (id,number)
);

create table LOG (
  id bigint unique not null ,
  task bigint unique not null ,
  employee bigint not null ,
  start time not null ,
  end time ,

  created_at timestamp DEFAULT CURRENT_TIMESTAMP ,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ,

  primary key (id),
  constraint fk_log_task_id foreign key (task) references TASKS(id),
  constraint fk_log_employee_id foreign key (employee) references EMPLOYEES(id)
);

create table SCHEDULE_PATTERNS (
  id int unique ,
  name varchar(30) unique ,

  work integer ,
  break integer ,
  vacation integer ,

  created_at timestamp DEFAULT CURRENT_TIMESTAMP ,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ,

  PRIMARY KEY (id)
);

CREATE TABLE STANDARD_HOURS (
  id bigint not null unique,
  employee bigint not null ,
  pattern int not null ,

  hours int not null ,

  start date not null ,
  end date ,

  created_at timestamp DEFAULT CURRENT_TIMESTAMP ,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ,

  PRIMARY KEY (id) ,
  constraint fk_standard_pattern_id foreign key (pattern) references SCHEDULE_PATTERNS(id) ,
  constraint fk_standard_employee_id foreign key (employee) references EMPLOYEES(id)
);

create table EXCEPTIONAL_HOURS (
  id bigint not null unique,
  employee bigint not null ,
  pattern int not null ,

  start date not null ,
  end date not null ,

  created_at timestamp DEFAULT CURRENT_TIMESTAMP ,
  updated_at timestamp DEFAULT CURRENT_TIMESTAMP ,

  PRIMARY KEY (id) ,

  constraint fk_exceptional_pattern_id foreign key (pattern) references SCHEDULE_PATTERNS(id) ,
  constraint fk_exceptional_employee_id foreign key (employee) references EMPLOYEES(id)
);

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