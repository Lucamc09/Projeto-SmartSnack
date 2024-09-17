<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Exclusão de Pedido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Exclusão de Pedido</h1>
        <?php
        require('../../conexao.php');

        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            function excluirPedido($conexao, $id) {
                $sql = "DELETE FROM Pedidos WHERE id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
            }

            if (excluirPedido($conexao, $id)) {
                echo "<p>Pedido excluído com sucesso.</p>";
            } else {
                echo "<p>Erro ao excluir o pedido.</p>";
            }
        } else {
            echo "<p>ID do pedido não especificado.</p>";
        }
        ?>
        <br><br>
        <a href="../../index.php" class="btn btn-default">Voltar</a>
    </div>
</body>
</html>
