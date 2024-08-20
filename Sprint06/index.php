<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    header("location: login.php");
    exit();
}

?>
<div class="content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success">
            <h3>
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </h3>
        </div>
    <?php endif ?>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
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
        <?php if (isset($_SESSION['username'])) : ?>
            <div class="titpedido">
                <span class="titulo">Pedidos de <strong><?php echo $_SESSION['username']; ?></strong></span>
            </div>
            <br><br>
        <?php endif ?>
        <a href="cadastro_pedido.php" class="btn btn-primary">Fazer um Pedido</a>
        <a href="cardapio.php" class="btn btn-info">Visualizar Cardápio</a>
        <a href="index.php?logout='1'" style="color: white;" class="btn btn-danger">Logout</a>
        <a href="deleteperfil.php" class="btn btn-danger">Excluir perfil</a>
        <a href="editperfil.php" class="btn btn-primary">Editar perfil</a>
        <a href="feedback.php" class="btn btn-primary">Enviar Feedback</a>
        <a href="ofertas.php" class="btn btn-primary">Ver Ofertas</a>
        <br><br>
        <?php
        require('conexao.php');

        function listarRegistros($conexao, $username) {
            // Modifique a consulta para usar o username diretamente
            
            $sql = "SELECT p.id, pr.produto, p.quantidade, pr.preco 
            FROM Pedidos p
            JOIN Produtos pr ON p.produto_id = pr.id
            WHERE p.user_id = :username";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        

        
       
        $username = $_SESSION['username'];
        $registros = listarRegistros($conexao, $username);
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
