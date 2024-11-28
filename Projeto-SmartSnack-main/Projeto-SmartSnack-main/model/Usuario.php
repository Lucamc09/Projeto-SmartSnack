<?php

class Usuario {
    private $conn;
    public $table_name = "Usuario";

    public $id;
    public $nome;
    public $email;
    public $senha;

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getNome($email) {
        // Query para buscar o nome pelo email
        $query = "SELECT nome FROM usuario WHERE email = :email";
        
        // Preparar a consulta
        $stmt = $this->db->prepare($query);
        
        // Vincular o parâmetro
        $stmt->bindParam(':email', $email);
        
        // Executar a consulta
        $stmt->execute();
        
        // Retornar o nome ou null caso não encontre
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nome'] : null;
    }

    public function getNomeById($id) {
        // Query para buscar o nome pelo id
        $query = "SELECT nome FROM usuario WHERE id = :id";

        // Preparar a consulta
        $stmt = $this->db->prepare($query);

        // Vincular o parâmetro
        $stmt->bindParam(':id', $id);

        // Executar a consulta
        $stmt->execute();

        // Retornar o nome ou null caso não encontre
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nome'] : null;
    }
    
    public function alterar_senha($id, $nova_senha) {
        // Atualiza o senha do usuário
        $senhaHash = password_hash($nova_senha, PASSWORD_BCRYPT);
        $query = "UPDATE Usuario SET senha = :nova_senha WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nova_senha', $senhaHash);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Verifica se alguma linha foi afetada
        if ($stmt->rowCount() > 0) {
            $_SESSION['senha'] = $nova_senha;
            return true;
        } else {
            $_SESSION['mensagem'] = 'Dados Invalidos.';
            return false;
        }
        
    }

    public function alterar_email($email_atual, $email_novo) {
        try {
            // Verifica se o novo email já existe
            $query = "SELECT COUNT(*) FROM Usuario WHERE email = :email_novo";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email_novo', $email_novo);
            $stmt->execute();
            $email_existe = $stmt->fetchColumn();
    
            if ($email_existe > 0) {
                $_SESSION['mensagem'] = 'O novo email já está em uso.';
                return false;
            }
    
            // Atualiza o email do usuário
            $query = "UPDATE Usuario SET email = :email_novo WHERE email = :email_atual";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email_atual', $email_atual);
            $stmt->bindParam(':email_novo', $email_novo);
            $stmt->execute();
    
            // Verifica se alguma linha foi afetada
            if ($stmt->rowCount() > 0) {
                $_SESSION['email'] = $email_novo;
                return true;
            } else {
                $_SESSION['mensagem'] = 'Nenhuma linha foi alterada. Verifique os dados fornecidos.';
                return false;
            }
        } catch (PDOException $e) {
            // Em caso de erro
            $_SESSION['mensagem'] = 'Erro ao atualizar o email: ' . $e->getMessage();
            return false;
        }
    }
    
    public function buscarUsuarioID($email) {
        // Query para buscar o id com base no email
        $query = "SELECT id FROM usuario WHERE email = :email LIMIT 1";
    
        // Preparar a consulta
        $stmt = $this->db->prepare($query);
    
        // Vincular o parâmetro
        $stmt->bindParam(':email', $email);
    
        // Executar a consulta
        $stmt->execute();
    
        // Retornar o resultado (ID do usuário ou null)
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['id'] : null;
    }

    public function logout() {
        session_start();
        session_unset(); // Remove todas as variáveis de sessão.
        session_destroy(); // Destrói a sessão.
        header("Location: ../../../view/index.php"); // Redireciona para a página de login.
        exit;
    }

    // Função que valida o login de usuários
    public function validarLogin($email, $senha) {
        // Busca o usuário no banco de dados
        $query = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        // Verifica se o usuário existe
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Se a senha for correta, retorna os dados do usuário
            return $usuario;
        }
        return false;
    }
    

    // Função para verificar se o email já existe
    public function emailExiste($email) {
        $sql = "SELECT COUNT(*) FROM Usuario WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Função para verificar se o nome já existe
    public function nomeExiste($nome) {
        $sql = "SELECT COUNT(*) FROM Usuario WHERE nome = :nome";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Função para cadastrar um novo usuário
    public function cadastrar($nome, $email, $senha) {
        // Verifica se o email ou nome já existe
        if ($this->emailExiste($email)) {
            return 'O email já está em uso.';
        }

        if ($this->nomeExiste($nome)) {
            return 'O nome já está em uso.';
        }

        // Criptografando a senha
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

        // Prepara a consulta SQL para inserir o usuário
        $sql = "INSERT INTO Usuario (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($sql);

        // Associa os parâmetros à consulta
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);

        // Executa a consulta e retorna o resultado
        if ($stmt->execute()) {
            return true; // Cadastro realizado com sucesso
        }
        return false; // Falha ao cadastrar
    }
}
?>