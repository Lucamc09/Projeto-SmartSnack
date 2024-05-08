<?php
echo "Inserindo dados abaixo... <br>";
require ('conexao.php');
echo '<br><br>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<br>';
    echo 'Produto: ';
    echo $produto = $_POST["produto"] ;
    echo '<br>';
    echo 'Preço: ';
    echo $preco = $_POST["preco"];
    echo '<br><br><br>';
    echo "<hr>";

    // Função para inserir um novo registro no banco de dados
    function inserirRegistro($conexao, $produto, $preco) {
        $sql = "INSERT INTO Pedidos (produto, preco) 
        VALUES (:produto, :preco)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produto', $produto, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
if (inserirRegistro($conexao, $produto, $preco)) {
    echo '<br><br>';
    echo "Registro inserido com sucesso!<br>" . "<br>" . "<a href='index.php'>voltar</a>";
} else {
    echo 'Erro ao inserir o registro.';
}
?>