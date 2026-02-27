<?php
//verifica se o formulário foi enviado; cria-se uma variável para guardar o resultado
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
            background-color: #C7F0FF;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .calculadora {
            background-color: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            text-align: center;
            width: 300px;
        }

        h2{
            color: #2EC7FF;
        }

        input, select {
            width: 90%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #90b7cc
        }

        button {
            background-color: #0a90e3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 15px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0448a8;
        }

        .resultado {
            margin-top: 15px;
            font-weight: bold;
            color: #0061c9;
        }
    
    </style>


</head>

<body>
    <div class="calculadora">
        <h2>Calculadora PHP</h2>

        <form method="POST">
            <input type="text" name="num1" placeholder="Primeiro Número">

            <select name="operacao">
                <option value="soma">➕ Soma</option>
                <option value="sub">➖ Subtração</option>
                <option value="mult">✖ Multiplicação</option>
                <option value="div">➗ Divisão</option>
            </select>

            <input type="text" name="num2" placeholder="Segundo Número">

            <button type="submit">Calcular</button>

        </form>

        <?php if ($resultado != ""): ?>
            <div class="resultado">
                Resultado: <?php echo $resultado; ?>
            </div>
        <?php endif; ?>

    </div>
</body>

</html>