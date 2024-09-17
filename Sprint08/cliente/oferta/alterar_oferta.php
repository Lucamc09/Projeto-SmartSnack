<?php
require('../../conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['oferta']) && isset($_POST['quantidade'])) {
        $id = $_POST['id'];
        $oferta_id = $_POST['oferta'];
        $quantidade = $_POST['quantidade'];

        try {
            // Prepare and execute the update statement
            $sql = "UPDATE PedidosOfertas SET oferta_id = :oferta_id, quantidade = :quantidade WHERE id = :id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':oferta_id', $oferta_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect to a success page or show a success message
            header("Location: ../../index.php?success=Pedido atualizado com sucesso"); // Redireciona para uma página de sucesso
            exit();

        } catch (PDOException $e) {
            // Handle errors
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "Todos os campos são obrigatórios.";
    }
} else {
    echo "Método inválido.";
}
?>
