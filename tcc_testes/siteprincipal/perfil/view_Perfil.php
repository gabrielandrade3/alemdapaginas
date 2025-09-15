<?php
ini_set('session.cookie_path', '/');
session_start();
include('../conexaobanco.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

$usuario_logado = $_SESSION['usuario_id'];

// Captura o usuário solicitado via PATH_INFO ou exibe o logado
if (isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) {
    $usuario_solicitado = ltrim($_SERVER['PATH_INFO'], '/'); // remove a barra inicial
} else {
    $usuario_solicitado = $usuario_logado;
}

// Determina se é ID ou nome de exibição
if (is_numeric($usuario_solicitado)) {
    $stmt = $conn->prepare("SELECT id, nome_exibicao, nome_usuario, foto_perfil, bio FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_solicitado);
} else {
    $stmt = $conn->prepare("SELECT id, nome_exibicao, nome_usuario, foto_perfil, bio FROM usuarios WHERE nome_usuario = ?");
    $stmt->bind_param("s", $usuario_solicitado);
}

$stmt->execute();
$stmt->bind_result($usuario_id, $nomeExibicao, $nomeUsuario, $fotoPerfil, $bio);
$stmt->fetch();
$stmt->close();

// Se não encontrou o usuário, exibe mensagem e sai
if (!$usuario_id) {
    die("Usuário não encontrado.");
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/tcclogin/siteprincipal/perfil/styleperfil.css">
</head>
<body>
<a href="/tcclogin/siteprincipal/site_livros.php" class="seta-voltar" title="Voltar para o site principal">
    <i class="fas fa-arrow-left"></i>
</a>
<div class="container mt-5">
    <!-- FOTO + NOME + BOTÃO -->
    <div class="d-flex align-items-center mb-3 flex-wrap">
        <?php if ($fotoPerfil): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($fotoPerfil) ?>" 
                 alt="Foto de Perfil" 
                 class="foto-perfil me-3 mb-2">
        <?php else: ?>
            <img src="/images/user.png" alt="Foto de Perfil" class="foto-perfil me-3 mb-2">
        <?php endif; ?>

        <div>
            <div class="d-flex align-items-center flex-wrap mb-2">
                <h2 class="mb-0 me-3 position-relative">
                    <span class="username-tooltip" data-username="<?= htmlspecialchars($nomeUsuario) ?>">
                        <?= htmlspecialchars($nomeExibicao) ?>
                    </span>
                </h2>
                <!-- Exibe botão Editar apenas se o perfil visualizado for do próprio usuário -->
                <?php if ($usuario_id === $usuario_logado): ?>
                <a href="edit_Perfil.php" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit"></i> Editar Perfil
                </a>
                <?php endif; ?>
            </div>
            <!-- BIO DO USUÁRIO -->
            <p class="text-muted"><?= !empty(trim($bio)) ? nl2br(htmlspecialchars($bio)) : '<em>Sem descrição</em>' ?></p>
        </div>
    </div>

    <!-- LIVROS FAVORITOS -->
    <h4 class="mb-3">Livros Favoritos</h4>
    <div class="d-flex flex-wrap gap-3 mb-5">
        <?php
        $stmt = $conn->prepare("SELECT capa_url FROM livros WHERE id_livro IN (1, 2, 3)"); // Exemplo fixo
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($capa);
        while ($stmt->fetch()):
            $imgSrc = !empty($capa) ? "/".htmlspecialchars($capa) : "/images/livro_padrao.jpg";
        ?>
            <img src="<?= $imgSrc ?>" alt="Capa do Livro" width="100" class="rounded shadow-sm">
        <?php
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
    $stmt = $conn->prepare("
        SELECT l.capa_url, l.titulo
        FROM resenhas r
        JOIN livros l ON r.livro_id = l.id_livro
        WHERE r.usuario_id = ?
        ORDER BY r.data_resenha DESC
        LIMIT 6
    ");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($capaRecente, $tituloRecente);
    while ($stmt->fetch()):
        $imgSrc = !empty($capaRecente) 
    ? (strpos($capaRecente, 'uploads/capas/') === false 
        ? "/tcclogin/siteprincipal/uploads/capas/" . htmlspecialchars($capaRecente) 
        : "/tcclogin/siteprincipal/" . htmlspecialchars($capaRecente))
    : "/tcclogin/siteprincipal/images/livro_padrao.jpg";

    ?>
        <img src="<?= $imgSrc ?>" 
             alt="<?= htmlspecialchars($tituloRecente) ?>" 
             width="80" height="120"
             class="rounded shadow-sm border border-warning" 
             style="object-fit: cover;">
    <?php
    endwhile;
    $stmt->close();
    ?>
    </div>

    <!-- RESENHAS -->
    <h4>Resenhas</h4>
    <?php if (empty($resenhas)): ?>
        <p class="text-muted">Este usuário ainda não escreveu nenhuma resenha.</p>
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
<script src="/tcclogin/siteprincipal/perfil/scriptperfil.js"></script>
</body>
</html>
