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

<label>Tipo de Pergunta</label>
<select name="tipo" id="tipo" onchange="toggleCampos()">
    <option value="multipla">Múltipla escolha</option>
    <option value="texto">Resposta em texto</option>
</select>

<label>Pergunta</label>
<input name="pergunta" placeholder="Digite a pergunta" required>

<div id="campoMultipla">

<h4>Alternativas</h4>

<input name="r1" placeholder="Alternativa A">
<input name="r2" placeholder="Alternativa B">
<input name="r3" placeholder="Alternativa C">

<input name="correta" placeholder="Resposta correta (ex: A ou texto)">

</div>

<div id="campoTexto" style="display:none;">

<h4>Resposta esperada</h4>

<input name="texto" placeholder="Digite a resposta correta">

</div>

<button class="btn">Salvar</button>

<a href="index.php" class="btn-secondary">Cancelar</a>

</form>

</div>

<script>
function toggleCampos() {
    let tipo = document.getElementById("tipo").value;

    let multipla = document.getElementById("campoMultipla");
    let texto = document.getElementById("campoTexto");

    if (tipo === "multipla") {
        multipla.style.display = "block";
        texto.style.display = "none";
    } else {
        multipla.style.display = "none";
        texto.style.display = "block";
    }
}
</script>