<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Criptografa a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha, is_admin) VALUES (?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senhaHash);

    if ($stmt->execute()) {
        $mensagem = "Usuário cadastrado com sucesso! <a href='login.php'>Fazer login</a>";
    } else {
        $erro = "Erro: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .cadastro-box {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 320px;
            text-align: center;
        }
        .cadastro-box h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .cadastro-box input {
            width: 90%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }
        .cadastro-box button {
            width: 95%;
            padding: 12px;
            margin-top: 10px;
            background: #4CAF50;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }
        .cadastro-box button:hover {
            background: #45a049;
        }
        .cadastro-box p {
            margin-top: 15px;
            font-size: 14px;
        }
        .cadastro-box a {
            color: #4CAF50;
            text-decoration: none;
        }
        .mensagem {
            color: green;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .erro {
            color: red;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="cadastro-box">
    <h2>Cadastro</h2>

    <?php if (!empty($mensagem)) echo "<p class='mensagem'>$mensagem</p>"; ?>
    <?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>

    <form method="post" action="cadastro.php">
        <input type="text" name="nome" placeholder="Nome" required><br>
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <p><a href="index.php">Já tem conta? Fazer login</a></p>
</div>

</body>
</html>
