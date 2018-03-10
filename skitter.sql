DROP DATABASE IF EXISTS skitter;
CREATE DATABASE skitter;
USE skitter;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS follows;


CREATE TABLE users (
	username varchar(20) not null,
        pw_hash varchar(100) not null,
        email varchar(30) not null,
        first_name varchar(30) not null,
        last_name varchar(30) not null,
        CONSTRAINT username_pk PRIMARY KEY(username)
);


CREATE TABLE follows (
        id int not null,
	lead varchar(20) not null,
	follow varchar(20) not null,
        CONSTRAINT follows_pk PRIMARY KEY(id),
	FOREIGN KEY (lead) REFERENCES users(username) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (follow) REFERENCES users(username) ON DELETE CASCADE ON UPDATE CASCADE
);



