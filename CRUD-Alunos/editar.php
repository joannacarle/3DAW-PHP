<?php
$arquivo = 'dados.txt';
$id = $_GET['id'];

$linhas = file($aruivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (!isset($linhas[$id])) {
    echo "Aluno não encontrado!";
    exit;
}

list($nome, $cpf, $email, $materia, $data, $turno) = explode(';', $linhas[$id]);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = trim($_POST["nome"]);
    $cpf = trim($_POST["cpf"]);
    $email = trim($_POST["email"]);
    $materia = trim($_POST["materia"]);
    $data = trim($_POST["data"]);
    $turno = trim($_POST["turno"]);

     if (!empty($nome) && !empty($cpf) && !empty($email)) {

        $linhas[$id] = $nome . ";" .
                       $cpf . ";" .
                       $email . ";" .
                       $materia . ";" .
                       $data . ";" .
                       $turno;

        file_put_contents($arquivo, implode("\n", $linhas));

        header("Location: index.php");
        exit();

    } else {
        $msg = "Preencha os campos obrigatórios!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
    <style>

        body {
            background-color: #e6f2ff;
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        input, select, button, a {
            display: block;
            padding: 10px;
            margin-top: 5px;
            width: 300px;
            box-sizing: border-box;
        }

        a {
            text-align: center;
            background-color: #3399ff;
            color: white;
            text-decoration: none;
        }

    </style>

<?php if (!empty($msg)): ?>
    <p style="text-align:center; color:red; font-weight:bold;">
        <?= $msg ?>
    </p>
<?php endif; ?>

<form method="POST">

<input name="nome" value="<?= $nome ?>" required>

<input name="cpf" value="<?= $cpf ?>" required>

<input type="email" name="email" value="<?= $email ?>" required>

<input name="materia" value="<?= $materia ?>">

<input type="date" name="data" value="<?= $data ?>">

<select name="turno">
    <option <?= $turno == "Manhã" ? "selected" : "" ?>>Manhã</option>
    <option <?= $turno == "Tarde" ? "selected" : "" ?>>Tarde</option>
    <option <?= $turno == "Noite" ? "selected" : "" ?>>Noite</option>
</select>

<button class="btn">Atualizar</button>

<a href="index.php" class="btn" style="background:#999;">Cancelar</a>

</form>

</div>
</head>

</body>
</html>