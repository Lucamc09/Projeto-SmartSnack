<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Pedido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Editar Pedido</h1>
        <?php
        require('conexao.php');

        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            function buscarPedido($conexao, $id) {
                $sql = "SELECT * FROM Pedidos WHERE id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            $pedido = buscarPedido($conexao, $id);
            if ($pedido) {
                ?>
                <form action="alterar_dados.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pedido['id']); ?>">
                    <div class="form-group">
                        <label for="produto">Produto:</label>
                        <select id="produto" name="produto" class="form-control">
                            <?php
                            $sql_produtos = "SELECT id, produto FROM Produtos";
                            foreach ($conexao->query($sql_produtos) as $row) {
                                $selected = ($pedido['produto_id'] == $row['id']) ? 'selected' : '';
                                echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['produto'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <input type="number" id="quantidade" name="quantidade" class="form-control" value="<?php echo htmlspecialchars($pedido['quantidade']); ?>" required>
                    </div>
                    <input type="submit" value="Salvar" class="btn btn-primary">
                </form>
                <?php
            } else {
                echo "<p>Pedido não encontrado.</p>";
            }
        } else {
            echo "<p>ID do pedido não especificado.</p>";
        }
        ?>
        <br><br>
        <a href="index.php" class="btn btn-default">Voltar</a>
    </div>
</body>
</html>
