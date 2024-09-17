<?php
require('../conexao.php');

// Inicializa as variáveis de data
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

// Constrói a consulta SQL com o filtro de data
$sql = "SELECT * FROM Feedback WHERE 1=1";

if (!empty($data_inicio) && !empty($data_fim)) {
    $sql .= " AND data_envio BETWEEN :data_inicio AND :data_fim";
    $params = [
        ':data_inicio' => $data_inicio,
        ':data_fim' => $data_fim . ' 23:59:59'
    ];
} elseif (!empty($data_inicio)) {
    $sql .= " AND DATE(data_envio) = :data_inicio";
    $params = [
        ':data_inicio' => $data_inicio
    ];
} else {
    $params = [];
}

$sql .= " ORDER BY data_envio DESC";
$stmt = $conexao->prepare($sql);

if (!empty($params)) {
    $stmt->execute($params);
} else {
    $stmt->execute();
}

$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Recebido</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #F8F8FF;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #F50324;
            width: 100%;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-container label {
            margin-right: 5px;
        }
        .form-container input[type="date"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #F50324;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #d0001c;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1200px;
        }
        .feedback {
            background: white;
            border: 1px solid #B0C4DE;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .feedback h3 {
            color: #F50324;
            margin-bottom: 10px;
        }
        .feedback p {
            color: #333;
            margin: 10px 0;
        }
        .feedback .data {
            font-size: 0.9em;
            color: #666;
            margin-top: 10px;
        }
        .no-feedback {
            grid-column: span 3;
            text-align: center;
            color: #333;
            padding: 20px;
            border: 1px solid #B0C4DE;
            border-radius: 10px;
            background: #FFF;
        }
        .btn-voltar {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background: #F50324;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .btn-voltar:hover {
            background: #d0001c;
        }
        .div1 {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #F8F8FF;
            text-align: center;
            padding: 10px 0;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Feedback Recebidos</h2>

    <!-- Formulário de Pesquisa -->
    <div class="form-container">
        <form method="get" action="">
            <label for="data_inicio">Data Início:</label>
            <input type="date" id="data_inicio" name="data_inicio" value="<?php echo htmlspecialchars($data_inicio); ?>">
            <label for="data_fim">Data Fim:</label>
            <input type="date" id="data_fim" name="data_fim" value="<?php echo htmlspecialchars($data_fim); ?>">
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <div class="grid-container">
        <?php if (count($feedbacks) > 0): ?>
            <?php foreach ($feedbacks as $feedback): ?>
                <div class="feedback">
                    <h3><?php echo htmlspecialchars($feedback['assunto']); ?></h3>
                    <p><strong>Nome: </strong><?php echo htmlspecialchars($feedback['nome']); ?></p>
                    <p><strong>Email: </strong><?php echo htmlspecialchars($feedback['email']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($feedback['mensagem'])); ?></p>
                    <p class="data"><strong>Enviado em: </strong><?php echo date('d/m/Y H:i', strtotime($feedback['data_envio'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-feedback">
                <p>Nenhum feedback disponível no momento.</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="div1">
        <a href="dashboard_funcionario.php" class="btn-voltar">Voltar para o Início</a>
    </div>
</body>
</html>
