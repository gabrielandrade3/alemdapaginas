<?php
include('../conexaobanco.php');

// Pegando o ID do gênero "Romance"
$sqlGenero = "SELECT id FROM generos WHERE nome = 'Aventura' LIMIT 1";
$resultGenero = mysqli_query($conn, $sqlGenero);
$genero = mysqli_fetch_assoc($resultGenero);
$generoId = $genero['id'];

// Buscando os livros do gênero "Romance"
$sqlLivros = "SELECT * FROM livros WHERE genero_id = $generoId";
$resultLivros = mysqli_query($conn, $sqlLivros);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Livros de Aventura</title>
    <link rel="stylesheet" href="aventura.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Serifadas+Elegantes:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <section id="aventura">
        <h2>Aventura</h2>
        <div id="livros-aventura" class="book-list">
            <?php if (mysqli_num_rows($resultLivros) > 0): ?>
                <?php while ($livro = mysqli_fetch_assoc($resultLivros)) : ?>
                    <div class="livro">
                        <img src="/tcclogin/siteprincipal/<?= htmlspecialchars($livro['capa_url']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" width="150" height="200">
                        <h3><?= htmlspecialchars($livro['titulo']) ?></h3>
                        <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
                        <?php
                        // PARA A "BREVE DESCRIÇÃO" SEM CLICAR EM "leia"
                        $descricao = htmlspecialchars($livro['descricao']);
                        $limite = 100; // número de caracteres permitidos

                        if (strlen($descricao) > $limite) {
                        $descricao = substr($descricao, 0, $limite) . '...';
                        }
                        ?>
                        <p><?= $descricao ?></p>
                        <form action="detalheslivro.php" method="get">
                        <input type="hidden" name="id" value="<?= $livro['id_livro'] ?>">
                        <button type="submit">Leia</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="mensagem">Nenhum livro encontrado para o gênero Aventura.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
