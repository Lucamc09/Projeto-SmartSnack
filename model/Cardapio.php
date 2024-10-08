<?php

class Cardapio {
    private $conn;
    public $table_name = "Cardapio";

    public $id;
    public $nome;
    public $preco;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create - Criar um novo item no cardápio
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nome, preco) VALUES (:nome, :preco)";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->preco = htmlspecialchars(strip_tags($this->preco));

        // Bind parameters
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':preco', $this->preco);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Read - Obter detalhes de um item no cardápio pelo ID
    public function readOne() {
        $query = "SELECT nome, preco FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nome = $row['nome'];
        $this->preco = $row['preco'];
    }

    // Update - Atualizar os dados de um item no cardápio
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, preco = :preco WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->preco = htmlspecialchars(strip_tags($this->preco));

        // Bind parameters
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':preco', $this->preco);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete - Excluir um item do cardápio pelo ID
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
