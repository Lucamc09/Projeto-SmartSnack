<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Funcionário</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style4.css">
    <style>
        .dashboard-container {
            margin-top: 50px;
            text-align: center;
        }

        .btn-custom {
            padding: 15px 25px;
            font-size: 16px;
            background-color: #F50324;
            color: white;
            border: none;
            border-radius: 5px;
            margin: 10px;
        }

        .btn-custom:hover {
            background-color: #D92A19;
        }

        .welcome-msg {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <div class="welcome-msg">
            Bem-vindo ao Dashboard, Funcionário!
        </div>

        <a href="adicionar_oferta.php" class="btn btn-custom">Adicionar Nova Oferta</a>
        
        <a href="editar_oferta.php" class="btn btn-custom">Editar Oferta</a>
        
        <a href="logout.php" class="btn btn-custom">Logout</a>
    </div>
</body>
</html>
