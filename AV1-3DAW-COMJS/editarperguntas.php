<?php
session_start();
if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit();
}

$jsonFile = "perguntas.json";
$id_busca = isset($_GET["id"]) ? (int)$_GET["id"] : null;
$perguntas = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

$indice_encontrado = -1;
$dados_pergunta = null;

foreach ($perguntas as $i => $p) {
    if ($p['id'] === $id_busca) {
        $indice_encontrado = $i;
        $dados_pergunta = $p;
        break;
    }
}

if (!$dados_pergunta) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST["tipo"];
    $pergunta = $_POST["pergunta"];
    
    if ($tipo == "multipla") {
        $respostas = [$_POST["r1"], $_POST["r2"], $_POST["r3"]];
        $correta = trim($_POST["correta"]);
    } else {
        $respostas = [];
        $correta = trim($_POST["texto"]);
    }

    $perguntas[$indice_encontrado] = [
        "id" => $id_busca,
        "tipo" => $tipo,
        "pergunta" => $pergunta,
        "respostas" => $respostas,
        "correta" => $correta
    ];
    
    file_put_contents($jsonFile, json_encode($perguntas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Editar Pergunta</title>
</head>
<body>
    <div class="container">
        <h2>Editar Pergunta ID: <?= $id_busca ?></h2>
        <form method="POST">
           <input type="hidden" name="tipo" value="<?= $dados_pergunta['tipo'] ?>">
            <label>Pergunta:</label>
            <input type="text" name="pergunta" value="<?= htmlspecialchars($dados_pergunta['pergunta']) ?>" required>
            
            <?php if ($dados_pergunta['tipo'] == "multipla"): ?>
                <input type="text" name="r1" value="<?= htmlspecialchars($dados_pergunta['respostas'][0] ?? '') ?>" placeholder="Opção 1" required>
                <input type="text" name="r2" value="<?= htmlspecialchars($dados_pergunta['respostas'][1] ?? '') ?>" placeholder="Opção 2" required>
                <input type="text" name="r3" value="<?= htmlspecialchars($dados_pergunta['respostas'][2] ?? '') ?>" placeholder="Opção 3" required>
                <label>Letra Correta:</label>
                <input type="text" name="correta" value="<?= htmlspecialchars($dados_pergunta['correta']) ?>" required>
            <?php else: ?>
                <label>Resposta Esperada:</label>
                <textarea name="texto" required style="width:100%; padding:10px; border-radius:5px; border:1px solid #ccc;"><?= htmlspecialchars($dados_pergunta['correta']) ?></textarea>
            <?php endif; ?>
            
            <button type="submit" class="btn">Salvar Alterações</button>
            <a href="index.php" class="btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
