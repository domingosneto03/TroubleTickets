DROP TABLE agent_department;
DROP TABLE department;
DROP TABLE ticket_history;
DROP TABLE ticket_hash;
DROP TABLE hashtag;
DROP TABLE ticket;
DROP TABLE agent;
DROP TABLE client;
DROP TABLE user;

CREATE TABLE user (
    id INTEGER PRIMARY KEY,
    username VARCHAR UNIQUE,
    password VARCHAR,
    email VARCHAR UNIQUE
);

CREATE TABLE client (
    id INTEGER PRIMARY KEY REFERENCES user
);

CREATE TABLE agent (
    id INTEGER PRIMARY KEY REFERENCES user
);

CREATE TABLE admin (
    id INTEGER PRIMARY KEY REFERENCES user
);

CREATE TABLE ticket (
    id INTEGER PRIMARY KEY,
    status VARCHAR,
    assigned INTEGER REFERENCES agent,
    id_client INTEGER REFERENCES client,
    priority VARCHAR
);

CREATE TABLE hashtag (
    id INTEGER PRIMARY KEY,
    name VARCHAR UNIQUE
);

CREATE TABLE ticket_hash (
    id_ticket INTEGER REFERENCES ticket,
    id_hashtag INTEGER REFERENCES hashtag
);

CREATE TABLE ticket_history (
    id INTEGER PRIMARY KEY REFERENCES ticket,
    type_of_edit VARCHAR,
    date INTEGER,
    id_agent INTEGER REFERENCES agent,
    old_value VARCHAR
);

CREATE TABLE department (
    id INTEGER PRIMARY KEY,
    name VARCHAR
);

CREATE TABLE agent_department (
    id_agent INTEGER REFERENCES agent,
    id_department INTEGER REFERENCES department
);
