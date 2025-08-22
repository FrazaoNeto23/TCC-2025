<?php
$servidor = "localhost: 3307";
$usuario = "root";  // altere se necessário
$senha = "";        // sua senha do MySQL
$banco = "sistema_login";

$con = new mysqli($servidor, $usuario, $senha, $banco);

if ($con->connect_error) {
    die("Erro na conexão: " . $con->connect_error);
}
?>
