<?php
session_start();
require('../conexao.php');

// Verifica se o usuário está logado como funcionário
if (!isset($_SESSION['id_funcionario'])) {
    header('Location: login_funcionario.php');
    exit();
}

// Verifica se o ID do produto foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: dashboard_funcionario.php');
    exit();
}

$id = $_GET['id'];

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valida e processa os dados do formulário
    $produto = $_POST['produto'];
    $preco = $_POST['preco'];

    // Atualiza o produto no banco de dados
    try {
        $sql = "UPDATE Produtos SET produto = :produto, preco = :preco WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produto', $produto);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $_SESSION['success'] = "Produto atualizado com sucesso!";
        header('Location: editar_produto.php');
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    // Se o formulário não foi enviado, exibe o formulário de edição
    try {
        $sql = "SELECT * FROM Produtos WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

    if (!$produto) {
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
    <title>Editar Produto</title>
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
</head>
<body>
    <div class="container">
        <h2>Editar Produto</h2>

        <form method="post" action="processar_editar_produto.php?id=<?php echo htmlspecialchars($id); ?>">
            <div class="input-group">
                <label>Nome do Produto</label>
                <input type="text" name="produto" value="<?php echo htmlspecialchars($produto['produto']); ?>" required>
            </div>
            <div class="input-group">
                <label>Preço</label>
                <input type="number" name="preco" value="<?php echo htmlspecialchars($produto['preco']); ?>" step="0.01" required>
            </div>
            <button type="submit" class="btn">Atualizar Produto</button>
            <a href="dashboard_funcionario.php" class="btn btn-cancel">Cancelar</a>
        </form>

    </div>
</body>
</html>
