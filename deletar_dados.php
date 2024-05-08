<?php
    require ('conexao.php');
    echo '<br><br>';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    // Função para deletar o registro no banco de dados
    function excluirRegistro($conexao, $id) {
        $sql = "DELETE FROM Pedidos WHERE id = $id";
        $stmt = $conexao->prepare($sql);
        return $stmt->execute();
    }
}
if (excluirRegistro($conexao, $id)) {
    echo "Registro excluído com sucesso!<br>" ."<br><br>" . "<a href='index.php'>HOME</a>";
} else {
    echo 'Erro ao excluir o registro.';
}
?>