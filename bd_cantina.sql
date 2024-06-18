CREATE DATABASE bd_cantina;
USE bd_cantina;

CREATE TABLE Produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL
);

CREATE TABLE Pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES Produtos(id)
);

INSERT INTO Produtos (produto, preco) VALUES 
('Porção de Coxinha', 7.00),
('Pão de Queijo', 4.00),
('Pão de Queijo Recheado', 8.00),
('Hamburguer', 5.00),
('Cachorro Quente', 9.00),
('Pirulito', 3.00),
('Chocolate Trento', 6.00),
('Ouro Branco', 7.00),
('Halls', 10.00),
('Pipoca Doce', 4.00),
('Mentos', 8.00),
('Batata Frita', 7.00),
('Prato Feito', 5.00),
('Macarrão', 9.00),
('Suco Natural', 6.00),
('Refrigerante', 3.00),
('Água', 10.00);
