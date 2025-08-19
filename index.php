<?php include "conexao.php"; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedidos - Hamburgueria</title>
</head>
<body>
    <h2>Pedidos Realizados</h2>
    <a href="cadastrar_pedido.php">Novo Pedido</a> | 
    <a href="cadastrar_produto.php">Cadastrar Produto</a>
    <br><br>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Adicionais</th>
            <th>Total</th>
            <th>Ações</th>
        </tr>
        <?php
        $sql = "SELECT p.id, p.cliente, pr.nome as produto, p.adicionais, p.total 
                FROM pedidos p 
                JOIN produtos pr ON p.produto_id = pr.id";
        $result = $conexao->query($sql);

        if ($result->num_rows > 0) {
            while ($linha = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$linha['id']."</td>";
                echo "<td>".$linha['cliente']."</td>";
                echo "<td>".$linha['produto']."</td>";
                echo "<td>".$linha['adicionais']."</td>";
                echo "<td>R$ ".number_format($linha['total'],2,',','.')."</td>";
                echo "<td>
                        <a href='editar_pedido.php?id=".$linha['id']."'>Editar</a> | 
                        <a href='excluir_pedido.php?id=".$linha['id']."'>Excluir</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhum pedido encontrado</td></tr>";
        }
        ?>
    </table>
</body>
</html>
