<?php
include_once '../../../model/Funcionario.php';
include_once '../../../model/Usuario.php';

class CadastroController {
    private $usuarioModel;
    private $funcionarioModel;

    public function __construct($db) {
        $this->usuarioModel = new Usuario($db);
        $this->funcionarioModel = new Funcionario($db);
    }

    // Função para cadastrar um novo usuário
    public function cadastrar($tipo) {
        if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $_SESSION['email'] = $email;

            // Verifica o tipo de cadastro (usuario ou funcionario)
            if ($tipo === 'usuario') {
                $resultado = $this->usuarioModel->cadastrar($nome, $email, $senha);
                if ($resultado === true) {
                    $_SESSION['mensagem'] = 'Cadastro realizado com sucesso!';
                    header('Location: ../login/login_cliente.php');
                    exit();
                } else {
                    $_SESSION['mensagem'] = $resultado; // Mensagem de erro
                    header('Location: ../login/login_cliente.php');
                    exit();
                }
            }
        }
        else {
            $_SESSION['mensagem'] = 'Todos os campos são obrigatórios!';
            header('Location: ../view/cadastro_' . $tipo . '.php');
            exit();
        }
    }
}
?>
