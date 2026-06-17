<?php
session_start();
$erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioDigitado = $_POST['usuario']; 
    $senhaDigitada = $_POST['senha'];
    $jsonFile = "usuarios.json";
    
    if (file_exists($jsonFile)) {
        $usuarios = json_decode(file_get_contents($jsonFile), true);
        $autenticado = false;

        if (is_array($usuarios)) {
            foreach ($usuarios as $usuario) {
                if ($usuario['usuario'] === $usuarioDigitado && $usuario['senha'] === $senhaDigitada) {
                    $_SESSION["logado"] = true;
                    $_SESSION["usuario"] = $usuario['usuario'];
                    header("Location: menu.php");
                    exit();
                }
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



