<?php
// Inclui o arquivo de conexão com o banco de dados
include('conexaobanco.php');

// Consulta SQL para obter todos os livros cadastrados, agora incluindo o campo do arquivo
$sql = "SELECT livros.id_livro, livros.titulo, livros.autor, livros.descricao, livros.data_publicacao, livros.capa_url, livros.arquivo_url, generos.nome AS genero
        FROM livros
        JOIN generos ON livros.genero_id = generos.id";

// Executa a consulta
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Importa o CSS do Font Awesome para os ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleFUNC.css">
</head>
<body class="bg-light">

<!-- Botão de saída fixado no topo -->
<a href="site_livros.php" 
   class="btn btn-danger position-fixed top-0 start-0 m-3 shadow-sm rounded-circle" 
   title="Sair">
   <i class="fas fa-arrow-left"></i>
</a>

<div class="container mt-5">
    <h2 class="mb-4">Livros Cadastrados</h2>

    <!-- Tabela para exibir os livros cadastrados -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="id-col">#</th>
                <th class="capa-col">Capa</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Descrição</th>
                <th>Gênero</th>
                <th>Data de Publicação</th>
                <th>Arquivo</th> <!-- Nova coluna para o arquivo -->
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Verifica se existem livros cadastrados
            if ($result->num_rows > 0) {
                // Loop para exibir cada livro na tabela
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';echo '<td class="id-col">' . $row['id_livro'] . '</td>';
                    // Exibe a imagem de capa
                    echo '<td class="capa-col"><img src="' . htmlspecialchars($row['capa_url']) . '" alt="Capa do Livro" width="100" height="150"></td>';
                    echo '<td>' . htmlspecialchars($row['titulo']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['autor']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['descricao']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['genero']) . '</td>';
                    echo '<td>' . $row['data_publicacao'] . '</td>';

                    // Verifica se o arquivo existe e cria um link de visualização/download
                    if (!empty($row['arquivo_url'])) {
                        echo '<td>
                        <a href="' . htmlspecialchars($row['arquivo_url']) . '" target="_blank" class="btn btn-dark btn-sm" title="Ver Arquivo">
                        <i class="fas fa-file-alt"></i> Ver Arquivo
                        </a>
                        </td>';

                    } else {
                        echo '<td><span class="text-muted">Nenhum arquivo</span></td>';
                    }

                    // Botões de Atualizar e Excluir
                    echo '<td>
                        <a href="edit_Livros.php?id=' . $row['id_livro'] . '" class="btn btn-warning btn-sm" title="Editar">
                        <i class="fas fa-pencil-alt"></i>
                            </a>
                        <a href="delete_Livros.php?id=' . $row['id_livro'] . '" class="btn btn-danger btn-sm" title="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este livro?\')">
                        <i class="fas fa-trash-alt"></i>
                            </a>

                          </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="9">Nenhum livro cadastrado.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    // Adapta a tabela para mobile
    document.addEventListener('DOMContentLoaded', function() {
        const cells = document.querySelectorAll('td');
        const headers = document.querySelectorAll('th');
        
        cells.forEach((cell, i) => {
            const headerIndex = i % headers.length;
            cell.setAttribute('data-label', headers[headerIndex].textContent);
        });
    });
</script>

</body>
</html>

<?php
// Fecha a conexão com o banco
$conn->close();
?>
