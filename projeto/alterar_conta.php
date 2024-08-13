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
        session_start(); // Certifique-se de iniciar a sessão

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Função para buscar o usuário
            function buscarUsuario($conexao, $username) {
                $sql = "SELECT * FROM users WHERE username = :username";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            $perfil = buscarUsuario($conexao, $username);

            // Função para atualizar o registro no banco de dados
            function atualizarUsuario($conexao, $id, $username, $email, $password) {
                $sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
            }

            // Atualizar `user_id` nas tabelas de pedidos após atualização de perfil
            function atualizarCarrinhoUsuario($conexao, $id, $novoId) {
                $sql = "UPDATE pedidos SET user_id = :novo_id WHERE user_id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':novo_id', $novoId, PDO::PARAM_INT);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
            }

            // Verifica se a atualização foi bem-sucedida
            if (atualizarUsuario($conexao, $id, $username, $email, $password)) {
                // Atualiza a variável de sessão
                $_SESSION['username'] = $username;

                // Atualiza o user_id na tabela de pedidos
                if (atualizarCarrinhoUsuario($conexao, $id, $id)) {
                    echo "<p>Perfil e pedidos atualizados com sucesso!</p>";
                } else {
                    echo "<p>Perfil atualizado, mas não foi possível atualizar os pedidos.</p>";
                }

                echo '<a href="index.php" class="btn btn-default">Voltar para a Página Inicial</a>';
            } else {
                echo "<p>Ocorreu um erro ao atualizar o perfil.</p>";
                echo '<a href="editar_perfil.php?id=' . $id . '" class="btn btn-default">Voltar para a Edição do Perfil</a>';
            }
        } else {
            echo "<p>Operação inválida.</p>";
            echo '<a href="index.php" class="btn btn-default">Voltar para a Página Inicial</a>';
        }
        ?>
    </div>
</body>
</html>
