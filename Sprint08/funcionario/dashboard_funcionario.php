<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Funcionário</title>
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
        .dashboard-container {
            text-align: center;
            margin-top: 50px;
        }
        .btn-custom {
            padding: 15px 25px;
            font-size: 16px;
            background-color: #F50324;
            color: white;
            border: none;
            border-radius: 5px;
            margin: 10px;
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }
        .btn-custom:hover {
            background-color: #d0001c;
        }
        .welcome-msg {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #F50324;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php"><img src="../image/logo.png" alt="Logo"></a>
        <div class="btn-group">
            <a href="dashboard_funcionario.php" class="btn btn-primary">Home</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </header>
    
    <div class="container dashboard-container">
        <div class="welcome-msg">
            Bem-vindo ao Dashboard, Funcionário!
        </div>
        <a href="editar_produto.php" class="btn btn-custom">Produtos</a>
        <a href="editar_oferta.php" class="btn btn-custom">Ofertas</a>
        <a href="ver_feedback.php" class="btn btn-custom">Feedback</a>
    </div>
</body>
</html>
