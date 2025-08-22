<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .login-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .login-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .login-form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #e1e5e9;
        }

        .login-footer a {
            color: #4facfe;
            text-decoration: none;
            font-size: 14px;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background-color: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background-color: #efe;
            color: #363;
            border: 1px solid #cfc;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            font-size: 32px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo-container">
                <div class="logo">S</div>
            </div>
            <h1>Bem-vindo</h1>
            <p>Faça login para acessar sua conta</p>
        </div>

        <div class="login-form">
            <?php
            session_start();
            
            // Configurações do banco de dados
            $servername = "localhost:3307";
            $username = "root"; // Altere conforme seu servidor
            $password = ""; // Altere conforme seu servidor
            $dbname = "sistema_login"; // Nome do banco de dados

            // Conexão com o banco de dados
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar conexão
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Criar tabela de usuários se não existir
            $sql = "CREATE TABLE IF NOT EXISTS usuarios (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(50) NOT NULL UNIQUE,
                senha VARCHAR(255) NOT NULL,
                nome VARCHAR(50) NOT NULL,
                data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

            if ($conn->query($sql) === FALSE) {
                echo "<div class='alert alert-error'>Erro ao criar tabela: " . $conn->error . "</div>";
            }

            // Processar formulário de login
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = trim($_POST['email']);
                $senha = $_POST['senha'];

                // Validar campos
                if (empty($email) || empty($senha)) {
                    echo "<div class='alert alert-error'>Por favor, preencha todos os campos.</div>";
                } else {
                    // Buscar usuário no banco de dados
                    $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                        $usuario = $result->fetch_assoc();
                        
                        // Verificar senha (usando password_verify para senhas hashadas)
                        if (password_verify($senha, $usuario['senha'])) {
                            // Login bem-sucedido
                            $_SESSION['usuario_id'] = $usuario['id'];
                            $_SESSION['usuario_nome'] = $usuario['nome'];
                            $_SESSION['usuario_email'] = $email;
                            
                            echo "<div class='alert alert-success'>Login realizado com sucesso! Redirecionando...</div>";
                            echo "<script>
                                setTimeout(function() {
                                    window.location.href = 'dashboard.php';
                                }, 2000);
                            </script>";
                        } else {
                            echo "<div class='alert alert-error'>Senha incorreta.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-error'>Usuário não encontrado.</div>";
                    }
                    $stmt->close();
                }
            }

            // Fechar conexão
            $conn->close();
            ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="seu@email.com" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Sua senha" required>
                </div>

                <button type="submit" class="btn-login">Entrar</button>
            </form>
        </div>

        <div class="login-footer">
            <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
            <p><a href="recuperar_senha.php">Esqueci minha senha</a></p>
        </div>
    </div>

    <script>
        // Validação básica do lado do cliente
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;

            if (!email || !senha) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos.');
                return false;
            }

            // Validação simples de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Por favor, insira um email válido.');
                return false;
            }
        });

        // Efeitos visuais nos inputs
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>

