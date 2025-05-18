<?php
// Inicia a sessão
session_start();
require_once 'conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta o usuário pelo e-mail
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        // Verifica a senha (se estiver usando hash, use password_verify)
        if ($usuario['senha'] === $senha) { // ou password_verify se usar hash
            $_SESSION['usuario'] = $usuario['email'];
            $_SESSION['usuario_id'] = $usuario['id']; // Salva o ID do usuário
            header("Location: perfil.php");
            exit();
        } else {
            // Senha incorreta
            echo "<script>alert('Senha incorreta!'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        // Usuário não encontrado
        echo "<script>alert('Usuário não encontrado!'); window.location.href='login.html';</script>";
        exit();
    }
} else {
    // Se acessar diretamente, redireciona para o login
    header("Location: login.html");
    exit();
}
?>

<form id="login-form" class="login-form active-form" action="login.php" method="POST">
    <!-- ...campos... -->
</form>