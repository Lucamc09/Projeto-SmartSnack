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

    public function adicionar($nome, $preco){
        $query = "INSERT INTO " . $this->table_name . " (nome, preco) VALUES (:nome, :preco)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function excluir($id){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editar($nome, $preco, $id){
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, preco = :preco WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
}
?>
