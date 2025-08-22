<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // 🔐 Validação no servidor
    if (strlen($senha) < 6 || 
        !preg_match("/[A-Za-z]/", $senha) || 
        !preg_match("/[0-9]/", $senha)) {
        $erro = "A senha deve ter pelo menos 6 caracteres, incluindo letras e números.";
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome','$email','$senhaHash')";
        
        if ($con->query($sql) === TRUE) {
            $sucesso = "Cadastro realizado com sucesso! <a href='index.php'>Fazer login</a>";
        } else {
            $erro = "Erro: " . $con->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/L-C.css">
    <script>
        function validarSenha() {
            const senha = document.getElementById("senha").value;
            const erro = document.getElementById("erroSenha");

            // Expressão: mínimo 6 caracteres, pelo menos 1 letra e 1 número
            const regex = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;

            if (!regex.test(senha)) {
                erro.textContent = "A senha deve ter pelo menos 6 caracteres, incluindo letras e números.";
                return false;
            } else {
                erro.textContent = "";
                return true;
            }
        }
    </script>
</head>
<body>
<div class="container">
    <form method="POST" onsubmit="return validarSenha()">
        <h2>Cadastro</h2>
        <?php 
        if (!empty($sucesso)) echo "<p class='sucesso'>$sucesso</p>"; 
        if (!empty($erro)) echo "<p class='erro'>$erro</p>"; 
        ?>
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" id="senha" name="senha" placeholder="Senha" required onkeyup="validarSenha()">
        <p id="erroSenha" class="erro"></p>
        <button type="submit">Cadastrar</button>
    </form>
    <a href="index.php">Já tem conta? Faça login</a>
</div>
</body>
</html>
