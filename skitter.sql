DROP DATABASE IF EXISTS skitter;
CREATE DATABASE skitter;
USE skitter;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS follows;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS sessions;

CREATE TABLE users (
	username varchar(20) not null,
        email varchar(30) not null,
        name varchar(50) not null,
        PRIMARY KEY(username)
);

CREATE TABLE follows (
        id int not null,
	leader varchar(20) not null,
	follow varchar(20) not null,
        PRIMARY KEY(id),
	FOREIGN KEY (leader) REFERENCES users(username) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (follow) REFERENCES users(username) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE sessions (
        username varchar(20) not null,
        sessionid varchar(40) not null,
        UNIQUE (username),
        PRIMARY KEY(username),
	FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE ON UPDATE CASCADE

);

CREATE TABLE images (
        username varchar(20) not null,
        img longblob not null,
        PRIMARY KEY(username),
	FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE ON UPDATE CASCADE
);
