<?php
session_start();
require('../../conexao.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['username'];

$produtoDetalhes = null;
if (isset($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];
    $queryDetalhes = "SELECT * FROM Produtos WHERE id = :produto_id";
    $stmtDetalhes = $conexao->prepare($queryDetalhes);
    $stmtDetalhes->bindParam(':produto_id', $produto_id);
    $stmtDetalhes->execute();
    $produtoDetalhes = $stmtDetalhes->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantidade = $_POST['quantidade'];

    if (empty($produto_id) || empty($quantidade)) {
        echo "<p>Por favor, preencha todos os campos.</p>";
        exit();
    }

    if (!isset($conexao)) {
        die("Erro: a conexão com o banco de dados não foi estabelecida.");
    }

    $query = "INSERT INTO Pedidos (produto_id, user_id, quantidade)
              VALUES (:produto_id, :user_id, :quantidade)";

    try {
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':produto_id', $produto_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':quantidade', $quantidade);

        if ($stmt->execute()) {
            echo "<p>Pedido adicionado com sucesso!</p>";
        } else {
            echo "<p>Erro ao adicionar o pedido.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Erro: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedido</title>
    <style>
        /* CSS fornecido */
        .detalhes-pedido {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        .input-group, .form-group {
            margin-bottom: 15px;
        }
        .input-group label, .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .input-group input, .form-group select {
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
        .btn-voltar {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background: #F50324;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .btn-voltar:hover {
            background: #d0001c;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Pedido</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="produto_id"><b>Produto:</b></label><br>
                <select id="produto_id" name="produto_id" class="form-control" onchange="location = this.value;">
                    <option value="">Selecione um produto</option>
                    <?php
                        // Buscar produtos para o dropdown
                        $query = "SELECT id, produto FROM Produtos";
                        $stmt = $conexao->prepare($query);
                        $stmt->execute();
                        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($produtos as $produto) {
                            echo '<option value="?produto_id=' . $produto['id'] . '" ' . (isset($_GET['produto_id']) && $_GET['produto_id'] == $produto['id'] ? 'selected' : '') . '>' . htmlspecialchars($produto['produto']) . '</option>';
                        }
                    ?>
                </select>
            </div>

            <?php if ($produtoDetalhes): ?>
                <div class="form-group">
                    <label><b>Preço:</b></label>
                    <p>R$ <?php echo number_format($produtoDetalhes['preco'], 2, ',', '.'); ?></p>
                </div>
                <div class="input-group">
                    <label><b>Quantidade</b></label>
                    <input type="number" name="quantidade" min="1" required>
                </div>
                <button type="submit" class="btn">Adicionar ao Carrinho</button>
            <?php else: ?>
                <p>Selecione um produto para ver mais detalhes.</p>
            <?php endif; ?>

            <a href="../../index.php" class="btn btn-cancel">Cancelar</a>
        </form>
    </div>
</body>
</html>
