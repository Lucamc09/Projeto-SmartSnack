<?php
/* email assunto mensagem */
include_once '../../../model/Contato.php';

class ContatoController {
    private $db;
    private $Contato;

    public function __construct($db) {
        $this->db = $db;
        $this->Contato = new Contato($db);
    }

    // Método para criar um novo contato
    public function create($assunto, $email, $mensagem) {
        $this->Contato->assunto = $assunto;
        $this->Contato->email = $email;
        $this->Contato->mensagem = $mensagem;

        if($this->Contato->create()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obter detalhes de um contato pelo ID
    public function readOne($id) {
        $this->Contato->id = $id;
        $this->Contato->readOne();

        if($this->Contato->mensagem != null) {
            // Cria um array associativo com os detalhes do contato
            $Contato_arr = array(
                "id" => $this->Contato->id,
                "email" => $this->Contato->email,
                "assunto" => $this->Contato->assunto,
                "mensagem" => $this->Contato->mensagem
            );
            return $Contato_arr;
        } else {
            return "Mensagem não localizada.";
        }
    }

    // Método para atualizar os dados de um contato
    public function update($id, $email, $assunto, $mensagem) {
        $this->Contato->id = $id;
        $this->Contato->email = $email;
        $this->Contato->assunto = $assunto;
        $this->Contato->mensagem = $mensagem; 

        if($this->Contato->update()) {
            return "Contato atualizado.";
        } else {
            return "Não foi possível atualizar o contato.";
        }
    }

    // Método para excluir um contato pelo ID
    public function delete($id) {
        $this->Contato->id = $id;

        if($this->Contato->delete()) {
            return "Contato foi excluído.";
        } else {
            return "Não foi possível excluir o contato.";
        }
    }

    // Método para listar todos os contatos
    public function index() {
        return $this->readAll();
    }

    // Método para listar todos os contatos
    public function readAll() {
        $query = "SELECT id, email, assunto, mensagem FROM " . $this->Contato->table_name; // Certifique-se de incluir todos os atributos
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $Contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $Contatos;
    }
}
?>
