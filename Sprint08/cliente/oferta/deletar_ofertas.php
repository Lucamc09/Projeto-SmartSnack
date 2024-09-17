<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Exclusão de Oferta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Exclusão de Oferta</h1>
        <?php
        require('../../conexao.php');

        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            function excluirOferta($conexao, $id) {
                $sql = "DELETE FROM PedidosOfertas WHERE id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
            }

            if (excluirOferta($conexao, $id)) {
                echo "<p>Oferta excluído com sucesso.</p>";
            } else {
                echo "<p>Erro ao excluir o Oferta.</p>";
            }
        } else {
            echo "<p>ID do Oferta não especificado.</p>";
        }
        ?>
        <br><br>
        <a href="../../index.php" class="btn btn-default">Voltar</a>
    </div>
</body>
</html>
