<?php

class Funcionario {
    private $conn;
    public $table_name = "Funcionario";

    public $id;
    public $nome;
    public $email;
    public $senha;

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Função que valida o login de funcionários
    public function validarLogin($email, $senha) {
        // Busca o funcionário no banco de dados
        $query = "SELECT * FROM funcionario WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        // Verifica se o funcionário existe
        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($funcionario && password_verify($senha, $funcionario['senha'])) {
            // Se a senha for correta, retorna os dados do funcionário
            return $funcionario;
        }
        return false;
    }
    
    public function buscarFuncionarioId($email) {
        // Query para buscar o id com base no email
        $query = "SELECT id FROM funcionario WHERE email = :email LIMIT 1";

        // Preparar a consulta
        $stmt = $this->db->prepare($query);

        // Vincular o parâmetro
        $stmt->bindParam(':email', $email);

        // Executar a consulta
        $stmt->execute();

        // Retornar o resultado (ID do funcionário ou null)
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
    
    

    public function alterar_senha($id, $nova_senha) {
       // Atualiza o senha do usuário
       $senhaHash = password_hash($nova_senha, PASSWORD_BCRYPT);
       $query = "UPDATE Funcionario SET senha = :nova_senha WHERE id = :id";
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

    public function getNome($email) {
        // Query para buscar o nome pelo email
        $query = "SELECT nome FROM funcionario WHERE email = :email";
        
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

    /*

    // Função para verificar se o email já existe
    public function emailExiste($email) {
        $sql = "SELECT COUNT(*) FROM Funcionario WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Função para verificar se o nome já existe
    public function nomeExiste($nome) {
        $sql = "SELECT COUNT(*) FROM Funcionario WHERE nome = :nome";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Função para cadastrar um novo funcionário
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

        // Prepara a consulta SQL para inserir o funcionário
        $sql = "INSERT INTO Funcionario (nome, email, senha) VALUES (:nome, :email, :senha)";
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
    */
}