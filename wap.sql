create database wap;
use wap;

create table produtos(
    id int (15) primary key auto_increment,
    EAN int(15) not null,
    NOME_PRODUTO varchar(100) not null,
    PRECO varchar(20) not null,
    ESTOQUE int(15) not null,
    DATA_FABRICACAO varchar(10)
);

create table usuario(
    id int not null primary key auto_increment,
    usuario varchar(100) not null,
    senha varchar(50) not null
);

insert into usuario (usuario, senha) values('admin', md5('admin'));