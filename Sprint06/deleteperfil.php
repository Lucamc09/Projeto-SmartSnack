<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Exclusão de conta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Exclusão de conta</h1>
        <?php
        session_start();
        require('conexao.php');

        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];

            // Função para excluir os dados associados ao usuário
            function excluirDadosConta($conexao, $username) {
                // Ajuste o nome da coluna para `user_id`
                $sql = "DELETE FROM Pedidos WHERE user_id = :username";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                return $stmt->execute();
            }

            // Função para excluir a conta do usuário
            function excluirConta($conexao, $username) {
                $sql = "DELETE FROM users WHERE username = :username";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                return $stmt->execute();
            }

            try {
                $conexao->beginTransaction();

                if (excluirDadosConta($conexao, $username) && excluirConta($conexao, $username)) {
                    $conexao->commit();
                    echo "<p>Conta excluída com sucesso.</p>";
                    session_destroy();
                } else {
                    $conexao->rollBack();
                    echo "<p>Erro ao excluir a conta.</p>";
                }
            } catch (PDOException $e) {
                $conexao->rollBack();
                echo "<p>Erro ao excluir a conta: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>Usuário não especificado.</p>";
        }
        ?>
        <br><br>
        <a href="index.php" class="btn btn-default">Voltar</a>
    </div>
</body>
</html>
