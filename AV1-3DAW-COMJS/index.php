<?php
session_start();
if (!isset($_SESSION["logado"])) { 
    header("Location: login.php");
    exit();
}

$jsonFile = "perguntas.json";
$perguntas = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
if (!is_array($perguntas)) $perguntas = [];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Listar Perguntas</title>
</head>
<body>
    <div class="container">
        <h2>Banco de Perguntas</h2>
        <div class="menu">
            <a href="criarperguntas.php" class="btn">Nova Pergunta</a>
            <a href="menu.php" class="btn-secondary">Voltar ao Menu</a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Pergunta</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
           <?php foreach ($perguntas as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['id']) ?></td>
                <td><?= htmlspecialchars($p['pergunta']) ?></td>
                <td><?= htmlspecialchars($p['tipo'] === 'multipla' ? 'Múltipla Escolha' : 'Texto') ?></td>
                <td class="acoes">
                    <a href="editarperguntas.php?id=<?= $p['id'] ?>" class="btn">Editar</a>
                    <a href="excluirperguntas.php?id=<?= $p['id'] ?>"
                        class="btn-danger"
                        onclick="return confirmarExclusao('<?= htmlspecialchars($p['pergunta'], ENT_QUOTES) ?>')">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
function confirmarExclusao(pergunta){

    return confirm(
        "Deseja realmente excluir a pergunta:\n\n" +
        pergunta +
        "\n\nEsta ação não poderá ser desfeita."
    );

}
</script>
    
</body>
</html>
