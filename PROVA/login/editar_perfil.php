<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$id = $_SESSION['usuario_id'];

// Atualiza dados se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (!empty($senha)) {
        // Salva a senha em texto puro (NÃO RECOMENDADO)
        $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nome, $email, $senha, $id);
    } else {
        $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nome, $email, $id);
    }

    if ($stmt->execute()) {
        header("Location: perfil.php");
        exit();
    } else {
        $erro = "Erro ao atualizar perfil.";
    }
}

// Busca dados atuais
$sql = "SELECT nome, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$usuario = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Perfil</h2>
    <?php if (isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Nova Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Deixe em branco para não alterar">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="perfil.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>