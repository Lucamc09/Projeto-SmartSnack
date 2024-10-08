<?php

include_once 'model/Funcionario.php';

class FuncionarioController {
    private $db;
    private $funcionario;

    public function __construct($db) {
        $this->db = $db;
        $this->funcionario = new Funcionario($db);
    }

    public function create($nome, $email, $senha) {
        $this->funcionario->nome = $nome;
        $this->funcionario->email = $email;
        $this->funcionario->senha = $senha;

        if($this->funcionario->create()) {
            return "Funcionário criado.";
        } else {
            return "Não foi possível criar Funcionário.";
        }
    }

    public function readOne($id) {
        $this->funcionario->id = $id;
        $this->funcionario->readOne();

        if($this->funcionario->nome != null) {
            $funcionario_arr = array(
                "id" => $this->funcionario->id,
                "nome" => $this->funcionario->nome,
                "email" => $this->funcionario->email,
                "senha" => $this->funcionario->senha
            );
            return $funcionario_arr;
        } else {
            return "Funcionário não localizado.";
        }
    }

    public function update($id, $nome, $email, $senha) {
        $this->funcionario->id = $id;
        $this->funcionario->nome = $nome;
        $this->funcionario->email = $email;
        $this->funcionario->senha = $senha;

        if($this->funcionario->update()) {
            return "Funcionário atualizado.";
        } else {
            return "Não foi possível atualizar o Funcionário.";
        }
    }

    public function delete($id) {
        $this->funcionario->id = $id;

        if($this->funcionario->delete()) {
            return "Funcionário foi excluído.";
        } else {
            return "Nao foi possível excluir Funcionário.";
        }
    }
    public function index() {
        return $this->readAll();
    }
    
    public function readAll() {
        $query = "SELECT id, nome, email, senha FROM " . $this->funcionario->table_nome;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $funcionarios;
    }
}
?>
