<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <style>
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
        .form-group input {
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
        <h1>Editar Perfil</h1>
        <?php
        session_start();
        require('../../conexao.php');

        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];

            // Função para buscar as informações do usuário
            function buscarUsuario($conexao, $username) {
                $sql = "SELECT * FROM users WHERE username = :username";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            $perfil = buscarUsuario($conexao, $username);
            if ($perfil) {
                ?>
                <form action="alterar_conta.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($perfil['id']); ?>">
                    <div class="form-group">
                        <label for="username">Nome de Usuário:</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($perfil['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($perfil['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Nova Senha:</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Deixe em branco para manter a senha atual">
                    </div>

                    <input type="submit" value="Salvar" class="btn-primary">
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
        <a href="../../index.php" class="btn-default">Voltar</a>
        <a href="deleteperfil.php" id="excluir" class="btn-primary">Excluir perfil</a>
    </div>
</body>
</html>
