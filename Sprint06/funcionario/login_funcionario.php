<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Funcionário</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style5.css">
</head>
<body class="container">
    <div class="header">
        <h2>Login de Funcionário</h2>
    </div>

    <?php
    session_start();
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo '<div class="error">' . $error . '</div>';
        }
        unset($_SESSION['errors']);
    }
    ?>

    <form method="post" action="processa_login_funcionario.php">
        <div class="input-group">
            <label>ID do Funcionário</label>
            <input type="text" name="id_funcionario" required>
        </div>
        <div class="input-group">
            <label>Senha</label>
            <input type="password" name="senha" required>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="login_funcionario">Login</button>
        </div>
        <p>
            <a href="../login.php">Voltar ao Login</a>
        </p>
    </form>
</body>
</html>
