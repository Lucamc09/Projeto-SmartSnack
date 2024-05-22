<?php
require('conexao.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    function listarRegistros($conexao, $id) {
        $sql = "SELECT * FROM Pedidos WHERE id = $id";
        $stmt = $conexao->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $registros = listarRegistros($conexao, $id);
    foreach ($registros as $registro) {
        if ($registro['id'] == $id) {
            $aux = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Editar Pedido</h1>
        <?php if (isset($aux)) : ?>
            <form action="alterar_dados.php" method="post">
                <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
                <div class="form-group">
                    <label for="Produto">Produto:</label><br>
                    <select id="Produto" name="produto" class="form-control border border-dark rounded-0 col col-4">
                        <option value="Porção de Coxinha" <?php echo ($registro['produto'] == 'Porção de Coxinha') ? 'selected' : ''; ?>>Porção de Coxinha</option>
                        <option value="Pão de Queijo" <?php echo ($registro['produto'] == 'Pão de Queijo') ? 'selected' : ''; ?>>Pão de Queijo</option>
                        <option value="Pão de Queijo Recheado" <?php $valor = ($registro['produto'] == 'Pão de Queijo Recheado')?'selected': ''; echo $valor; ?>>Pão de Queijo Recheado</option>
            <option value="Hamburguer" <?php $valor = ($registro['produto'] == 'Hamburguer')?'selected': ''; echo $valor; ?>>Hamburguer</option>
            <option value="Cachorro Quente" <?php $valor = ($registro['produto'] == 'Cachorro Quente')?'selected': ''; echo $valor; ?>>Cachorro Quente</option>

            <option value="Pirulito" <?php $valor = ($registro['produto'] == 'Pirulito')?'selected': ''; echo $valor; ?>>Pirulito</option>
            <option value="Chocolate Trento" <?php $valor = ($registro['produto'] == 'Chocolate Trento')?'selected': ''; echo $valor; ?>>Chocolate Trento</option>
            <option value="Ouro Branco" <?php $valor = ($registro['produto'] == 'Ouro Branco')?'selected': ''; echo $valor; ?>>Ouro Branco</option>
            <option value="Halls" <?php $valor = ($registro['produto'] == 'Halls')?'selected': ''; echo $valor; ?>>Halls</option>
            <option value="Pipoca Doce" <?php $valor = ($registro['produto'] == 'Pipoca Doce')?'selected': ''; echo $valor; ?>>Pipoca Doce</option>
            <option value="Mentos" <?php $valor = ($registro['produto'] == 'Mentos')?'selected': ''; echo $valor; ?>>Mentos</option>

            <option value="Batata Frita" <?php $valor = ($registro['produto'] == 'Batata Frita')?'selected': ''; echo $valor; ?>>Batata Frita</option>
            <option value="Prato Feito" <?php $valor = ($registro['produto'] == 'Prato Feito')?'selected': ''; echo $valor; ?>>Prato Feito</option>
            <option value="Macarrão" <?php $valor = ($registro['produto'] == 'Macarrão')?'selected': ''; echo $valor; ?>>Macarrão</option>

            <option value="Suco Natural" <?php $valor = ($registro['produto'] == 'Suco Natural')?'selected': ''; echo $valor; ?>>Suco Natural</option>
            <option value="Refrigerante" <?php $valor = ($registro['produto'] == 'Refrigerante')?'selected': ''; echo $valor; ?>>Refrigerante</option>
            <option value="Água" <?php $valor = ($registro['produto'] == 'Água')?'selected': ''; echo $valor; ?>>Água</option>
                        <!-- Adicione as outras opções aqui -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantidade">Quantidade:</label><br>
                    <input type="text" id="quantidade" name="quantidade" value="<?php echo $registro['quantidade']; ?>" required>
                </div>
                <input type="submit" value="Salvar" class="btn btn-primary">
            </form>
        <?php else : ?>
            <p>Usuário não encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
