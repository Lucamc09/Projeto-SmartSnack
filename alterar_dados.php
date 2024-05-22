<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Atualizando Dados</h2>

    <?php
    echo "Atualizando dados abaixo... <br><br>";
    require ('conexao.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $produto = $_POST["produto"];
        $quantidade = $_POST["quantidade"];
        echo "<hr>";

        // Função para Atualizar o registro no banco de dados
        function atualizarRegistro($conexao, $id, $produto, $quantidade) {
            $sql = "UPDATE Pedidos SET produto = '$produto', quantidade = '$quantidade' WHERE id = $id";
            $stmt = $conexao->prepare($sql);
            return $stmt->execute();
        }
    }
    ?>

    <div class="message">
        <?php
        if (isset($id) && isset($produto) && isset($quantidade)) {
            if (atualizarRegistro($conexao, $id, $produto, $quantidade)) {
                echo "Registro atualizado com sucesso!<br><br><a href='index.php'>HOME</a>";
            } else {
                echo 'Erro ao atualizar o registro.';
            }
        } else {
            echo 'Não foram recebidos dados válidos para atualização.';
        }
        ?>
    </div>

</div>

</body>
</html>
