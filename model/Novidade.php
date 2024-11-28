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

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function readAll() {
        $query = "SELECT id, titulo, descricao FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query); 
        $stmt->execute();
        $novidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $novidades;
    }

    public function adicionar($titulo, $descricao) {
    $query = "INSERT INTO " . $this->table_name . " (titulo, descricao) VALUES (:titulo, :descricao)";
    $stmt = $this->conn->prepare($query);

    $titulo = htmlspecialchars(strip_tags($titulo));
    $descricao = htmlspecialchars(strip_tags($descricao));

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descricao', $descricao);

    return $stmt->execute();
    }

    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscaID($titulo, $descricao) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE titulo = :titulo AND descricao = :descricao";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editar($titulo, $descricao, $id) {
        $query = "UPDATE " . $this->table_name . " SET titulo = :titulo, descricao = :descricao WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>

