DROP TABLE comment;
DROP TABLE faq;
DROP TABLE ticket_file;
DROP TABLE ticket_department;
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
    password VARCHAR,
    email VARCHAR UNIQUE,
    bio VARCHAR,
    userImage VARCHAR
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
    title VARCHAR,
    body VARCHAR,
    status VARCHAR,
    assigned INTEGER REFERENCES agent,
    clientId INTEGER REFERENCES client,
    priority VARCHAR,
    deadline INTEGER
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

CREATE TABLE ticket_department (
    ticketId INTEGER REFERENCES ticket,
    departmentId INTEGER REFERENCES department
);

CREATE TABLE ticket_file (
    ticketId INTEGER REFERENCES ticket,
    filepath VARCHAR
);

CREATE TABLE faq (
    faqId INTEGER PRIMARY KEY,
    question VARCHAR UNIQUE,
    answer VARCHAR UNIQUE
);

CREATE TABLE comment (
    commentId INTEGER PRIMARY KEY,
    body VARCHAR,
    date INTEGER,
    userId INTEGER REFERENCES user,
    ticketId INTEGER REFERENCES ticket
);

-- 20 users
INSERT INTO user (username, password, email, bio) VALUES ("charlie", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "c.harlie@gone.com", "I'm a php programmer");
INSERT INTO user (username, password, email, bio) VALUES ("jenny", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "jenny@hotmail.com", "I'm a graphic designer");
INSERT INTO user (username, password, email, bio) VALUES ("michael", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "michael@gmail.com", "I'm a software engineer");
INSERT INTO user (username, password, email, bio) VALUES ("david", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "david@yahoo.com", "I'm a web developer");
INSERT INTO user (username, password, email, bio) VALUES ("jane", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "jane@gmail.com", "I'm a marketing specialist");
INSERT INTO user (username, password, email, bio) VALUES ("peter", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "peter@hotmail.com", "I'm a front-end developer");
INSERT INTO user (username, password, email, bio) VALUES ("susan", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "susan@yahoo.com", "I'm a content writer");
INSERT INTO user (username, password, email, bio) VALUES ("mark", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "mark@gmail.com", "I'm a project manager");
INSERT INTO user (username, password, email, bio) VALUES ("mary", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "mary@hotmail.com", "I'm a customer support specialist");
INSERT INTO user (username, password, email, bio) VALUES ("tom", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "tommy@fugu.com", "I am an astronaut");
INSERT INTO user (username, password, email, bio) VALUES ("john", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "john@gmail.com", "I'm a full-stack developer");
INSERT INTO user (username, password, email, bio) VALUES ("sarah", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "sarah@yahoo.com", "I'm a UI/UX designer");
INSERT INTO user (username, password, email, bio) VALUES ("matt", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "matt@hotmail.com", "I'm a software architect");
INSERT INTO user (username, password, email, bio) VALUES ("emily", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "emily@gmail.com", "I'm a content marketing specialist");
INSERT INTO user (username, password, email, bio) VALUES ("jack", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "jack@yahoo.com", "I'm a data analyst");
INSERT INTO user (username, password, email, bio) VALUES ("lisa", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "lisa@gmail.com", "I'm a social media manager");
INSERT INTO user (username, password, email, bio) VALUES ("adam", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "adam@hotmail.com", "I'm a network engineer");
INSERT INTO user (username, password, email, bio) VALUES ("karen", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "karen@yahoo.com", "I'm a human resources specialist");
INSERT INTO user (username, password, email, bio) VALUES ("daniel", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "daniel@gmail.com", "I'm a mobile app developer");
INSERT INTO user (username, password, email, bio) VALUES ("amy", "$2y$10$7RW/fO2rYT4isr.RY/eUF.uIohmP2g/GR4kE9sS9AE6t/dVcvn1oK", "amanda@rust.com", "I'm an HR specialist");

-- 20 clients
INSERT INTO client (clientId) VALUES (1);
INSERT INTO client (clientId) VALUES (2);
INSERT INTO client (clientId) VALUES (3);
INSERT INTO client (clientId) VALUES (4);
INSERT INTO client (clientId) VALUES (5);
INSERT INTO client (clientId) VALUES (6);
INSERT INTO client (clientId) VALUES (7);
INSERT INTO client (clientId) VALUES (8);
INSERT INTO client (clientId) VALUES (9);
INSERT INTO client (clientId) VALUES (10);
INSERT INTO client (clientId) VALUES (11);
INSERT INTO client (clientId) VALUES (12);
INSERT INTO client (clientId) VALUES (13);
INSERT INTO client (clientId) VALUES (14);
INSERT INTO client (clientId) VALUES (15);
INSERT INTO client (clientId) VALUES (16);
INSERT INTO client (clientId) VALUES (17);
INSERT INTO client (clientId) VALUES (18);
INSERT INTO client (clientId) VALUES (19);
INSERT INTO client (clientId) VALUES (20);

-- 10 agents
INSERT INTO agent (agentId) VALUES (2);
INSERT INTO agent (agentId) VALUES (4);
INSERT INTO agent (agentId) VALUES (6);
INSERT INTO agent (agentId) VALUES (8);
INSERT INTO agent (agentId) VALUES (10);
INSERT INTO agent (agentId) VALUES (12);
INSERT INTO agent (agentId) VALUES (14);
INSERT INTO agent (agentId) VALUES (16);
INSERT INTO agent (agentId) VALUES (18);
INSERT INTO agent (agentId) VALUES (20);

-- 4 admin
INSERT INTO admin (adminId) VALUES (8);
INSERT INTO admin (adminId) VALUES (12);
INSERT INTO admin (adminId) VALUES (18);
INSERT INTO admin (adminId) VALUES (20);

-- 20 tickets
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Can't connect to VPN", "I'm having trouble connecting to the company VPN from home", "open", 4, 6, "high", 1683846000);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Computer is slow", "My computer has been running very slowly lately and it's affecting my work", "open", 10, 18, "medium", 1683846000);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Email not working", "I can't seem to send or receive emails from my account", "open", 2, 14, "high", 1683846000);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Need software installed", "I need a specific software installed on my computer to complete a project", "open", 6, 8, "medium", 1683846000);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Can't print", "I'm having trouble printing from my computer", "open", 12, 7, "low", 1683846000);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("New hire setup", "I need a new employee's computer set up with the necessary software and accounts", "open", 14, 2, "high", 1683846000);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Website not loading", "I'm unable to access the company website from my computer", "open", 8, 13, "medium", 1683932400);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Password reset", "I've forgotten my password and need it reset", "open", 16, 4, "low", 1683932400);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Need access to shared drive", "I need access to a shared drive to retrieve some files", "open", 18, 11, "high", 1683932400);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Computer won't start", "My computer won't turn on and I need it fixed urgently", "open", 20, 17, "high", 1684105200);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Need software update", "I need a software update to fix some bugs and improve performance", "open", 16, 1, "medium", 1684105200);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Can't access company portal", "I'm unable to access the company portal to submit my timesheet", "open", 6, 20, "high", 1684105200);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Need new monitor", "My monitor is old and malfunctioning, I need a new one", "open", 2, 10, "low", 1684105200);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Printer not working", "I'm unable to print from my computer, even after restarting", "open", 8, 12, "medium", 1684364400);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Need help with Excel", "I need assistance with a complex Excel formula for my project", "open", 10, 15, "high", 1684364400);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Need access to new project folder", "I need access to a new project folder to store my files", "open", 4, 9, "low", 1684364400);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Computer virus", "I think my computer has a virus and needs to be scanned", "open", 12, 5, "high", 1684364400);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Need new headphones", "My headphones are broken and I need a new pair", "open", 18, 16, "low", 1684450800);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Can't access shared printer", "I'm unable to access the shared printer on the network", "open", 14, 19, "medium", 1684450800);
INSERT INTO ticket (title, body, status, assigned, clientId, priority, deadline) VALUES ("Need help with PowerPoint", "I need help formatting a presentation in PowerPoint", "open", 20, 3, "medium", 1684450800);

-- 20 ticket_history
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (1, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (2, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (3, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (4, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (5, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (6, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (7, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (8, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (9, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (10, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (11, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (12, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (13, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (14, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (15, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (16, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (17, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (18, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (19, "CREATION", 1683727200, null, null);
INSERT INTO ticket_history (ticketId, type_of_edit, date, agentId, old_value) VALUES (20, "CREATION", 1683727200, null, null);

-- 5 departments
INSERT INTO department (name) VALUES ("Web");
INSERT INTO department (name) VALUES ("Hardware");
INSERT INTO department (name) VALUES ("Security");
INSERT INTO department (name) VALUES ("Sound");
INSERT INTO department (name) VALUES ("Installation");

INSERT INTO ticket_department (ticketId, departmentId) VALUES (1, 4);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (2, 1);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (3, 3);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (4, 2);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (5, 1);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (6, 5);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (7, 3);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (8, 1);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (9, 5);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (10, 2);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (11, 2);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (12, 5);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (13, 3);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (14, 4);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (15, 1);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (16, 2);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (17, 5);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (18, 3);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (19, 1);
INSERT INTO ticket_department (ticketId, departmentId) VALUES (20, 4);

INSERT INTO ticket_file (ticketId, filepath) VALUES (1, "uploads/1/1.JPG");

INSERT into faq (question, answer) VALUES ("What is this website for?", "Anything");
INSERT into faq (question, answer) VALUES ("Who is this website for?", "Nothing");