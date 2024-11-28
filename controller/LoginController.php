<?php

include_once '../../../model/Funcionario.php';
include_once '../../../model/Usuario.php';

class LoginController {
    private $usuarioModel;
    private $funcionarioModel;

    public function __construct($db) {
        $this->usuarioModel = new Usuario($db);
        $this->funcionarioModel = new Funcionario($db);
    }

    // Função para autenticar o usuário
    public function autenticar($tipo) {
        $_SESSION['tipo'] = $tipo;
        #session_start();
        // Verifica se os campos de email e senha foram preenchidos
        if (isset($_POST['email']) && isset($_POST['senha'])) {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
    
            // Verifica o tipo de login (usuario ou funcionario)
            if ($tipo === 'usuario') {
                $_SESSION['nome'] = $this->usuarioModel->getNome($email);
                $usuario = $this->usuarioModel->validarLogin($email, $senha);
                if ($usuario) {
                    // Se o login for bem-sucedido, armazena os dados na sessão
                    $_SESSION['usuario'] = $usuario;
                    return true;
                }
                else{
                    // Se o login falhar, define uma mensagem e redireciona para a página de login correspondente
                    $_SESSION['mensagem'] = 'Email ou senha inválidos!';
                    return false;
                    exit();
                }
            } elseif ($tipo === 'funcionario') {
                $_SESSION['nome'] = $this->funcionarioModel->getNome($email);
                $funcionario = $this->funcionarioModel->validarLogin($email, $senha);
                if ($funcionario) {
                    // Se o login for bem-sucedido, armazena os dados na sessão
                    $_SESSION['funcionario'] = $funcionario;
                    $_SESSION['tipo'] = 'funcionario';
                    return true;
                }
                else{
                    // Se o login falhar, define uma mensagem e redireciona para a página de login correspondente
                    $_SESSION['mensagem'] = 'Email ou senha inválidos!';
                    return false;
                    exit();
                }
            }
    
            
        } else {
            // Se os campos não foram preenchidos, define uma mensagem e redireciona
            $_SESSION['mensagem'] = 'Por favor, preencha todos os campos.';
            header('Location: ../login/login_funcionario.php');
            exit();
        }
    }
    
}
?>
