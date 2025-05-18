<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$id = $_SESSION['usuario_id'];

// Exclui o usuário
$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    session_destroy();
    header("Location: login.html");
    exit();
} else {
    echo "<div class='alert alert-danger'>Erro ao excluir conta.</div>";
}
?>