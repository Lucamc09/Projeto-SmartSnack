create database bd_cantina;
use bd_cantina;
CREATE TABLE Pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto VARCHAR(100) NOT NULL,
    preco FLOAT(10) NOT NULL
);