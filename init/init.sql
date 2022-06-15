/*
    run:
    mysql < init/tables.sql
*/
CREATE DATABASE IF NOT EXISTS twitter;

CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'passwd';
CREATE USER IF NOT EXISTS 'root'@'localhost' IDENTIFIED BY 'passwd';
GRANT ALL PRIVILEGES ON `twitter`.* TO 'root'@'%' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `twitter`.* TO 'root'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;

USE twitter;

CREATE TABLE IF NOT EXISTS users (
    uid INT AUTO_INCREMENT,
    ip VARCHAR(64) UNIQUE,
    PRIMARY KEY(uid)
);

CREATE TABLE IF NOT EXISTS tweets (
    tid INT AUTO_INCREMENT,
    uid INT,
    date datetime,
    post VARCHAR(280),
    file TINYTEXT,
    PRIMARY KEY(tid),
    KEY(date),
    KEY(uid, date)
);

CREATE TABLE IF NOT EXISTS follows (
    uid INT,
    follower INT,
    PRIMARY KEY(uid, follower)
);
