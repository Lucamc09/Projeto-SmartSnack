<?php
session_start();

// Conectar ao banco de dados
$db = mysqli_connect('localhost', 'root', '', 'bd_cantina');

// Verificar conexão com o banco de dados
if (!$db) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Inicializar variáveis
$id_funcionario = "";
$senha = "";
$errors = array();

// LOGIN FUNCIONÁRIO
if (isset($_POST['login_funcionario'])) {
    $id_funcionario = mysqli_real_escape_string($db, $_POST['id_funcionario']);
    $senha = mysqli_real_escape_string($db, $_POST['senha']);

    // Validar entrada
    if (empty($id_funcionario)) {
        array_push($errors, "ID do Funcionário é obrigatório");
    }
    if (empty($senha)) {
        array_push($errors, "Senha é obrigatória");
    }

    // Verificar se não há erros
    if (count($errors) == 0) {
        $senha = md5($senha); // Certifique-se de que a senha está criptografada
        $query = "SELECT * FROM funcionarios WHERE id_funcionario='$id_funcionario' AND senha='$senha'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            // Usuário encontrado, definir variáveis de sessão
            $_SESSION['id_funcionario'] = $id_funcionario;
            $_SESSION['nome_funcionario'] = mysqli_fetch_assoc($results)['nome']; // Assumindo que o nome do funcionário está na tabela
            header('Location: dashboard_funcionario.php');
            exit();
        } else {
            array_push($errors, "ID ou senha inválidos");
        }
    }

    // Armazenar erros na sessão para exibição
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header('Location: login_funcionario.php');
        exit();
    }
}
?>
