<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusão de Registro</title>
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
        .message {
            text-align: center;
            margin-top: 20px;
        }
        a.button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
        }
        a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Exclusão de Registro</h2>

    <?php
    require('conexao.php');
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

    if (isset($id)) {
        if (excluirRegistro($conexao, $id)) {
            echo "<div class='message'>Registro excluído com sucesso!<br><br><a href='index.php' class='button'>HOME</a></div>";
        } else {
            echo "<div class='message'>Erro ao excluir o registro.</div>";
        }
    } else {
        echo "<div class='message'>Não foi recebido um ID válido para exclusão.</div>";
    }
    ?>

</div>

</body>
</html>
