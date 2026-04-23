<?php
session_start();
$erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioDigitado = $_POST['usuario']; 
    $senhaDigitada = $_POST['senha'];
    $fileName = "usuarios.txt";
    
    if (file_exists($fileName)) {
        $linhas = file($fileName, FILE_IGNORE_NEW_LINES);
        foreach ($linhas as $linha) {
            list($user, $pass) = explode(";", trim($linha));
            
            if ($usuarioDigitado == $user && $senhaDigitada == $pass) {
                $_SESSION["logado"] = true;
                $_SESSION["usuario"] = $user;
                header("Location: menu.php");
                exit();
            }
        }
        $erro = "Usuário ou senha incorretos!";
    } else {
        $erro = "Arquivo de usuários não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="login-box">
        <h1>Login</h1>
        <?php if ($erro) echo "<div class='alert error'>$erro</div>"; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="submit" value="Entrar" class="btn">
        </form>
    </div>
</body>
</html>


