<?php
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $data_nascimento = $_POST["data_nascimento"];
    $cpf = $_POST["cpf"];
    $matricula = $_POST["matricula"];
    $email = $_POST["email"];

    // Validação simples
    if (empty($nome) || empty($data_nascimento) || empty($matricula) || empty($cpf) || empty($email)) {
        $mensagem = "Preencha todos os campos!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Email inválido!";
    } else {
        $mensagem = "Aluno cadastrado com sucesso!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>

    <style>
        body {
            background-color: #e6f2ff;
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            width: 300px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        h2 {
            color: #3399ff;
        }

        input {
            width: 90%;
            padding: 8px;
            margin: 8px 0;
            border-radius: 10px;
            border: 1px solid #99ccff;
        }

        button {
            background-color: #3399ff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #267acc;
        }

        .mensagem {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Cadastro de Aluno</h2>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome completo">

        <input type="date" name="data_nascimento">

        <input type="text" name="matricula" placeholder="Matrícula">

        <input type="text" name="cpf" placeholder="CPF">

        <input type="text" name="email" placeholder="E-mail">

        <button type="submit">Cadastrar</button>
    </form>

    <?php if ($mensagem != ""): ?>
        <div class="mensagem">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>