<?php

class Contato {
    private $conn;
    public $table_name = "Contato";

    public $id;
    public $email;
    public $assunto;
    public $mensagem;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create - Criar um novo contato
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (email, assunto, mensagem) VALUES (:email, :assunto, :mensagem)";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->assunto = htmlspecialchars(strip_tags($this->assunto));
        $this->mensagem = htmlspecialchars(strip_tags($this->mensagem));

        // Bind parameters
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':assunto', $this->assunto);
        $stmt->bindParam(':mensagem', $this->mensagem);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Read - Obter detalhes de um contato pelo ID
    public function readOne() {
        $query = "SELECT email, assunto, mensagem FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->email = $row['email'];
        $this->assunto = $row['assunto'];
        $this->mensagem = $row['mensagem'];
    }

    // Update - Atualizar os dados de um contato
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET email = :email, assunto = :assunto, mensagem = :mensagem WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->assunto = htmlspecialchars(strip_tags($this->assunto));
        $this->mensagem = htmlspecialchars(strip_tags($this->mensagem));

        // Bind parameters
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':assunto', $this->assunto);
        $stmt->bindParam(':mensagem', $this->mensagem);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete - Excluir um contato pelo ID
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
