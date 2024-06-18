<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        body {
            padding-top: 50px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pedidos</h1>
        <a href="cadastro_pedido.php" class="btn btn-primary">Adicionar Novo Pedido</a>
        <a href="cardapio.php" class="btn btn-info">Visualizar Cardápio</a>
        <br><br>
        <?php
            require('conexao.php');

            function listarRegistros($conexao) {
                $sql = "SELECT p.id, pr.produto, p.quantidade, pr.preco 
                        FROM Pedidos p
                        JOIN Produtos pr ON p.produto_id = pr.id";
                $stmt = $conexao->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            $registros = listarRegistros($conexao);
            $valorTotal = 0;

            echo "<table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Subtotal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($registros as $registro) {
                $subtotal = $registro['quantidade'] * $registro['preco'];
                $valorTotal += $subtotal;
                echo "<tr>
                        <td>" . $registro['id'] . "</td>
                        <td>" . $registro['produto'] . "</td>
                        <td>" . $registro['quantidade'] . "</td>
                        <td>" . number_format($registro['preco'], 2, ',', '.') . "</td>
                        <td>" . number_format($subtotal, 2, ',', '.') . "</td>
                        <td>
                            <a href='edit.php?id=" . $registro['id'] . "' class='btn btn-warning'>Editar</a>
                            <a href='deletar_dados.php?id=" . $registro['id'] . "' class='btn btn-danger'>Excluir</a>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
            echo "<h3>Valor Total das Compras: R$ " . number_format($valorTotal, 2, ',', '.') . "</h3>";
        ?>
    </div>
</body>
</html>
