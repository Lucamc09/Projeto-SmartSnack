<?php

class Novidade {
    private $conn;
    public $table_name = "Novidade";

    public $id;
    public $titulo;
    public $descricao;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create - Criar uma nova novidade
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (titulo, descricao) VALUES (:titulo, :descricao)";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));

        // Bind parameters
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Read - Obter detalhes de uma novidade pelo ID
    public function readOne() {
        $query = "SELECT titulo, descricao FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->titulo = $row['titulo'];
            $this->descricao = $row['descricao'];
        }
    }

    // Update - Atualizar os dados de uma novidade
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET titulo = :titulo, descricao = :descricao WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));

        // Bind parameters
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete - Excluir uma novidade pelo ID
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
