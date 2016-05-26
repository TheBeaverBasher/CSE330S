create database petdb;

create table pets (
id smallint unsigned not null auto_increment,
species enum("cat", "dog", "fish", "bird", "hamster") not null,
name varchar(50) not null,
filename varchar(150) not null,
weight decimal(4,2) not null,
description tinytext,
primary key (id)
) engine = INNODB DEFAULT character SET = utf8 COLLATE = utf8_general_ci;