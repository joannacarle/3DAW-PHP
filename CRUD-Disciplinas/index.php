<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD disciplina</title>
    <style>
        body{font-family:sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;} /*estiliza a tabela*/
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; } /* th(table header)= cabeçalho, td (table data)= conteudo da tabela */
        thead{ background-color: aliceblue;} /* agrupa o contúdo do cabeçalho em uma tabela*/
        .acoes a { margin-right: 10px; text-decoration: none;} /* estiliza os links de ação */
        .btn-novo { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;} /* estiliza o botão de nova disciplina */
         .btn-novo:hover { background-color: #218838;} /* efeito hover para o botão */
    </style>
</head>
<body>
    <h1>Gerenciador de Disciplinas</h1>
    <a href="incluir.php" class="btn-novo">Adicionar nova disciplina</a>
    <table>

        <thead>
            <tr>
                <th>Nome</th>
                <th>Sigla</th>
                <th>Carga Horária</th>
                <th class="acoes">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $arquivo = 'disciplina.txt';
            if (file_exists($arquivo)) {
                $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                // Exibe cada disciplina em uma linha da tabela. O 'foreach' percorre cada linha do arquivo, usando 'explode' para separar os campos e exibi-los nas colunas correspondentes. Também inclui links para editar e excluir cada disciplina.
                foreach ($linhas as $id => $linha) {
                    list($nome, $sigla, $carga) = explode(';', $linha);
                    echo "<tr>
                            <td>$nome</td>
                            <td>$sigla</td>
                            <td>$carga</td>

                            <td class='acoes'>
                                <a href='editar.php?id=$id'>Editar</a>
                                <a href='excluir.php?id=$id' onclick=\"return confirm('Tem certeza que deseja excluir esta disciplina?');\">Excluir</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhuma disciplina cadastrada.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
</body>
</html>