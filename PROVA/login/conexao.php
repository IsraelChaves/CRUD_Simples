<?php
$servername = "localhost";
$username = "root";
$password = ""; // padrão do XAMPP é senha vazia
$dbname = "prova"; // troque pelo nome do seu banco

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>