<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h3 {
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        select {
            width: 100%;
            padding: 6px 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Cadastro de Pedido:</h3>
        <form action="inserir_dados.php" method="post">
            <div class="form-group">
                <label for="produto_id">Produto:</label><br>
                <select id="produto_id" name="produto_id" class="form-control">
                    <?php
                        require('conexao.php');
                        $sql = "SELECT id, produto FROM Produtos";
                        foreach ($conexao->query($sql) as $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['produto'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="number" class="form-control" required name="quantidade" id="quantidade" placeholder="Informe a quantidade">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="reset" class="btn btn-danger">Limpar</button>
            <a href="index.php" class="btn btn-warning">Voltar</a>
            <button type="button" class="btn btn-info" id="btnTempoEspera">Ver Tempo de Espera</button>
        </form>
    </div>

    <script>
        function calcularTempoEspera() {
            var min = 15;
            var max = 45;
            var tempoEspera = Math.floor(Math.random() * (max - min + 1)) + min;
            return tempoEspera;
        }

        document.getElementById('btnTempoEspera').addEventListener('click', function() {
            var tempoEspera = calcularTempoEspera();
            alert('Tempo de Espera estimado: ' + tempoEspera + ' minutos');
        });
    </script>
</body>
</html>
