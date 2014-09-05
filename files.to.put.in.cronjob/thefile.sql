create database files;
use files;
set character_set_client='utf8';
set character_set_results='utf8';
set collation_connection='utf8_general_ci';
CREATE TABLE books ( ID int NOT NULL AUTO_INCREMENT, filename varchar(99999999) NOT NULL, PRIMARY KEY (ID) );  
truncate table books;
load data local infile '/tmp/books.txt' INTO TABLE books COLUMNS TERMINATED BY '\n';
