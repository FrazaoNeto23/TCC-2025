<?php
$host = "localhost:3307";   // servidor
$user = "root";        // usuário do banco
$pass = "";            // senha do banco
$db   = "sistema_login";    // nome do banco de dados

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
