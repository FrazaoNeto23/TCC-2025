<?php
session_start();
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['nome']       = $user['nome'];
            $_SESSION['is_admin']   = $user['is_admin'];

            if ($user['is_admin'] == 1) {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff6a00, #ee0979);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.3);
            width: 350px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-container input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        .login-container button {
            width: 95%;
            padding: 12px;
            background: #ff6a00;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-container button:hover {
            background: #ee0979;
        }
        .login-container p {
            margin-top: 15px;
        }
        .login-container a {
            color: #ff6a00;
            text-decoration: none;
            font-weight: bold;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        .erro {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <?php if (!empty($erro)): ?>
        <p class="erro"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Entrar</button>
    </form>
    <p><a href="cadastro.php">Não tem conta? Cadastre-se</a></p>
</div>

</body>
</html>
