<?php
session_start();
if (!isset($_SESSION["logado"])) header("Location: login.php");

$fileName = "perguntas.txt";
$id_busca = $_GET["id"] ?? null;
$linhas = file_exists($fileName) ? file($fileName, FILE_IGNORE_NEW_LINES) : [];
$indice_encontrado = -1;
$dados_pergunta = [];

foreach ($linhas as $i => $linha) {
    $colunas = explode("|", $linha);
    if ($colunas[0] == $id_busca) {
        $indice_encontrado = $i;
        $dados_pergunta = $colunas;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST["tipo"];
    $pergunta = $_POST["pergunta"];
    
    if ($tipo == "multipla") {
        $respostas = $_POST["r1"].";".$_POST["r2"].";".$_POST["r3"];
        $correta = $_POST["correta"];
    } else {
        $respostas = "";
        $correta = $_POST["texto"];
    }

    $nova_linha = "$id_busca|$tipo|$pergunta|$respostas|$correta";
    
    if ($indice_encontrado !== -1) {
        $linhas[$indice_encontrado] = $nova_linha;
        file_put_contents($fileName, implode("\n", $linhas) . "\n");
    }
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
            <input type="hidden" name="tipo" value="<?= $dados_pergunta[1] ?>">
            <label>Pergunta:</label>
            <input type="text" name="pergunta" value="<?= $dados_pergunta[2] ?>" required>
            
            <?php if ($dados_pergunta[1] == "multipla"): 
                $alts = explode(";", $dados_pergunta[3]); ?>
                <input type="text" name="r1" value="<?= $alts[0] ?? '' ?>" placeholder="Opção 1">
                <input type="text" name="r2" value="<?= $alts[1] ?? '' ?>" placeholder="Opção 2">
                <input type="text" name="r3" value="<?= $alts[2] ?? '' ?>" placeholder="Opção 3">
                <label>Letra Correta:</label>
                <input type="text" name="correta" value="<?= $dados_pergunta[4] ?>">
            <?php else: ?>
                <label>Resposta Esperada:</label>
                <textarea name="texto"><?= $dados_pergunta[4] ?></textarea>
            <?php endif; ?>
            
            <button type="submit" class="btn">Salvar Alterações</button>
            <a href="index.php" class="btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
