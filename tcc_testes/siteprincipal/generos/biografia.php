<?php
include('../conexaobanco.php');

// Pegando o ID do gênero "Romance"
$sqlGenero = "SELECT id FROM generos WHERE nome = 'Biografia' LIMIT 1";
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
    <title>Livros de Biografia</title>
    <link rel="stylesheet" href="biografia.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Serifadas+Elegantes:wght@400;700&display=swap" rel="stylesheet">
    <body>
    <section id="biografia">
        <h2>Biografia</h2>
        <div id="livros-biografia" class="book-list">
            <?php if (mysqli_num_rows($resultLivros) > 0): ?>
                <?php while ($livro = mysqli_fetch_assoc($resultLivros)) : ?>
                    <div class="livro">
                        <img src="/tcclogin/siteprincipal/<?= htmlspecialchars($livro['capa_url']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" width="150" height="200">
                        <h3><?= htmlspecialchars($livro['titulo']) ?></h3>
                        <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
                        <?php
                        // PARA A "BREVE DESCRIÇÃO" SEM CLICAR EM "leia" - limitar caracteres
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
                <p class="mensagem">Nenhum livro encontrado para o gênero Biografia.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
