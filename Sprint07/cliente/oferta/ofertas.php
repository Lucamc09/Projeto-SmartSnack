<?php
require('../../conexao.php');

$sql = "SELECT * FROM Ofertas WHERE CURDATE() BETWEEN data_inicio AND data_fim";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleHEADER.css">
    <title>Ofertas Especiais</title>
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
        .oferta {
            background: white;
            border: 1px solid #B0C4DE;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .oferta h3 {
            color: #F50324;
            margin-bottom: 10px;
        }
        .oferta p {
            color: #333;
            margin: 10px 0;
        }
        .oferta img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 10px;
        }
        .no-oferta {
            grid-column: span 3;
            text-align: center;
            color: #333;
            padding: 20px;
            border: 1px solid #B0C4DE;
            border-radius: 10px;
            background: #FFF;
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
        .btn-adicionar {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background: #28a745; /* Green color for add to cart button */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-adicionar:hover {
            background: #218838; /* Darker green for hover effect */
        }
    </style>
</head>
<body>
    \
    <h2>Ofertas Especiais</h2>
    <div class="grid-container">
        <?php if (count($ofertas) > 0): ?>
            <?php foreach ($ofertas as $oferta): ?>
                <div class="oferta">
                    <h3><?php echo htmlspecialchars($oferta['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($oferta['descricao']); ?></p>
                    <p><strong>Preço: </strong>R$ <?php echo number_format($oferta['preco'], 2, ',', '.'); ?></p>
                    <?php if (!empty($oferta['imagem'])): ?>
                        <img src="<?php echo htmlspecialchars($oferta['imagem']); ?>" alt="Imagem da Oferta">
                    <?php endif; ?>
                    <form method="get" action="cadastro_oferta.php">
                        <input type="hidden" name="id_oferta" value="<?php echo $oferta['id']; ?>">
                        <button type="submit" class="btn-adicionar">Adicionar ao Carrinho</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-oferta">
                <p>Nenhuma oferta disponível no momento.</p>
            </div>
        <?php endif; ?>
    </div>

    <a href="../../index.php" class="btn-voltar">Voltar para o Início</a>
</body>
</html>
