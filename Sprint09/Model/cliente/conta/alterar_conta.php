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
        require('../../conexao.php');
        session_start(); 

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $senha = !empty($_POST['password']) ? md5($_POST['password']) : null; // Defina a senha se fornecida, caso contrário, defina como null
            $antigoUsername = $_SESSION['username'];  // Armazena o antigo username

            // Função para verificar se o novo username já existe
            function verificarUsernameExistente($conexao, $novo_username, $id_atual) {
                $sql = "SELECT COUNT(*) FROM users WHERE username = :username AND id != :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':username', $novo_username, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id_atual, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchColumn() > 0;
            }

            // Função para atualizar o registro no banco de dados
            function atualizarUsuario($conexao, $id, $username, $email, $senha = null) {
                $sql = "UPDATE users SET username = :username, email = :email";
                
                if ($senha !== null) {
                    $sql .= ", password = :password";
                }
                
                $sql .= " WHERE id = :id";
                
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                
                if ($senha !== null) {
                    $stmt->bindParam(':password', $senha, PDO::PARAM_STR);
                }
                
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
            }

            // Função para atualizar o user_id na tabela Pedidos
            function atualizarCarrinhoUsuario($conexao, $antigoUsername, $novoUsername) {
                $sql = "UPDATE pedidos SET user_id = :novoUsername WHERE user_id = :antigoUsername";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':novoUsername', $novoUsername, PDO::PARAM_STR);
                $stmt->bindParam(':antigoUsername', $antigoUsername, PDO::PARAM_STR);
                return $stmt->execute();
            }

            // Função para atualizar o user_id na tabela PedidosOfertas
            function atualizarOfertasUsuario($conexao, $antigoUsername, $novoUsername) {
                $sql = "UPDATE pedidosOfertas SET user_id = :novoUsername WHERE user_id = :antigoUsername";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':novoUsername', $novoUsername, PDO::PARAM_STR);
                $stmt->bindParam(':antigoUsername', $antigoUsername, PDO::PARAM_STR);
                return $stmt->execute();
            }

            // Verifica se o novo username já está em uso
            if (verificarUsernameExistente($conexao, $username, $id)) {
                echo "<p class='text-danger'>O nome de usuário já está em uso. Por favor, escolha outro.</p>";
                echo '<a href="editperfil.php?id=' . $id . '" class="btn btn-default">Voltar para a Edição do Perfil</a>';
            } else {
                // Atualiza o perfil com as novas informações
                if (atualizarUsuario($conexao, $id, $username, $email, $senha)) {
                    // Atualiza a variável de sessão
                    $_SESSION['username'] = $username;

                    // Atualiza o user_id nas tabelas Pedidos e PedidosOfertas
                    if (atualizarCarrinhoUsuario($conexao, $antigoUsername, $username) && atualizarOfertasUsuario($conexao, $antigoUsername, $username)) {
                        echo "<p class='text-success'>Perfil e pedidos atualizados com sucesso!</p>";
                    } else {
                        echo "<p class='text-warning'>Perfil atualizado, mas não foi possível atualizar os pedidos.</p>";
                    }
                    
                    echo '<a href="../../index.php" class="btn btn-default">Voltar para a Página Inicial</a>';
                } else {
                    echo "<p class='text-danger'>Ocorreu um erro ao atualizar o perfil.</p>";
                    echo '<a href="editperfil.php?id=' . $id . '" class="btn btn-default">Voltar para a Edição do Perfil</a>';
                }
            }
        } else {
            echo "<p class='text-danger'>Operação inválida.</p>";
            echo '<a href="../../index.php" class="btn btn-default">Voltar para a Página Inicial</a>';
        }
        ?>
    </div>
</body>
</html>
