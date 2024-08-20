<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .message {
            width: 31%;
            margin: 0px auto 0px auto; 
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        textarea {
            resize: none;
            width: 96%;
        }
        .input-group {
            margin: 10px 10px 10px 0px;
            text-align: center; 
        }


    </style>
</head>
<body>

<?php
require('conexao.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $assunto = $_POST["assunto"];
    $mensagem = $_POST["mensagem"];

    $sql = "INSERT INTO Feedback (nome, email, assunto, mensagem) VALUES (:nome, :email, :assunto, :mensagem)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':assunto', $assunto);
    $stmt->bindParam(':mensagem', $mensagem);

    if ($stmt->execute()) {
        $message = "<div class='message success'><p>Obrigado pelo seu feedback! Entraremos em contato em breve.</p></div>";
    } else {
        $message = "<div class='message error'><p>Houve um erro ao enviar seu feedback. Por favor, tente novamente.</p></div>";
    }
}
?>

    <div class="header">
        <h2>Entre em Contato</h2>
    </div>

    <?php 
    if (!empty($message)) {
        echo $message;
    }
    ?>

    <form action="" method="POST">
        <div class="input-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="assunto">Assunto:</label>
            <input type="text" id="assunto" name="assunto" required>
        </div>
        <div class="input-group">
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" rows="4" cols="50" required></textarea>
        </div>
        <div class="input-group">
            <input type="submit" value="Enviar" class="btn">
        </div>
        <div class="input-group">
            <a href="index.php" class="btn btn-default">Voltar</a>
        </div>
    </form>
</body>
</html>
