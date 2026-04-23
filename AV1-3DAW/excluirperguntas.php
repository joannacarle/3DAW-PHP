<?php
session_start();
if (!isset($_SESSION["logado"])) header("Location: login.php");

$id = $_GET["id"];
$linhas = file("perguntas.txt", FILE_IGNORE_NEW_LINES);

$novas = [];

foreach ($linhas as $linha) {
    list($pid) = explode("|", $linha);
    if ($pid != $id) $novas[] = $linha;
}

file_put_contents("perguntas.txt", implode("\n", $novas));

header("Location: index.php");
