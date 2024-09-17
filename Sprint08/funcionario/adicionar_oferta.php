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
    $produto_id = $_POST['produto_id'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Verifica se a variável $conexao está definida
    if (!isset($conexao)) {
        die("Erro: a conexão com o banco de dados não foi estabelecida.");
    }

    // Prepara a consulta SQL
    $query = "INSERT INTO Ofertas (produto_id, titulo, descricao, preco, data_inicio, data_fim)
              VALUES (:produto_id ,:titulo, :descricao, :preco, :data_inicio, :data_fim)";

    try {
        // Prepara a declaração
        $stmt = $conexao->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':produto_id', $produto_id);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="container">
    <style>
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
        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .input-group textarea {
            resize: none;
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
        <h2> Adicionar Oferta</h2>

        <form method="post" action="">
            <div class="input-group">
                <label>ID do Produto</label>
                <input type="text" name="produto_id" required>
            </div>
            <div class="input-group">
                <label>Nome do produto</label>
                <input type="text" name="titulo" required>
            </div>
            <div class="input-group">
                <label>Descrição</label>
                <textarea name="descricao" required></textarea>
            </div>
            <div class="input-group">
                <label>Preço</label>
                <input type="number" name="preco" step="0.01" required>
            </div>
            <div class="input-group">
                <label>Data de Início</label>
                <input type="date" name="data_inicio" >
            </div>
            <div class="input-group">
                <label>Data de Fim</label>
                <input type="date" name="data_fim" >
            </div>
            <button type="submit" class="btn">Adicionar Oferta</button>
            <a href="editar_oferta.php" class="btn btn-cancel">Cancelar</a>
        </form>
    </div>
</body>
</html>
