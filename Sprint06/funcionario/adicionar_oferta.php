<?php
session_start();

// Inclua o arquivo de conexão com o banco de dados
include('../conexao.php'); // Ajuste o caminho conforme necessário

// Verifica se o usuário está logado como funcionário
if (!isset($_SESSION['id_funcionario'])) {
    header('Location: login_funcionario.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Verifica se a variável $conexao está definida
    if (!isset($conexao)) {
        die("Erro: a conexão com o banco de dados não foi estabelecida.");
    }

    // Prepara a consulta SQL
    $query = "INSERT INTO Ofertas (titulo, descricao, preco, data_inicio, data_fim)
              VALUES (:titulo, :descricao, :preco, :data_inicio, :data_fim)";

    try {
        // Prepara a declaração
        $stmt = $conexao->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':data_inicio', $data_inicio);
        $stmt->bindParam(':data_fim', $data_fim);

        // Executa a declaração
        if ($stmt->execute()) {
            echo "Oferta adicionada com sucesso!";
        } else {
            echo "Erro ao adicionar a oferta.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Oferta</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style4.css"> <!-- Ajuste o caminho -->
</head>
<body class="container">
    <div class="header">
        <h2>Adicionar Nova Oferta</h2>
    </div>

    <form method="post" action="">
        <div class="input-group">
            <label>Título</label>
            <input type="text" name="titulo" required>
        </div>
        <div class="input-group">
            <label>Descrição</label>
            <textarea name="descricao" rows="4" required></textarea>
        </div>
        <div class="input-group">
            <label>Preço</label>
            <input type="text" name="preco" required>
        </div>
        <div class="input-group">
            <label>Data de Início</label>
            <input type="date" name="data_inicio" required>
        </div>
        <div class="input-group">
            <label>Data de Fim</label>
            <input type="date" name="data_fim" required>
        </div>
        <div class="input-group">
            <button type="submit" class="btn btn-primary">Adicionar Oferta</button>
        </div>
        
        <div class="input-group">
            <a href="dashboard_funcionario.php" class="btn btn-default">Voltar</a>
        </div>
    </form>
</body>
</html>
