<?php
session_start();
require('../../conexao.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['username']; // Supondo que o username é usado como user_id

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $oferta_id = $_GET['oferta_id'];
    $quantidade = $_POST['quantidade'];
    

    if (empty($oferta_id) || empty($quantidade)) {
        echo "<p>Por favor, preencha todos os campos.</p>";
        exit();
    }

    if (!isset($conexao)) {
        die("Erro: a conexão com o banco de dados não foi estabelecida.");
    }

    // Prepara a consulta SQL para inserir dados na tabela PedidosOfertas
    $query = "INSERT INTO PedidosOfertas (oferta_id, user_id, quantidade)
              VALUES (:oferta_id, :user_id, :quantidade)";

    try {
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':oferta_id', $oferta_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':quantidade', $quantidade);

        if ($stmt->execute()) {
            echo "<p>Pedido adicionado com sucesso!</p>";
            $ofertaDetalhes = null;
            $oferta_id = $_GET['oferta_id'];
            $queryDetalhes = "SELECT * FROM Ofertas WHERE id = :oferta_id";
            $stmtDetalhes = $conexao->prepare($queryDetalhes);
            $stmtDetalhes->bindParam(':oferta_id', $oferta_id);
            $stmtDetalhes->execute();
            $ofertaDetalhes = $stmtDetalhes->fetch(PDO::FETCH_ASSOC);
            echo "<div class='detalhes-pedido'>";
            echo "<h3>Detalhes do Pedido</h3>";
            echo "<p><strong>Nome da Oferta:</strong> " . htmlspecialchars($ofertaDetalhes['titulo']) . "</p>";
            echo "<p><strong>Oferta_id:</strong> " . htmlspecialchars($oferta_id) . "</p>";
            echo "<p><strong>Preço:</strong> R$ " . number_format($ofertaDetalhes['preco'], 2, ',', '.') . "</p>";
            echo "<p><strong>Quantidade:</strong> " . htmlspecialchars($quantidade) . "</p>";
            echo "<a href='ofertas.php' class='btn btn-voltar'>Voltar para Ofertas</a>";
            echo "</div>";        
        } else {
            echo "<p>Erro ao adicionar o pedido.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Erro: " . $e->getMessage() . "</p>";
    }
} else {
    // Se não for POST, mostrar o formulário
    if (!isset($conexao)) {
        die("Erro: a conexão com o banco de dados não foi estabelecida.");
    }

    // Buscar ofertas para o dropdown
    $query = "SELECT id, titulo FROM Ofertas WHERE CURDATE() BETWEEN data_inicio AND data_fim";
    $stmt = $conexao->prepare($query);
    $stmt->execute();
    $ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Se uma oferta foi selecionada, buscar seus detalhes
    $ofertaDetalhes = null;
    if (isset($_GET['oferta_id'])) {
        $oferta_id = $_GET['oferta_id'];
        $queryDetalhes = "SELECT * FROM Ofertas WHERE id = :oferta_id";
        $stmtDetalhes = $conexao->prepare($queryDetalhes);
        $stmtDetalhes->bindParam(':oferta_id', $oferta_id);
        $stmtDetalhes->execute();
        $ofertaDetalhes = $stmtDetalhes->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Oferta</title>
    <style>
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
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <!-- Mensagem de sucesso ou erro já exibida acima no PHP -->
        <?php else: ?>
            <?php if ($ofertas): ?>
                
        <h2>Adicionar Quantidade</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="oferta_id"><b>Oferta:</b></label><br>
                        <select id="oferta_id" name="oferta_id" class="form-control" onchange="location = this.value;">
                            <option value="">Selecione uma oferta</option>
                            <?php foreach ($ofertas as $oferta): ?>
                                <option value="?oferta_id=<?php echo $oferta['id']; ?>" <?php echo (isset($_GET['oferta_id']) && $_GET['oferta_id'] == $oferta['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($oferta['titulo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if ($ofertaDetalhes): ?>
                        <div class="form-group">
                            <label><b>Descrição:</b></label>
                            <p><?php echo htmlspecialchars($ofertaDetalhes['descricao']); ?></p>
                        </div>
                        <div class="form-group">
                            <label><b>Preço:</b></label>
                            <p>R$ <?php echo number_format($ofertaDetalhes['preco'], 2, ',', '.'); ?></p>
                        </div>
                        <div class="input-group">
                            <label><b>Quantidade</b></label>
                            <input type="number" name="quantidade" min="1" required>
                        </div>
                        <button type="submit" class="btn">Adicionar ao Carrinho</button>
                    <?php else: ?>
                        <p>Selecione uma oferta para ver mais detalhes.</p>
                    <?php endif; ?>

                    <a href="ofertas.php" class="btn btn-cancel">Cancelar</a>
                </form>
            <?php else: ?>
                <p>Nenhuma oferta disponível no momento.</p>
                <a href="ofertas.dphp" class="btn btn-voltar">Voltar para Ofertas</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>
</html>

