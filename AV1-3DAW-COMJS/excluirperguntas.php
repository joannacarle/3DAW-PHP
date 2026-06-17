<?php
session_start();
if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit();
}

$id = isset($_GET["id"]) ? (int)$_GET["id"] : null;
$jsonFile = "perguntas.json";

if ($id && file_exists($jsonFile)) {
    $perguntas = json_decode(file_get_contents($jsonFile), true);

    $novasPerguntas = array_filter($perguntas, function($p) use ($id) {
        return $p['id'] !== $id;
    });

    file_put_contents($jsonFile, json_encode(array_values($novasPerguntas), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

header("Location: index.php");
exit();
