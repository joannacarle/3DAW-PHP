<?php
session_start();
if (!isset($_SESSION["logado"])) header("Location: login.php");
$linhas = file_exists("perguntas.txt") ? file("perguntas.txt", FILE_IGNORE_NEW_LINES) : [];
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
           <?php foreach ($linhas as $linha): 
           $dados = explode("|", $linha);
           
           if (count($dados) < 3) continue;
           $id = $dados[0];
           $tipo = $dados[1];
           $pergunta = $dados[2];
           ?>

        <tr>
            <td><?= htmlspecialchars($id) ?></td>
            <td><?= htmlspecialchars($pergunta) ?></td>
            <td><?= htmlspecialchars($tipo) ?></td>
            <td class="acoes">
                <a href="editarperguntas.php?id=<?= $id ?>" class="btn">Editar</a>
                <a href="excluirperguntas.php?id=<?= $id ?>" class="btn-danger">Excluir</a>
            </td>
        </tr>
        
        <?php endforeach; ?>
       </table>
</div>
</body>
</html>
