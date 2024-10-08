<?php

class Pedido {
    private $conn;
    public $table_name = "Pedido";

    public $id;
    public $nome;
    public $preco;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nome, preco) VALUES (:nome, :preco)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->preco = htmlspecialchars(strip_tags($this->preco));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':preco', $this->preco);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function readOne() {
        $query = "SELECT nome, preco FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nome = $row['nome'];
        $this->preco = $row['preco'];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, preco = :preco WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->preco = htmlspecialchars(strip_tags($this->preco));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':preco', $this->preco);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>