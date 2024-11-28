create database SmarTSnacK;
use SmarTSnacK;

create table Pedido(
id INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(100) NOT NULL,
preco DECIMAL(10,2) NOT NULL,
usuario_id int not null
)engine=InnoDB;

create table Cardapio(
id INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(100) NOT NULL,
preco DECIMAL(10,2) NOT NULL
)engine=InnoDB;

create table Novidade(
id INT PRIMARY KEY AUTO_INCREMENT,
titulo VARCHAR(100) NOT NULL,
descricao VARCHAR(500) NOT NULL
)engine=InnoDB;

create table Contato(
id INT PRIMARY KEY AUTO_INCREMENT,
email VARCHAR(100) NOT NULL,
assunto VARCHAR(100) NOT NULL,
mensagem VARCHAR(500) NOT NULL
)engine=InnoDB;

create table Usuario(
id INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
senha VARCHAR(100) NOT NULL
)engine=InnoDB;

create table Funcionario(
id INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
senha VARCHAR(100) NOT NULL
)engine=InnoDB;
