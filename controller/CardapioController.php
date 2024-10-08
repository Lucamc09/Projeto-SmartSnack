<?php
include_once 'models/Cardapio.php';

class CardapioController {
    private $db;
    private $Cardapio;

    public function __construct($db) {
        $this->db = $db;
        $this->Cardapio = new Cardapio($db);
    }

    public function create($nome, $preco) {
        $this->Cardapio->nome = $nome;
        $this->Cardapio->preco = $preco;

        if ($this->Cardapio->create()) {
            return "Cardapio criado.";
        } else {
            return "Não foi possível criar o Cardapio.";
        }
    }

    public function readOne($id) {
        $this->Cardapio->id = $id;
        if ($this->Cardapio->readOne()) {
            return [
                "id" => $this->Cardapio->id,
                "nome" => $this->Cardapio->nome,
                "preco" => $this->Cardapio->preco
            ];
        } else {
            return "Cardapio não localizado.";
        }
    }

    public function update($id, $nome, $preco) {
        $this->Cardapio->id = $id;
        $this->Cardapio->nome = $nome;
        $this->Cardapio->preco = $preco;

        if ($this->Cardapio->update()) {
            return "Cardapio atualizado.";
        } else {
            return "Não foi possível atualizar o Cardapio.";
        }
    }

    public function delete($id) {
        $this->Cardapio->id = $id;

        if ($this->Cardapio->delete()) {
            return "Cardapio foi excluído.";
        } else {
            return "Não foi possível excluir o Cardapio.";
        }
    }

    public function index() {
        return $this->readAll();
    }

    public function readAll() {
        $query = "SELECT id, nome, preco FROM " . $this->Cardapio->table_name;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
