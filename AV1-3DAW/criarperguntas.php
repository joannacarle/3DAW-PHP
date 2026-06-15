<?php
session_start();
if (!isset($_SESSION["logado"])) header("Location: login.php");

if ($_POST) {

    $linhas = file_exists("perguntas.txt") ? file("perguntas.txt", FILE_IGNORE_NEW_LINES) : [];
    $id = count($linhas) + 1;

    $tipo = $_POST["tipo"];
    $pergunta = trim($_POST["pergunta"]);

    if ($tipo == "multipla") {
        $respostas = $_POST["r1"] . ";" . $_POST["r2"] . ";" . $_POST["r3"];
        $correta = $_POST["correta"];
    } else {
        $respostas = "";
        $correta = $_POST["texto"];
    }

    $linha = "$id|$tipo|$pergunta|$respostas|$correta\n";
    file_put_contents("perguntas.txt", $linha, FILE_APPEND);

    header("Location: index.php");
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">

<h2>Nova Pergunta</h2>

<form method="POST">

<select name="tipo">
<option value="multipla">Múltipla</option>
<option value="texto">Texto</option>
</select>

<input name="pergunta" placeholder="Pergunta">

<h4>Múltipla</h4>
<input name="r1">
<input name="r2">
<input name="r3">
<input name="correta" placeholder="Correta">

<h4>Texto</h4>
<input name="texto">

<button class="btn">Salvar</button>

</form>

</div>
