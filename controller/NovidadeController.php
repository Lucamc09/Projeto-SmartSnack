<?php
include_once '../../../model/Novidade.php';

class NovidadeController {
    private $db;
    private $Novidade;

    public function __construct($db) {
        $this->db = $db;
        $this->Novidade = new Novidade($db);
    }

    public function adicionar($titulo, $descricao) {
        return $this->Novidade->adicionar($titulo, $descricao);
    }

    public function editar($titulo, $descricao,$id){
        return $this->Novidade->editar($titulo, $descricao, $id);
    }

    public function BuscaID($titulo,$descricao){
        return $this->Novidade->BuscaID($titulo,$descricao);
    }

    public function buscarPorId($id){
        return $this->Novidade->buscarPorId($id);
    }

    public function excluir($id) {
        return $this->Novidade->excluir($id);
    }

    public function readOne($id) {
        $this->Novidade->id = $id;
        if ($this->Novidade->readOne()) {
            return [
                "id" => $this->Novidade->id,
                "titulo" => $this->Novidade->titulo,
                "descricao" => $this->Novidade->descricao
            ];
        } else {
            return "Novidade não localizada.";
        }
    }

    public function update($id, $titulo, $descricao) {
        $this->Novidade->id = $id;
        $this->Novidade->titulo = $titulo;
        $this->Novidade->descricao = $descricao;

        if ($this->Novidade->update()) {
            return "Novidade atualizada.";
        } else {
            return "Não foi possível atualizar a novidade.";
        }
    }


    public function index() {
        return $this->readAll();
    }

    public function readAll() {
        return $this->Novidade->readAll();
    }
}
?>