<?php include "conexao.php"; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Pedido</title>
</head>
<body>
    <h2>Novo Pedido</h2>
    <form method="POST">
        Cliente: <input type="text" name="cliente" required><br><br>

        Produto:
        <select name="produto_id" required>
            <?php
            $produtos = $conexao->query("SELECT * FROM produtos");
            while ($p = $produtos->fetch_assoc()) {
                echo "<option value='".$p['id']."'>".$p['nome']." - R$ ".number_format($p['preco'],2,',','.')."</option>";
            }
            ?>
        </select>
        <br><br>

        Adicionais:<br>
        <?php
        $adics = $conexao->query("SELECT * FROM adicionais");
        while ($a = $adics->fetch_assoc()) {
            echo "<input type='checkbox' name='adicionais[]' value='".$a['nome']." - R$".$a['preco']."'> ".$a['nome']." (R$ ".number_format($a['preco'],2,',','.').")<br>";
        }
        ?>
        <br>

        <button type="submit">Fazer Pedido</button>
    </form>
    <br>
    <a href="index.php">Voltar</a>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = $_POST["cliente"];
    $produto_id = $_POST["produto_id"];
    $adicionais = isset($_POST["adicionais"]) ? implode(", ", $_POST["adicionais"]) : "";

    // pega preço do produto
    $res = $conexao->query("SELECT preco FROM produtos WHERE id=$produto_id");
    $produto = $res->fetch_assoc();
    $total = $produto['preco'];

    // soma preço dos adicionais
    if (!empty($_POST["adicionais"])) {
        foreach ($_POST["adicionais"] as $ad) {
            preg_match('/R\$(\d+(\.\d+)?)/', $ad, $precoMatch);
            if (isset($precoMatch[1])) {
                $total += floatval($precoMatch[1]);
            }
        }
    }

    $sql = "INSERT INTO pedidos (cliente, produto_id, adicionais, total) 
            VALUES ('$cliente', '$produto_id', '$adicionais', '$total')";

    if ($conexao->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Erro: " . $conexao->error;
    }
}
?>
