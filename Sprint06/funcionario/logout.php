<?php
// Inicia a sessão
session_start();

// Remove todas as variáveis de sessão
$_SESSION = array();

// Se a sessão foi iniciada com cookies, limpa também os cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

// Redireciona para a página de login
header("Location: login_funcionario.php"); // Ou "login_funcionario.php" se for para login de funcionários
exit();
?>
