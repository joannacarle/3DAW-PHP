<?php
$arquivo = 'disciplina.txt';
$id = $_GET['id'];

// Lê o conteúdo do arquivo em um array, onde cada linha é um elemento do array. carrega todas as linhas do arquivo em um array.
$linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Verifica se o ID existe no array de linhas. Se existir, usa 'explode' para separar os campos da linha correspondente ao ID e armazená-los em variáveis. Caso contrário, exibe uma mensagem de erro e encerra o script.
if (isset($linhas[$id])) {
    echo "Disciplina não encontrada!";
    exit();
}

//pega os dados da linha específica pelo id para preencher o formulário de edição. O 'explode' é usado para separar os campos da linha, que estão separados por ponto e vírgula, e atribuí-los às variáveis $nome, $sigla e $carga.
list($nome, $sigla, $carga) = explode(';', $linhas[$id]);

// Verifica se o formulário foi submetido usando o método POST. Se for, processa os dados enviados pelo formulário.
if( $_SERVER["REQUEST_METHOD"] == "POST"){
    $novo_nome = trim($_POST['nome']);
    $nova_sigla = trim($_POST['sigla']);
    $nova_carga = trim($_POST['carga']);

    //recria a linha com novos dados
    $nova_linha = $novo_nome . ";" . $nova_sigla . ";" . $nova_carga . "\n";
    //substitui a linha antiga pela nova no array
    $linhas[$id] = $nova_linha;

    $conteudo_final = implode("", $linhas);
    //escreve o conteúdo atualizado de volta no arquivo, sobrescrevendo o conteúdo existente

    file_put_contents($arquivo, $conteudo_final, LOCK_EX);
    // LOCK_EX garante que o arquivo seja bloqueado durante a escrita para evitar conflitos com outras

    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Disciplina</title>
    <style>
        body {font-family: sans-serif;}
        input, button{padding: 10px; margin-top: 5px; width: 300px; }  
    </style>
</head>
<body>
    <h1>Editar Disciplina</h1>
    <form action="editar.php?id=<?php echo $id; ?>" method="POST">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br><br>
        
        <label for="sigla">Sigla:</label><br>
        <input type="text" id="sigla" name="sigla" value="<?php echo htmlspecialchars($sigla); ?>" required><br><br>
        
        <label for="carga">Carga Horária:</label><br>
        <input type="number" id="carga" name="carga" value="<?php echo htmlspecialchars($carga); ?>" required><br><br>
        
        <button type="submit">Salvar Alterações</button>
        <a href="index.php">Cancelar</a>
    </form>
    
</body>
</html>