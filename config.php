<?php
$host = "localhost:3307";
$user = "root";   // usuário do MySQL
$pass = "";       // senha (no XAMPP geralmente é vazio)
$db   = "burger_house";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
