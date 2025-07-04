<?php
ini_set('session.cookie_path', '/'); // Sessão válida em todo o site -->
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Além das Pág.</title>

    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Sacramento&family=Dancing+Script&family=Serifadas+Elegantes:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styleprincipal.css"> <!-- Importa o CSS separado -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="site_livros.html">MENU</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dicas-de-livros.html">Dicas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="resenhas.php">Criar Resenha</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorias
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="poesia.html">Poesia</a></li>
                            <li><a class="dropdown-item" href="romance.html">Romance</a></li>
                            <li><a class="dropdown-item" href="suspense.html">Suspense</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_Livro.php">Adicionar Livro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="func_livros.php">Livros Cadastrados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Func_Res.php">Resenhas</a>
                    </li>
                </ul>
                
                
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <header>
        <h1>Além das Páginas</h1>
    </header>

    <main>
        <section>
            <h2>Bem-vindo ao Além das Páginas</h2>
            <p>Olá, leitores e leitoras! Sejam bem-vindos ao meu mundo, que agora também é o seu novo mundinho...</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Meu Site de Livros</p>
    </footer>

</body>
</html>
