<?php 
$arquivo = 'disciplina.txt';
$id = $_GET['id'];

// Lê o conteúdo do arquivo em um array, onde cada linha é um elemento do array. carrega todas as linhas do arquivo em um array.
$linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

