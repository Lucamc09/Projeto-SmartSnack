<?php
// Iniciar a sessão (se ainda não estiver iniciada)
session_start();

// Verificar se o formulário de registro foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir arquivo de conexão com o banco de dados
    include_once '../conexao.php';

    // Obter dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar se o usuário já existe
    $query = "SELECT id FROM Usuarios WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Verificar se já existe um usuário com o mesmo username
    if ($stmt->num_rows > 0) {
        echo "Nome de usuário já existe. <a href='registro.php'>Tente outro</a>";
    } else {
        // Hash da senha
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Preparar e executar a inserção no banco de dados
        $query = "INSERT INTO Usuarios (username, senha) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            // Registro bem-sucedido

            // Obter o ID do usuário recém-criado
            $userId = $stmt->insert_id;

            // Armazenar o ID do usuário na sessão
            $_SESSION['id'] = $userId;

            // Redirecionar para a página de login
            echo "Registro realizado com sucesso. <a href='login.php'>Faça login</a>";
        } else {
            // Erro ao inserir no banco de dados
            echo "Erro ao registrar. Por favor, tente novamente mais tarde.";
        }
    }

    // Fechar statement
    $stmt->close();

    // Fechar conexão com o banco de dados
    $conn->close();
}
?>
