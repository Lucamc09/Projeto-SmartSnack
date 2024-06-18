<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Atualização</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Confirmação de Atualização</h1>
        <?php
        require('conexao.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"];
            $produto = $_POST["produto"];
            $quantidade = $_POST["quantidade"];

            // Função para atualizar o registro no banco de dados
            function atualizarPedido($conexao, $id, $produto, $quantidade) {
                $sql = "UPDATE Pedidos SET produto_id = :produto_id, quantidade = :quantidade WHERE id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':produto_id', $produto, PDO::PARAM_INT);
                $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
            }

            // Verifica se a atualização foi bem-sucedida
            if (atualizarPedido($conexao, $id, $produto, $quantidade)) {
                echo "<p>Pedido atualizado com sucesso!</p>";
                echo '<a href="index.php" class="btn btn-default">Voltar para a Página Inicial</a>';
            } else {
                echo "<p>Ocorreu um erro ao atualizar o pedido.</p>";
                echo '<a href="editar_pedido.php?id=' . $id . '" class="btn btn-default">Voltar para a Edição do Pedido</a>';
            }
        } else {
            echo "<p>Operação inválida.</p>";
            echo '<a href="index.php" class="btn btn-default">Voltar para a Página Inicial</a>';
        }
        ?>
    </div>
</body>
</html>
