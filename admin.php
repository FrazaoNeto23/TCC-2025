<?php
session_start();
include "config.php";

// Protege contra acesso de não-admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}

// Executa ações (promover/remover/excluir)
if (isset($_GET['acao']) && isset($_GET['id'])) {
    $id   = intval($_GET['id']);
    $acao = $_GET['acao'];

    if ($acao == 'promover') {
        $sql = "UPDATE usuarios SET is_admin = 1 WHERE id = ?";
    } elseif ($acao == 'remover') {
        $sql = "UPDATE usuarios SET is_admin = 0 WHERE id = ?";
    } elseif ($acao == 'excluir') {
        $sql = "DELETE FROM usuarios WHERE id = ?";
    }

    if (isset($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: admin.php");
        exit;
    }
}

// Pega todos os usuários
$result = $conn->query("SELECT id, nome, email, is_admin FROM usuarios ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #f4f4f4; }
        a { padding: 5px 10px; margin: 2px; text-decoration: none; border-radius: 5px; }
        .promover { background: green; color: #fff; }
        .remover { background: orange; color: #fff; }
        .excluir { background: red; color: #fff; }
    </style>
</head>
<body>

<h1>Bem-vindo, <?php echo $_SESSION['nome']; ?> (Admin)</h1>
<p><a href="logout.php">Sair</a></p>

<h2>Lista de Usuários</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Tipo</th>
        <th>Ações</th>
    </tr>
    <?php while($user = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['nome']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['is_admin'] ? 'Administrador' : 'Usuário'; ?></td>
            <td>
                <?php if ($user['is_admin'] == 0): ?>
                    <a class="promover" href="admin.php?acao=promover&id=<?php echo $user['id']; ?>">Promover</a>
                <?php else: ?>
                    <a class="remover" href="admin.php?acao=remover&id=<?php echo $user['id']; ?>">Remover Admin</a>
                <?php endif; ?>
                <a class="excluir" href="admin.php?acao=excluir&id=<?php echo $user['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
