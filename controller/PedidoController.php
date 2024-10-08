<?php

include_once 'model/Pedido.php';

class PedidoController {
    private $db;
    private $pedido;

    public function __construct($db) {
        $this->db = $db;
        $this->pedido = new Pedido($db);
    }

    public function create($nome, $preco) {
        $this->pedido->nome = $nome;
        $this->pedido->preco = $preco;

        if($this->pedido->create()) {
            return "Pedido criado.";
        } else {
            return "Não foi possível criar Pedido.";
        }
    }

    public function readOne($id) {
        $this->pedido->id = $id;
        $this->pedido->readOne();

        if($this->pedido->nome != null) {
            $pedido_arr = array(
                "id" => $this->pedido->id,
                "nome" => $this->pedido->nome,
                "preco" => $this->pedido->preco
            );
            return $pedido_arr;
        } else {
            return "Pedido não localizado.";
        }
    }

    public function update($id, $nome, $preco) {
        $this->pedido->id = $id;
        $this->pedido->nome = $nome;
        $this->pedido->preco = $preco;

        if($this->pedido->update()) {
            return "Pedido atualizado.";
        } else {
            return "Não foi possível atualizar o Pedido.";
        }
    }

    public function delete($id) {
        $this->pedido->id = $id;

        if($this->pedido->delete()) {
            return "Pedido foi excluído.";
        } else {
            return "Nao foi possível excluir Pedido.";
        }
    }
    public function index() {
        return $this->readAll();
    }
    
    public function readAll() {
        $query = "SELECT id, nome, email, senha FROM " . $this->pedido->table_nome;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pedidos;
    }
}
?>
