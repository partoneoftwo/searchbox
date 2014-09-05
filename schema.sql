create database files;
use files;

CREATE TABLE searchlog ( ID int NOT NULL AUTO_INCREMENT, searchword
varchar(99999999) NOT NULL, timeofsearch TIMESTAMP DEFAULT
CURRENT_TIMESTAMP, usersipaddress varchar(999999999),
userauthenticatedwith varchar(999999999), userauthenticatedwithpw
varchar(99999999), searchhits BIGINT,  PRIMARY KEY (ID) );


CREATE TABLE books ( ID int NOT NULL AUTO_INCREMENT, filename varchar(99999999) NOT NULL, PRIMARY KEY (ID) );  
load data local infile '/tmp/books.txt' INTO TABLE books COLUMNS TERMINATED BY '\n';
