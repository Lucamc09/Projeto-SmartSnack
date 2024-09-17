<?php
require('../conexao.php');

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
        echo "<div class='success'><p>Obrigado pelo seu feedback! Entraremos em contato em breve.</p></div>";
    } else {
        echo "<div class='error'><p>Houve um erro ao enviar seu feedback. Por favor, tente novamente.</p></div>";
    }
}
?>
