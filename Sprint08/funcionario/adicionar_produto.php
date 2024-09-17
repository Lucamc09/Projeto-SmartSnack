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
    $produto = $_POST['produto'];
    $preço = $_POST['preço'];

    // Verifica se a variável $conexao está definida
    if (!isset($conexao)) {
        die("Erro: a conexão com o banco de dados não foi estabelecida.");
    }

    // Prepara a consulta SQL
    $query = "INSERT INTO Produtos (produto, preco) VALUES (:produto, :preco)";

    try {
        // Prepara a declaração
        $stmt = $conexao->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':produto', $produto);
        $stmt->bindParam(':preco', $preço); // Corrigido para usar ':preco' no bindParam

        // Executa a declaração
        if ($stmt->execute()) {
            echo "Produto adicionado com sucesso!";
        } else {
            echo "Erro ao adicionar o produto.";
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
    <title>Adicionar Produto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">
    <style>
        /* Seu CSS personalizado aqui */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #F8F8FF;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #F50324;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            padding: 10px 20px;
            background-color: #F50324;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #d0001c;
        }
        .btn-cancel {
            background-color: #ccc;
            color: black;
        }
        .btn-cancel:hover {
            background-color: #aaa;
        }
    </style>
    <div class="container">
        <h2>Adicionar Produto</h2>

        <form method="post" action="">
            <div class="input-group">
                <label>Nome do Produto</label>
                <input type="text" name="produto" required>
            </div>
            <div class="input-group">
                <label>Preço</label>
                <input type="number" name="preço" required>
            </div>
            <button type="submit" class="btn">Adicionar Produto</button>
            <a href="dashboard_funcionario.php" class="btn btn-cancel">Cancelar</a>
        </form>
    </div>
</body>
</html>
