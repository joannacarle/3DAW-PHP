<?php
session_start();
$msg = "";

if ($_POST) {

    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $linhas = file("usuarios.txt", FILE_IGNORE_NEW_LINES);

    foreach ($linhas as $linha) {

        list($user, $pass) = explode(";", $linha);

        if ($usuario == $user && $senha == $pass) {

            $_SESSION["logado"] = true;
            $_SESSION["usuario"] = $usuario;

            header("Location: menu.php");
            exit();
        }
    }

    $msg = "Login inválido!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>


