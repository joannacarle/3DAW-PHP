<?php
session_start();
if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit();
}
$nomeUsuario = $_SESSION["usuario"] ?? "Usuário";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Menu Principal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="menu" style="border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 25px;">
        <div>
            <h2>Painel de Controle</h2>
            <p>Olá, <strong><?= htmlspecialchars($nomeUsuario) ?></strong>! Bem-vindo ao sistema.</p>
        </div>
        <a href="logout.php" class="btn-danger">Sair do Sistema</a>
    </div>

    <div class="cards-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <div style="padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center;">
            <h3>Banco de Dados</h3>
            <p style="color: #666; margin: 10px 0;">Visualize e gerencie todas as perguntas cadastradas.</p>
            <a href="index.php" class="btn-secondary" style="width: 100%;">Listar Perguntas</a>
        </div>

        <div style="padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center;">
            <h3>Novas Questões</h3>
            <p style="color: #666; margin: 10px 0;">Adicione perguntas de múltipla escolha ou dissertativas.</p>
            <a href="criarperguntas.php" class="btn" style="width: 100%;">Criar Pergunta</a>
        </div>

    </div>

    <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #999;">
        <p>AV1 - Desenvolvimento de Aplicações Web - FAETERJ-Rio</p>
    </div>
</div>

</body>
</html>
