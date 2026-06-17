<?php
session_start();
if (!isset($_SESSION["logado"])){       
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonFile = "perguntas.json";

    $perguntas = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
    if (!is_array($perguntas)) {
        $perguntas = [];
    }

    //gera um id baseado no maior id existente + 1
   $maxId = 0;
    foreach ($perguntas as $p) {
        if ($p['id'] > $maxId) {
            $maxId = $p['id'];
        }
    }
    $id = $maxId + 1;

    $tipo = $_POST["tipo"];
    $pergunta = trim($_POST["pergunta"]);

    if ($tipo == "multipla") {
        $respostas = [$_POST["r1"], $_POST["r2"], $_POST["r3"]];
        $correta = trim($_POST["correta"]);
    } else {
        $respostas = [];
        $correta = trim($_POST["texto"]);
    }

    $novaPergunta = [
        "id" => $id,
        "tipo" => $tipo,
        "pergunta" => $pergunta,
        "respostas" => $respostas,
        "correta" => $correta
    ];

    $perguntas[] = $novaPergunta;

   file_put_contents($jsonFile, json_encode($perguntas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: index.php");
    exit();
}

?>

<link rel="stylesheet" href="style.css">

<div class="container">
    <h2>Nova Pergunta</h2>

    <form method="POST" onsubmit="return validarPergunta()">
        <label>Tipo de Pergunta</label>
        <select name="tipo" id="tipo" onchange="toggleCampos()">
            <option value="multipla">Múltipla escolha</option>
            <option value="texto">Resposta em texto</option>
        </select>
        
        <label>Pergunta</label>
        <input name="pergunta" placeholder="Digite a pergunta" required>
        
        <div id="campoMultipla">
            <h4>Alternativas</h4>

            <input name="r1" id="r1" placeholder="Alternativa A">
            <input name="r2" id="r2" placeholder="Alternativa B">
            <input name="r3" id="r3" placeholder="Alternativa C">
            <label>Letra Correta:</label>
            <input name="correta" id="correta" placeholder="Resposta correta (ex: A ou texto)">
        </div>

        <div id="campoTexto" style="display:none;">
            <h4>Resposta esperada</h4>
            <input name="texto" id="texto" placeholder="Digite a resposta correta">
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
        //para não enviar lixo
        document.getElementById("texto").disabled = true;
        document.getElementById("r1").disabled = false;
        document.getElementById("r2").disabled = false;
        document.getElementById("r3").disabled = false;
        document.getElementById("correta").disabled = false;
    } else {
        multipla.style.display = "none";
        texto.style.display = "block";

        document.getElementById("texto").disabled = false;
        document.getElementById("r1").disabled = true;
        document.getElementById("r2").disabled = true;
        document.getElementById("r3").disabled = true;
        document.getElementById("correta").disabled = true;
    }
}

function validarPergunta(){
    let pergunta = document.querySelector('[name="pergunta"]').value.trim();
    let tipo = document.getElementById("tipo").value;

if(pergunta === ""){
    alert("Digite uma pergunta.");
    return false;
}

if(tipo === "multipla"){
    let r1 = document.getElementById("r1").value.trim();
        let r2 = document.getElementById("r2").value.trim();
        let r3 = document.getElementById("r3").value.trim();
        let correta = document.getElementById("correta").value.trim();
        if(r1 === "" || r2 === "" || r3 === "" || correta === ""){
            alert("Preencha todas as alternativas e a resposta correta.");
            return false;
    }
} else {
    let texto = document.getElementById("texto").value.trim();
    if(texto === ""){
        alert("Digite a resposta correta.");
        return false;
    }
}

return true;
}

//inicializa a exibição correta dos campos
window.onload = toggleCampos;
</script>
