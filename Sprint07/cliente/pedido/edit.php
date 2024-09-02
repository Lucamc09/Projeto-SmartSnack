<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
    <style>
        /* CSS no mesmo estilo dos outros arquivos */
        .container {
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
        h1 {
            color: #F50324;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group select, .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn-primary {
            padding: 10px 20px;
            background-color: #F50324;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #d0001c;
        }
        .btn-default {
            padding: 10px 20px;
            background-color: #ccc;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
        .btn-default:hover {
            background-color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Pedido</h1>
        <?php
        require('../../conexao.php');

        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            function buscarPedido($conexao, $id) {
                $sql = "SELECT * FROM Pedidos WHERE id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            function buscarProduto($conexao, $produto_id) {
                $sql = "SELECT * FROM Produtos WHERE id = :produto_id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            $pedido = buscarPedido($conexao, $id);
            if ($pedido) {
                $produto = buscarProduto($conexao, $pedido['produto_id']);
                ?>
                <form action="alterar_dados.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pedido['id']); ?>">
                    <div class="form-group">
                        <label for="produto">Produto:</label>
                        <select id="produto" name="produto" class="form-control" onchange="atualizarPreco(this.value)">
                            <?php
                            $sql_produtos = "SELECT id, produto, preco FROM Produtos";
                            foreach ($conexao->query($sql_produtos) as $row) {
                                $selected = ($pedido['produto_id'] == $row['id']) ? 'selected' : '';
                                echo '<option value="' . $row['id'] . '" data-preco="' . $row['preco'] . '" ' . $selected . '>' . htmlspecialchars($row['produto']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preço:</label>
                        <p id="preco"><?php echo 'R$ ' . number_format($produto['preco'], 2, ',', '.'); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <input type="number" id="quantidade" name="quantidade" class="form-control" value="<?php echo htmlspecialchars($pedido['quantidade']); ?>" required>
                    </div>
                    <input type="submit" value="Salvar" class="btn-primary">
                </form>
                <script>
                    function atualizarPreco(produtoId) {
                        var select = document.getElementById('produto');
                        var option = select.options[select.selectedIndex];
                        var preco = option.getAttribute('data-preco');
                        document.getElementById('preco').innerText = 'R$ ' + (preco * 1).toFixed(2).replace('.', ',');
                    }
                </script>
                <?php
            } else {
                echo "<p>Pedido não encontrado.</p>";
            }
        } else {
            echo "<p>ID do pedido não especificado.</p>";
        }
        ?>
        <br><br>
        <a href="../../index.php" class="btn-default">Voltar</a>
    </div>
</body>
</html>
