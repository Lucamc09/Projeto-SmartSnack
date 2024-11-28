<?php
    #include_once '../model/Pedido.php';
    include_once '../../../model/Pedido.php'; // ajuste o caminho se necessário

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

    public function excluirPedido($id) {
        // Verifica se o ID foi especificado
        if (isset($id)) {
            // Query SQL para excluir o pedido
            $sql = "DELETE FROM " . $this->pedido->table_name . " WHERE id = :id";
    
            // Preparando a declaração
            $stmt = $this->db->prepare($sql);
    
            // Vincula o ID do pedido
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Executa e retorna o resultado
            if ($stmt->execute()) {
                return true;  // Pedido excluído com sucesso
            } else {
                return false;  // Falha na exclusão
            }
        } else {
            return false;  // Caso o ID não tenha sido passado
        }
    }

    public function selectAll() {
        return  $this->pedido->selectAll();
    }
    
    public function readAll($usuario_id) {
        $query = "SELECT id, nome, preco FROM " . $this->pedido->table_name . " WHERE usuario_id = :usuario_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    
    public function adicionarPedido($nome, $preco, $usuario_id) {
        // Query para inserir o pedido com o usuario_id
        $query = "INSERT INTO pedido (nome, preco, usuario_id) VALUES (:nome, :preco, :usuario_id)";
        
        // Preparar a consulta
        $stmt = $this->db->prepare($query);
        
        // Vincular os parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        
        // Executar e retornar o resultado
        return $stmt->execute();

        //return $this->pedido->adicionar($nome, $preco);
    }
    
}
?>
