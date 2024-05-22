create database bd_cantina;
use bd_cantina;
CREATE TABLE Pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto VARCHAR(100) NOT NULL,
    quantidade int(3) NOT NULL
);
create table Produtos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto VARCHAR(100) NOT NULL,
    preço int(3) NOT NULL
);


select * from produtos;
insert into Produtos values ('default','PorçãodeCoxinha','7');
INSERT INTO Produtos VALUES ('default', 'PorçãoDeCoxinha', '4');
INSERT INTO Produtos VALUES ('default', 'PãodeQueijo', '8');
INSERT INTO Produtos VALUES ('default', 'PãodeQueijoRecheado', '5');
INSERT INTO Produtos VALUES ('default', 'Hamburguer', '9');
INSERT INTO Produtos VALUES ('default', 'CachorroQuente', '3');
INSERT INTO Produtos VALUES ('default', 'Pirulito', '6');
INSERT INTO Produtos VALUES ('default', 'ChocolateTrento', '7');
INSERT INTO Produtos VALUES ('default', 'OuroBranco', '10');
INSERT INTO Produtos VALUES ('default', 'Halls', '4');
INSERT INTO Produtos VALUES ('default', 'PipocaDoce', '8');
INSERT INTO Produtos VALUES ('default', 'Mentos', '7');
INSERT INTO Produtos VALUES ('default', 'BatataFrita', '5');
INSERT INTO Produtos VALUES ('default', 'PratoFeito', '9');
INSERT INTO Produtos VALUES ('default', 'Macarrão', '6');
INSERT INTO Produtos VALUES ('default', 'SucoNatural', '3');
INSERT INTO Produtos VALUES ('default', 'Refrigerante', '10');
INSERT INTO Produtos VALUES ('default', 'Água', '4');
