<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
        body {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-family: Arial, sans-serif;
        }

        .profile-card {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(44, 62, 80, 0.1);
            border-left: 5px solid #f39c12;
        }

        .profile-card h2 {
            color: #2c3e50;
        }

        .btn-primary-custom {
            background-color: #f39c12;
            border: none;
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #e67e22;
        }

        .btn-outline-danger {
            border-color: #2c3e50;
            color: #2c3e50;
        }

        .btn-outline-danger:hover {
            background-color: #2c3e50;
            color: white;
        }

        .divider {
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    if ($res->num_rows > 0) {
        $usuario = $res->fetch_assoc();
        ?>
        <div class="profile-card">
            <h2 class="mb-4 text-center">Meu Perfil</h2>
            <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
            <div class="divider"></div>
            <div class="d-flex justify-content-between mt-3">
                <a href="editar_perfil.php" class="btn btn-primary-custom">Editar Perfil</a>
                <a href="excluir_perfil.php" class="btn btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir sua conta?');">Excluir Conta</a>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='alert alert-danger text-center mt-5'>Usuário não encontrado.</div>";
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>
