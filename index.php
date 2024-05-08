<!DOCTYPE html>
<html>
<head>
    <title>Lista de Pedidos</title>
</head>
<body>
    <h1>Pedidos</h1>
    <a href="cadastro_pedido.php">Adicionar Novo Pedido</a><br><br>
    <?php
        require ('conexao.php');
        echo '<br><br><br>';
        // Função para listar todos os registros do banco de dados
        function listarRegistros($conexao) {
        $sql = "SELECT * FROM Pedidos";
        $stmt = $conexao->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // Listar registros
        $registros = listarRegistros($conexao);
            // Exibindo os dados em uma tabela
            echo "<table border='1'>
                <tr>
                    <th>id</th>
                    <th>produto</th>
                    <th>preco</th>
                </tr>";
            foreach ($registros as $registro) {
                echo "<tr>";
                echo "<td>" . $registro['id'] . "</td>";
                echo "<td>" . $registro['produto'] . "</td>";
                echo "<td>" . $registro['preco'] . "</td>";
                echo "<td>
                    <a href='edit.php?id=" . $registro['id'] . "'>Editar</a>
                    <a href='deletar_dados.php?id=" . $registro['id'] . "'>Excluir</a>
                </td>";
                }
                echo "</tr>";
            echo "</table>";
    ?>
</body>
</html>