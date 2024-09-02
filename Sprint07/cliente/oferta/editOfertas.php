<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Oferta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Editar Pedido</h1>
        <?php
        require('../../conexao.php');

        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            function buscarPedidoOferta($conexao, $id) {
                $sql = "SELECT * FROM PedidosOfertas WHERE id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            $pedidoOferta = buscarPedidoOferta($conexao, $id);
            if ($pedidoOferta) {
                ?>
                <form action="alterar_oferta.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pedidoOferta['id']); ?>">
                    
                    <div class="form-group">
                        <label for="oferta">Oferta:</label>
                        <select id="oferta" name="oferta" class="form-control">
                            <?php
                            $sql_ofertas = "SELECT id, titulo, preco FROM Ofertas WHERE CURDATE() BETWEEN data_inicio AND data_fim";
                            foreach ($conexao->query($sql_ofertas) as $row) {
                                $selected = ($pedidoOferta['oferta_id'] == $row['id']) ? 'selected' : '';
                                $preco_formatado = number_format($row['preco'], 2, ',', '.');
                                echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['id'] . ' - ' . $row['titulo'] . ' - R$ ' . $preco_formatado . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantidade">Quantidade:</label>
                        <input type="number" id="quantidade" name="quantidade" class="form-control" value="<?php echo htmlspecialchars($pedidoOferta['quantidade']); ?>" required>
                    </div>
                    
                    <input type="submit" value="Salvar" class="btn btn-primary">
                </form>
                <?php
            } else {
                echo "<p>Pedido não encontrado.</p>";
            }
        } else {
            echo "<p>ID da oferta não especificado.</p>";
        }
        ?>
        <br><br>
        <a href="../../index.php" class="btn btn-default">Voltar</a>
    </div>
</body>
</html>
