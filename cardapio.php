<!DOCTYPE html>
<html>
<head>
    <title>Lista de Pedidos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Pedidos</h1>
        <?php
            require('conexao.php');
            echo '<br><br><br>';
            
            // Função para listar todos os registros do banco de dados
            function listarRegistros($conexao, $ordenarPorPreco = false) {
                $sql = "SELECT * FROM Produtos";
                if ($ordenarPorPreco) {
                    $sql .= " ORDER BY preco DESC";
                }
                $stmt = $conexao->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // Verifica se a ordenação por preço foi solicitada
            $ordenarPorPreco = isset($_GET['ordenar_preco']) ? true : false;

            // Listar registros
            $registros = listarRegistros($conexao, $ordenarPorPreco);

            // Exibindo os dados em uma tabela
            echo "<table class='table table-bordered'>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Preço</th>
                </tr>";
            foreach ($registros as $registro) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($registro['id']) . "</td>";
                echo "<td>" . htmlspecialchars($registro['produto']) . "</td>";
                echo "<td>" . htmlspecialchars($registro['preco']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
        
        <form action="" method="get">
            <button type="submit" name="ordenar_preco" value="1" class="btn btn-primary">Ordenar por Maior Preço</button>
        </form>
        
        <br><br>
        <a href="index.php" class="btn btn-default">Voltar</a>
        <a href="cadastro_pedido.php" class="btn btn-success">Adicionar Pedido</a>
    </div>
</body>
</html>
