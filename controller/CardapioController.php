<?php
    include_once '../../../model/Cardapio.php'; // ajuste o caminho se necessário

class CardapioController {
    private $db;
    private $Cardapio;

    public function __construct($db) {
        $this->db = $db;
        $this->Cardapio = new Cardapio($db);
    }


    public function excluir($id){
        return $this->Cardapio->excluir($id);
    }

    public function editar($nome, $preco, $id){
        return $this->Cardapio->editar($nome, $preco, $id);
    }

    public function adicionar($nome, $preco){
        return $this->Cardapio->adicionar($nome, $preco);
    }

    public function readAll() {
        $query = "SELECT id, nome, preco FROM " . $this->Cardapio->table_name;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
