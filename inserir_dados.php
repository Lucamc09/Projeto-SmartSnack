<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserção de Dados</title>
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
            box-shadow: 0 0 10
            px rgba(0, 0, 0, 0.1);
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
    <h2>Inserindo Dados</h2>

    <?php
    echo "Inserindo dados abaixo... <br>";
    require('conexao.php');
    echo '<br><br>';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo '<br>';
        echo 'Produto ID: ';
        echo $produto_id = $_POST["produto_id"];
        echo '<br>';
        echo 'Quantidade: ';
        echo $quantidade = $_POST["quantidade"];
        echo '<br><br><br>';
        echo "<hr>";

        // Função para inserir um novo registro no banco de dados
        function inserirRegistro($conexao, $produto_id, $quantidade)
        {
            $sql = "INSERT INTO Pedidos (produto_id, quantidade) 
                    VALUES (:produto_id, :quantidade)";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }

    ?>

    <div class="message">
        <?php
        if (isset($produto_id) && isset($quantidade)) {
            if (inserirRegistro($conexao, $produto_id, $quantidade)) {
                echo "Registro inserido com sucesso!<br><br><a href='index.php'>Voltar</a>";
            } else {
                echo 'Erro ao inserir o registro.';
            }
        } else {
            echo 'Não foram recebidos dados válidos para inserção.';
        }
        ?>
    </div>

</div>

</body>
</html>
