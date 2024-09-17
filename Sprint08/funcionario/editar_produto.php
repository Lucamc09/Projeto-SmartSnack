<?php
require('../conexao.php');

// Consulta para selecionar os produtos
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
    <title>Produtos Disponíveis</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
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
        .no-produto {
            grid-column: span 3;
            text-align: center;
            color: #333;
            padding: 20px;
            border: 1px solid #B0C4DE;
            border-radius: 10px;
            background: #FFF;
        }
        .btn-voltar, .btn-editar, .btn-excluir, .btn-custom {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .btn-voltar,.btn-custom {
            background: #F50324; /* Red color for back button */
        }
        .btn-voltar,.btn-custom:hover {
            background: #d0001c; /* Darker red for hover effect */
        }
        .btn-editar {
            background: #F50324; /* Blue color for edit button */
        }
        .btn-editar:hover {
            background: #d0001c; /* Darker blue for hover effect */
        }
        .btn-excluir {
            background: #FF4500; /* Orange color for delete button */
            margin-left: 10px;
        }
        .btn-excluir:hover {
            background: #CC3700; /* Darker orange for hover effect */
        }
        .div1 {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #F8F8FF;
            text-align: center;
            padding: 10px 0;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Produtos Disponíveis</h2>
    <div class="grid-container">
        <?php if (count($produtos) > 0): ?>
            <?php foreach ($produtos as $produto): ?>
                <div class="produto">
                    <h3><?php echo htmlspecialchars($produto['produto']); ?></h3>
                    <p><strong>Preço: </strong>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                    <a href="processar_editar_produto.php?id=<?php echo $produto['id']; ?>" class="btn-editar">Editar</a>
                    <form method="post" action="excluir_produto.php" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
                        <button type="submit" class="btn-excluir">Excluir</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-produto">
                <p>Nenhum produto disponível no momento.</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="div1">
        <a href="adicionar_produto.php" class="btn btn-custom">Adicionar Novo Produto</a>
        <a href="dashboard_funcionario.php" class="btn-voltar">Voltar para o Início</a>
    </div>
</body>
</html>
