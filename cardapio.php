<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger House</title>
    <link rel="stylesheet" href="css/cardapioss.css">
</head>
<body>
    <header>
        <h1>🍔 Burger House</h1>
        <nav>
            <a href="home.php">Home</a>
            <a href="cardapio.php" class="ativo">Cardápio</a>
            <a href="#">Contato</a>
            <div id="carrinho-icon">🛒 <span id="contador">0</span></div>
        </nav>
    </header>

    <main>
        <h2>Nosso Cardápio</h2>
        <div class="produtos">
            <?php
            $sql = "SELECT * FROM produtos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Corrigindo o caminho das imagens
                    echo "
                    <div class='produto'>
                        <img src='img/{$row['imagem']}' alt='{$row['nome']}'>
                        <h3>{$row['nome']}</h3>
                        <p>{$row['descricao']}</p><br>
                        <p>R$ " . number_format($row['preco'], 2, ',', '.') . "</p>
                        <button onclick=\"adicionarCarrinho('{$row['nome']}', {$row['preco']}, 'img/{$row['imagem']}')\">Adicionar</button>
                    </div>";
                }
            } else {
                echo "<p>Nenhum produto cadastrado ainda.</p>";
            }
            ?>
        </div>
    </main>

    <aside id="carrinho">
        <button id="fechar-carrinho">✖ Fechar</button>
        <h2>Carrinho</h2>
        <ul id="lista-carrinho"></ul>
        <p id="total">Total: R$ 0,00</p>
        <button id="finalizar">Finalizar Compra</button>
    </aside>

    <footer>
        <p>© 2025 Burger House - Feito com ❤️ e muito queijo</p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
