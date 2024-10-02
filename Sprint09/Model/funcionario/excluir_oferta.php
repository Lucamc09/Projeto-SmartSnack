<?php
session_start();
require('../conexao.php');

// Verifica se o usuário está logado como funcionário
if (!isset($_SESSION['id_funcionario'])) {
    header('Location: login_funcionario.php');
    exit();
}

// Verifica se o ID da oferta foi fornecido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Exclui a oferta do banco de dados
    try {
        $sql = "DELETE FROM Ofertas WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $_SESSION['success'] = "Oferta excluída com sucesso!";
        header('Location: dashboard_funcionario.php');
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    header('Location: dashboard_funcionario.php');
    exit();
}
?>
