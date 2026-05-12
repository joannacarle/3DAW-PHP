<?php
//verifica se o formulário foi enviado; cria uma variável para guardar o resultado
$resultado = "";

//método POST. Quando vc clica no botão, o método é ativado, só então o php executa os dados
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];
    $operacao = $_POST["operacao"];

    if (is_numeric($num1) && is_numeric($num2)){
        switch($operacao){
            case "soma":
                $resultado = $num1 + $num2;
                break;
            case "sub":
                $resultado = $num1 - $num2;
                break;
            case "mult":
                $resultado = $num1 * $num2;
                break;
            case "div":
                if($num2 != 0){
                    $resultado = $num1 / $num2;
                } else {
                    $resultado = "Não é possível realizar dividir por zero!";
                }
                break;
        }
    } else {
        $resultado = "Digite apenas números";
    } 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora em PHP</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #dbeafe, #f0f9ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container{
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            width: 380px;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            animation: aparecer 0.5s ease;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .resultado {
            margin-top: 20px;
            padding: 15px;
            background-color: #e0f7fa;
            border: 1px solid #b2ebf2;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            color: #00796b;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>


</head>

<body>
    <div class="container">

    <h2>Calculadora</h2>

    <form method="POST" onsubmit="return validarFormulario()"> 

        <input 
            type="text" 
            name="num1" 
            id="num1"
            placeholder="Digite o primeiro número"
        >

        <input 
            type="text" 
            name="num2" 
            id="num2"
            placeholder="Digite o segundo número"
        >

        <select name="operacao" id="operacao">

        <option value="soma">Soma</option>
        <option value="sub">Subtração</option>
        <option value="mult">Multiplicação</option>
        <option value="div">Divisão</option>

        </select>

        <button type="submit">Calcular</button>

    </form>

    <?php if($resultado != ""): ?>

        <div class="resultado">
        Resultado: <?= $resultado ?>
        </div>

    <?php endif; ?>

    </div>


<script>

function validarFormulario(){

    let num1 = document.getElementById("num1").value;
    let num2 = document.getElementById("num2").value;
    let operacao = document.getElementById("operacao").value;

    //verifica se os campos estao vazios
    if(num1 === "" || num2 === ""){
        alert("Preencha todos os campos!");
        return false;
    }

    //verifica se são números
    if(isNaN(num1) || isNaN(num2)){ //isNaN = is Not a Number; verifica se o valor não é um número
        alert("Digite apenas números!");
        return false;
    }

    //impedir divisão por zero
    if(operacao === "div" && Number(num2) === 0){
        alert("Não é possível dividir por zero!");
        return false;
    }

    return true;
}

</script>

</body>
</html>
