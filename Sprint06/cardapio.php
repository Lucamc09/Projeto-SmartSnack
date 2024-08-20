<?php
require('conexao.php');

// SQL para selecionar todos os produtos
$sql = "SELECT * FROM Produtos";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #F8F8FF;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #F50324;
            width: 100%;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1200px;
        }
        .produto {
            background: white;
            border: 1px solid #B0C4DE;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .produto h3 {
            color: #F50324;
            margin-bottom: 10px;
        }
        .produto p {
            color: #333;
            margin: 10px 0;
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
    </style>
</head>
<body>
    <h2>Cardápio</h2>
    <div class="grid-container">
        <?php if (count($produtos) > 0): ?>
            <?php foreach ($produtos as $produto): ?>
                <div class="produto">
                    <h3><?php echo htmlspecialchars($produto['produto']); ?></h3>
                    <p><strong>Preço: </strong>R$ <?php echo number_format($produto['preco'] ?? 0, 2, ',', '.'); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="produto">
                <p>Nenhum produto disponível no momento.</p>
            </div>
        <?php endif; ?>
    </div>

    <a href="index.php" class="btn-voltar">Voltar para o Início</a>
</body>
</html>
