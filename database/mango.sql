DROP TABLE faq;
DROP TABLE agent_department;
DROP TABLE department;
DROP TABLE ticket_history;
DROP TABLE ticket_hash;
DROP TABLE hashtag;
DROP TABLE ticket;
DROP TABLE admin;
DROP TABLE agent;
DROP TABLE client;
DROP TABLE user;

CREATE TABLE user (
    userId INTEGER PRIMARY KEY,
    username VARCHAR UNIQUE,
    password VARCHAR UNIQUE,
    email VARCHAR UNIQUE
);

CREATE TABLE client (
    clientId INTEGER PRIMARY KEY REFERENCES user
);

CREATE TABLE agent (
    agentId INTEGER PRIMARY KEY REFERENCES user
);

CREATE TABLE admin (
    adminId INTEGER PRIMARY KEY REFERENCES user
);

CREATE TABLE ticket (
    ticketId INTEGER PRIMARY KEY,
    status VARCHAR,
    assigned INTEGER REFERENCES agent,
    clientId INTEGER REFERENCES client,
    priority VARCHAR
);

CREATE TABLE hashtag (
    hashtagId INTEGER PRIMARY KEY,
    name VARCHAR UNIQUE
);

CREATE TABLE ticket_hash (
    ticketId INTEGER REFERENCES ticket,
    hashtagId INTEGER REFERENCES hashtag
);

CREATE TABLE ticket_history (
    ticketId INTEGER PRIMARY KEY REFERENCES ticket,
    type_of_edit VARCHAR,
    date INTEGER,
    agentId INTEGER REFERENCES agent,
    old_value VARCHAR
);

CREATE TABLE department (
    departmentId INTEGER PRIMARY KEY,
    name VARCHAR
);

CREATE TABLE agent_department (
    agentId INTEGER REFERENCES agent,
    departmentId INTEGER REFERENCES department
);

CREATE TABLE faq (
    faqId INTEGER PRIMARY KEY,
    question VARCHAR UNIQUE,
    answer VARCHAR UNIQUE
);

INSERT into faq (question, answer) VALUES ("What is this website for?", "Anything");
INSERT into faq (question, answer) VALUES ("Who is this website for?", "Nothing");