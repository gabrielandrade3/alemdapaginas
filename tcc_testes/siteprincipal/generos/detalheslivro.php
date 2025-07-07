<?php
include('../conexaobanco.php');

if (!isset($_GET['id'])) {
    echo "Livro não especificado.";
    exit;
}

$idLivro = intval($_GET['id']);

$sql = "SELECT l.*, g.nome AS genero_nome 
        FROM livros l
        JOIN generos g ON l.genero_id = g.id
        WHERE l.id_livro = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $idLivro);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo "Livro não encontrado.";
    exit;
}

$livro = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="detalhes.css">
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($livro['titulo']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f9f9f9;
        }
        .livro-detalhes {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            box-shadow: 0 0 10px #ccc;
            border-radius: 8px;
        }
        .livro-detalhes img {
            width: 200px;
            height: auto;
            margin-bottom: 1rem;
        }
        h1 {
            font-family: 'Dancing Script', cursive;
        }
        p {
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="livro-detalhes">
        <h1><?= htmlspecialchars($livro['titulo']) ?></h1>
        <img src="/tcclogin/siteprincipal/<?= htmlspecialchars($livro['capa_url']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>">
        <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
        <p><strong>Gênero:</strong> <?= htmlspecialchars($livro['genero_nome']) ?></p>
        <p><strong>Data de Publicação:</strong> <?= htmlspecialchars($livro['data_publicacao']) ?></p>
        <p><strong>Descrição:</strong><br> <?= nl2br(htmlspecialchars($livro['descricao'])) ?></p>
    </div>
</body>
</html>
