<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar perfil</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Editar perfil</h1>
        <?php
        session_start();
        require('conexao.php');

        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];

            // Função para buscar as informações do usuário
            function buscarUsuario($conexao, $username) {
                $sql = "SELECT * FROM users WHERE username = :username";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            $perfil = buscarUsuario($conexao, $username);
            if ($perfil) {
                ?>
                <form action="alterar_conta.php" method="post">
                    <input  name="id" value="<?php echo htmlspecialchars($perfil['id']); ?>">
                    <div class="form-group">
                        <label for="username">Nome de Usuário:</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($perfil['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($perfil['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" id="password" name="password" class="form-control" value="<?php echo htmlspecialchars($perfil['password']); ?>" required>
                    </div>
                    <input type="submit" value="Salvar" class="btn btn-primary">
                </form>
                <?php
            } else {
                echo "<p>Perfil não encontrado.</p>";
            }
        } else {
            echo "<p>ID do perfil não especificado.</p>";
        }
        ?>
        <br><br>
        <a href="index.php" class="btn btn-default">Voltar</a>
    </div>
</body>
</html>
