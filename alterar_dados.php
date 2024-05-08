<?php
echo "Atualizando dados abaixo... <br><br>";
require ('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $produto = $_POST["produto"];
    $preco = $_POST["preco"];
    echo "<hr>";
 
    // Função para Atualizar o registro no banco de dados
    function atualizarRegistro($conexao, $id, $produto, $preco) {
        $sql = "UPDATE Pedidos SET produto = '$produto', preco = '$preco' WHERE id = $id";
        $stmt = $conexao->prepare($sql);
        return $stmt->execute();
    }
}
if (atualizarRegistro($conexao, $id, $produto, $preco)) {
    echo "Registro atualizado com sucesso!<br>" . "<br><br>" . "<a href='index.php'>HOME</a>";
} else {
    echo 'Erro ao inserir o registro.';
}
?>