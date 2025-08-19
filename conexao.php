<?php
$host = "localhost:3307";
$usuario = "root"; 
$senha = "";       
$banco = "hamburgueria";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}
?>
