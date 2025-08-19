<?php include "conexao.php"; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
</head>
<body>
    <h2>Novo Produto</h2>
    <form method="POST">
        Nome: <input type="text" name="nome" required><br><br>
        Preço: <input type="number" step="0.01" name="preco" required><br><br>
        <button type="submit">Salvar</button>
    </form>
    <br>
    <a href="index.php">Voltar</a>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];

    $sql = "INSERT INTO produtos (nome, preco) VALUES ('$nome', '$preco')";
    if ($conexao->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Erro: " . $conexao->error;
    }
}
?>
