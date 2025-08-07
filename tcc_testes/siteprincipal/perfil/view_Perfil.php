<?php
ini_set('session.cookie_path', '/');
session_start();
include('../conexaobanco.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Recupera nome de exibição, foto de perfil e bio
$nomeExibicao = '';
$fotoPerfil = null;
$bio = '';
$nomeUsuario = '';

$stmt = $conn->prepare("SELECT nome_exibicao, foto_perfil, bio, nome_usuario FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($nomeExibicao, $fotoPerfil, $bio, $nomeUsuario);
$stmt->fetch();
$stmt->close();


// Recupera resenhas feitas pelo usuário
$resenhas = [];
$stmt = $conn->prepare("
    SELECT r.comentario, r.data_resenha, l.titulo, l.autor 
    FROM resenhas r 
    JOIN livros l ON r.livro_id = l.id_livro 
    WHERE r.usuario_id = ?
    ORDER BY r.data_resenha DESC
");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($comentario, $data, $tituloLivro, $autorLivro);
while ($stmt->fetch()) {
    $resenhas[] = [
        'comentario' => $comentario,
        'data' => $data,
        'titulo' => $tituloLivro,
        'autor' => $autorLivro
    ];
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleperfil.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-5">
    <!-- FOTO + NOME + BOTÃO -->
    <div class="d-flex align-items-center mb-3 flex-wrap">
        <?php if ($fotoPerfil): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($fotoPerfil) ?>" 
            alt="Foto de Perfil" 
            class="foto-perfil me-3 mb-2">

        <?php else: ?>
            <img src="images/user.png" alt="Foto de Perfil" class="foto-perfil me-3 mb-2">

        <?php endif; ?>

        <div>
            <div class="d-flex align-items-center flex-wrap mb-2">
                <h2 class="mb-0 me-3 position-relative">
                <span class="username-tooltip" data-username="<?= htmlspecialchars($nomeUsuario) ?>">
                <?= htmlspecialchars($nomeExibicao) ?>
                </span>
                </h2>




                <a href="edit_Perfil.php" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit"></i> Editar Perfil
                </a>
            </div>
            <!-- BIO DO USUÁRIO -->
            <p class="text-muted"><?= !empty(trim($bio)) ? nl2br(htmlspecialchars($bio)) : '<em>Sem descrição</em>' ?></p>
        </div>
    </div>

    <!-- LIVROS FAVORITOS -->
    <h4 class="mb-3">Livros Favoritos</h4>
    <div class="d-flex flex-wrap gap-3 mb-5">
        <?php
        $stmt = $conn->prepare("SELECT capa_url FROM livros WHERE id_livro IN (1, 2, 3)"); // Exemplo
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($capa);
        while ($stmt->fetch()):
            if ($capa):
        ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($capa) ?>" alt="Capa do Livro" width="100" class="rounded shadow-sm">
        <?php
            endif;
        endwhile;
        $stmt->close();
        ?>
    </div>
    <!-- ATIVIDADE RECENTE -->
    <div class="d-flex justify-content-between align-items-center mt-5 mb-2">
        <h4 class="mb-0">Atividade Recente</h4>
        <small class="text-muted" style="cursor: pointer;">Todos</small>
    </div>
    <hr style="border-top: 1px solid #c9b486; margin-bottom: 1.5rem;">

    <div class="d-flex flex-row flex-wrap gap-3">
    <?php
    // Recupera as 6 resenhas mais recentes feitas pelo usuário com as capas dos livros
    $stmt = $conn->prepare("
        SELECT l.capa_url 
        FROM resenhas r 
        JOIN livros l ON r.livro_id = l.id_livro 
        WHERE r.usuario_id = ?
        ORDER BY r.data_resenha DESC
        LIMIT 6
    ");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($capaRecente);
    while ($stmt->fetch()):
        if ($capaRecente):
    ?>
        <img src="data:image/jpeg;base64,<?= base64_encode($capaRecente) ?>" 
            alt="Capa do Livro" 
            width="80" height="120"
            class="rounded shadow-sm border border-warning" 
            style="object-fit: cover;">
    <?php
        endif;
    endwhile;
    $stmt->close();
    ?>
    </div>


    <!-- RESENHAS -->
    <h4>Minhas Resenhas</h4>
    <?php if (empty($resenhas)): ?>
        <p class="text-muted">Você ainda não escreveu nenhuma resenha.</p>
    <?php else: ?>
        <?php foreach ($resenhas as $resenha): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <?= htmlspecialchars($resenha['titulo']) ?> — <?= htmlspecialchars($resenha['autor']) ?>
                </div>
                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($resenha['comentario'])) ?></p>
                    <small class="text-muted">Postado em: <?= date('d/m/Y', strtotime($resenha['data'])) ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script src="scriptperfil.js"></script>
</body>
</html>
