<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Verifica se as senhas coincidem
    if ($senha !== $confirmar_senha) {
        echo "<script>alert('As senhas não coincidem!'); window.location.href='login.html';</script>";
        exit();
    }

    // Verifica se o e-mail já está cadastrado
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>alert('E-mail já cadastrado!'); window.location.href='login.html';</script>";
        exit();
    }

    // Insere o novo usuário
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar!'); window.location.href='login.html';</script>";
    }
} else {
    header("Location: login.html");
    exit();
}
?>