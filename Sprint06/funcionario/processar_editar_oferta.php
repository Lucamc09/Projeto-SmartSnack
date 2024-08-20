<?php
session_start();
require('../conexao.php');

// Verifica se o usuário está logado como funcionário
if (!isset($_SESSION['id_funcionario'])) {
    header('Location: login_funcionario.php');
    exit();
}

// Verifica se o ID da oferta foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: dashboard_funcionario.php');
    exit();
}

$id = $_GET['id'];

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valida e processa os dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Atualiza a oferta no banco de dados
    try {
        $sql = "UPDATE Ofertas SET titulo = :titulo, descricao = :descricao, preco = :preco, data_inicio = :data_inicio, data_fim = :data_fim WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':data_inicio', $data_inicio);
        $stmt->bindParam(':data_fim', $data_fim);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $_SESSION['success'] = "Oferta atualizada com sucesso!";
        header('Location: dashboard_funcionario.php');
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    // Se o formulário não foi enviado, exibe o formulário de edição
    try {
        $sql = "SELECT * FROM Ofertas WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $oferta = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

    if (!$oferta) {
        header('Location: dashboard_funcionario.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Oferta</title>
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
</head>
<body>
    <div class="container">
        <h2>Editar Oferta</h2>

        <form method="post" action="processar_editar_oferta.php?id=<?php echo htmlspecialchars($id); ?>">
            <div class="input-group">
                <label>Título</label>
                <input type="text" name="titulo" value="<?php echo htmlspecialchars($oferta['titulo']); ?>" required>
            </div>
            <div class="input-group">
                <label>Descrição</label>
                <textarea name="descricao" required><?php echo htmlspecialchars($oferta['descricao']); ?></textarea>
            </div>
            <div class="input-group">
                <label>Preço</label>
                <input type="number" name="preco" value="<?php echo htmlspecialchars($oferta['preco']); ?>" step="0.01" required>
            </div>
            <div class="input-group">
                <label>Data de Início</label>
                <input type="date" name="data_inicio" value="<?php echo htmlspecialchars($oferta['data_inicio']); ?>">
            </div>
            <div class="input-group">
                <label>Data de Fim</label>
                <input type="date" name="data_fim" value="<?php echo htmlspecialchars($oferta['data_fim']); ?>">
            </div>
            <button type="submit" class="btn">Atualizar Oferta</button>
            <a href="editar_oferta.php" class="btn btn-cancel">Cancelar</a>
        </form>
    </div>
</body>
</html>
