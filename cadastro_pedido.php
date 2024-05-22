<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Cantina</title>
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
                <label for="Produto">Produto:</label><br>
                <select id="Produto" name="produto" class="form-control">
                    <option value="Porção de Coxinha">Porção de Coxinha</option>
                    <option value="Pão de Queijo">Pão de Queijo</option>
                    <option value="Pão de Queijo Recheado">Pão de Queijo Recheado</option>
                    <option value="Hamburguer">Hamburguer</option>
                    <option value="Cachorro Quente">Cachorro Quente</option>
                    <option value="Pirulito">Pirulito</option>
                    <option value="Chocolate Trento">Chocolate Trento</option>
                    <option value="Ouro Branco">Ouro Branco</option>
                    <option value="Halls">Halls</option>
                    <option value="Pipoca Doce">Pipoca Doce</option>
                    <option value="Mentos">Mentos</option>
                    <option value="Batata Frita">Batata Frita</option>
                    <option value="Prato Feito">Prato Feito</option>
                    <option value="Macarrão">Macarrão</option>
                    <option value="Suco Natural">Suco Natural</option>
                    <option value="Refrigerante">Refrigerante</option>
                    <option value="Água">Água</option>
                </select>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="text" class="form-control" required name="quantidade" id="quantidade" placeholder="Informe a quantidade">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="reset" class="btn btn-danger">Limpar</button>
            <a href="index.php" class="btn btn-warning">Voltar</a>

        </form>
    </div>
</body>
</html>
