<?php

include_once 'model/Usuario.php';

class UsuarioController {
    private $db;
    private $usuario;

    public function __construct($db) {
        $this->db = $db;
        $this->usuario = new Usuario($db);
    }

    // Método para criar um novo usuário
    public function create($nome, $email, $senha) {
        $this->usuario->nome = $nome;
        $this->usuario->email = $email;
        $this->usuario->senha = $senha;

        if($this->usuario->create()) {
            return "Usuário criado.";
        } else {
            return "Não foi possível criar usuário.";
        }
    }

    // Método para obter detalhes de um usuário pelo ID
    public function readOne($id) {
        $this->usuario->id = $id;
        $this->usuario->readOne();

        if($this->usuario->nome != null) {
            // Cria um array associativo com os detalhes do usuário
            $usuario_arr = array(
                "id" => $this->usuario->id,
                "nome" => $this->usuario->nome,
                "email" => $this->usuario->email,
                "senha" => $this->usuario->senha
            );
            return $usuario_arr;
        } else {
            return "Usuário não localizado.";
        }
    }

    // Método para atualizar os dados de um usuário
    public function update($id, $nome, $email, $senha) {
        $this->usuario->id = $id;
        $this->usuario->nome = $nome;
        $this->usuario->email = $email;
        $this->usuario->senha = $senha;

        if($this->usuario->update()) {
            return "Usuário atualizado.";
        } else {
            return "Não foi possível atualizar o usuário.";
        }
    }

    // Método para excluir um usuário pelo ID
    public function delete($id) {
        $this->usuario->id = $id;

        if($this->usuario->delete()) {
            return "Usuário foi excluído.";
        } else {
            return "Nao foi possível excluir usuário.";
        }
    }
    public function index() {
        return $this->readAll();
    }
    
    // Método para listar todos os usuários (exemplo adicional)
    public function readAll() {
        $query = "SELECT id, nome, email, senha FROM " . $this->usuario->table_nome;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    }
}
?>
