<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "Você deve fazer login primeiro.";
    header('Location: cliente/login.php');
    exit();
}

// Processa o logout
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    header("location: cliente/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #F8F8FF;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #F50324;
            padding: 10px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header img {
            width: 50px;
            height: auto;
        }
        header .btn-group {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-primary {
            background-color: #F50324;
        }
        .btn-primary:hover {
            background-color: #d0001c;
        }
        .btn-info {
            background-color: #007bff;
        }
        .btn-info:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #F50324;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
            color: #F50324;
        }
        .table td img {
            width: 80%;
            border-radius: 5px;
        }
        .success, .error {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .titulo {
            font-size: 24px;
            color: #F50324;
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php"><img src="image/logo.png" alt="Logo"></a>
        <div class="btn-group">
            <?php if (isset($_SESSION['username'])) : ?>
                <form action="cliente/conta/editperfil.php" method="get">
                    <input class="btn btn-primary" type="submit" value="Edit Profile">
                </form>
                <form action="index.php" method="get">
                    <input class="btn btn-danger" type="submit" name="logout" value="Logout">
                </form>
            <?php else : ?>
                <form action="cliente/login.php" method="get">
                    <input class="btn btn-primary" type="submit" value="Login">
                </form>
                <form action="cliente/register.php" method="get">
                    <input class="btn btn-primary" type="submit" value="Register">
                </form>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">
        <!-- Mensagem de notificação -->
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

        <div class="titpedido">
            <span class="titulo">Pedidos de <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
        </div>
        <a href="cliente/pedido/cadastro_pedido.php" class="btn btn-primary">Fazer um Pedido</a>
        <a href="cliente/cardapio.php" class="btn btn-info">Visualizar Cardápio</a>
        <a href="cliente/feedback.php" class="btn btn-primary">Enviar Feedback</a>
        <a href="cliente/oferta/ofertas.php" class="btn btn-primary">Ver Ofertas</a>

        <br><br>

        <?php
        require('conexao.php');

        function listarRegistros($conexao, $username) {
            $sql = "SELECT p.id, pr.produto, p.quantidade, pr.preco 
            FROM Pedidos p
            JOIN Produtos pr ON p.produto_id = pr.id
            WHERE p.user_id = :username";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function listarOfertas($conexao, $username){
            $sql = "SELECT po.id, o.titulo, po.quantidade, o.preco 
            FROM PedidosOfertas po
            JOIN Ofertas o ON po.Oferta_id = o.id
            WHERE po.user_id = :username";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $username = $_SESSION['username'];
        $registros = listarRegistros($conexao, $username);
        $valorTotal = 0;

        echo "<span class='titulo'>Pedidos</span>";
        echo "<table class='table'>";
        echo "<thead>
                <tr>
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
                    <td>" . htmlspecialchars($registro['produto']) . "</td>
                    <td>" . htmlspecialchars($registro['quantidade']) . "</td>
                    <td>R$ " . number_format($registro['preco'], 2, ',', '.') . "</td>
                    <td>R$ " . number_format($subtotal, 2, ',', '.') . "</td>
                    <td>
                        <a href='cliente/pedido/edit.php?id=" . htmlspecialchars($registro['id']) . "' class='btn btn-primary'>Editar</a>
                        <a href='cliente/pedido/deletar_dados.php?id=" . htmlspecialchars($registro['id']) . "' class='btn btn-danger'>Excluir</a>
                    </td>
                </tr>";
        }
        echo "</tbody></table>";

        $registrosOfertas = listarOfertas($conexao, $username);
        echo "<span class='titulo'>Ofertas</span>";
        echo "<table class='table'>";
        echo "<thead>
                <tr>
                    <th>Oferta</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>
              </thead>
              <tbody>";
        foreach ($registrosOfertas as $registro) {
            $subtotal = $registro['quantidade'] * $registro['preco'];
            $valorTotal += $subtotal;
            echo "<tr>
                    <td>" . htmlspecialchars($registro['titulo']) . "</td>
                    <td>" . htmlspecialchars($registro['quantidade']) . "</td>
                    <td>R$ " . number_format($registro['preco'], 2, ',', '.') . "</td>
                    <td>R$ " . number_format($subtotal, 2, ',', '.') . "</td>
                    <td>
                        <a href='cliente/oferta/editOfertas.php?id=" . htmlspecialchars($registro['id']) . "' class='btn btn-primary'>Editar</a>
                        <a href='cliente/oferta/deletar_ofertas.php?id=" . htmlspecialchars($registro['id']) . "' class='btn btn-danger'>Excluir</a>
                    </td>
                </tr>";
        }
        echo "</tbody></table>";

        echo "<h3>Total das Compras: R$ " . number_format($valorTotal, 2, ',', '.') . "</h3>";
        ?>
    </div>
</body>
</html>
