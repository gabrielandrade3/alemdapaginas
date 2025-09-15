<?php
session_start();
include('conexaobanco.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para ver as resenhas.");
}

// Consulta todas as resenhas com informações do usuário e do livro
$sql = "
    SELECT 
        r.id_resenha,
        r.comentario,
        r.nota,
        r.data_resenha,
        r.usuario_id,
        u.nome_exibicao,
        u.nome_usuario,
        u.foto_perfil,
        l.titulo AS titulo_livro,
        l.capa_url AS imagem_capa
    FROM resenhas r
    JOIN usuarios u ON r.usuario_id = u.id
    JOIN livros l ON r.livro_id = l.id_livro
    ORDER BY r.id_resenha DESC
";

$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resenhas</title>
    <link rel="stylesheet" href="styleRES.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php
    $usuarioSolicitado = isset($_SERVER['PATH_INFO']) 
    ? ltrim($_SERVER['PATH_INFO'], '/') 
    : $_SESSION['usuario_id'];
    ?>
<!-- Botão para voltar -->
<a href="site_livros.php" class="botao-voltar position-fixed" title="Voltar para lista de livros">
    <i class="fas fa-arrow-left"></i>
</a>

<h1>Resenhas</h1>

<?php if ($resultado && $resultado->num_rows > 0): ?>
    <?php while ($resenha = $resultado->fetch_assoc()): ?>
        <div class="resenha">
            <!-- Capa do livro -->
            <img 
                src="<?= htmlspecialchars($resenha['imagem_capa']) ?>" 
                alt="Capa de <?= htmlspecialchars($resenha['titulo_livro']) ?>"
            >

            <div class="conteudo">
                <h3><?= htmlspecialchars($resenha['titulo_livro']) ?></h3>

                <!-- Usuário autor da resenha -->
                <div class="usuario-info">
                    <?php 
                        $fotoPerfil = !empty($resenha['foto_perfil']) 
                            ? 'data:image/jpeg;base64,' . base64_encode($resenha['foto_perfil']) 
                            : 'avatar_padrao.png';
                        $perfilLink = ($_SESSION['usuario_id'] == $resenha['usuario_id']) 
                        ? "perfil/view_perfil.php" 
                        : "perfil/view_perfil.php/" . urlencode($resenha['nome_usuario']);
                    ?>
                    <img 
                        class="foto-perfil-pequena" 
                        src="<?= $fotoPerfil ?>" 
                        alt="Foto de <?= htmlspecialchars($resenha['nome_exibicao']) ?>"

                    >
                    <a href="<?= $perfilLink ?>" class="nome-usuario">
                        <?= htmlspecialchars($resenha['nome_exibicao']) ?>
                    </a>
                </div>

                <!-- Nota em estrelas -->
                <p><strong>Nota:</strong>
                    <?php
                        $nota = (int)$resenha['nota'];
                        for ($i = 0; $i < 5; $i++) {
                            echo $i < $nota 
                                ? '<span class="estrela">★</span>' 
                                : '<span class="estrela">☆</span>';
                        }
                    ?>
                </p>

                <!-- Comentário da resenha -->
                <p><?= nl2br(htmlspecialchars($resenha['comentario'])) ?></p>
                <p><em>Enviado em: <?= date('d/m/Y', strtotime($resenha['data_resenha'])) ?></em></p>

                <!-- Botões de ação apenas para o dono da resenha -->
                <?php if ($_SESSION['usuario_id'] == $resenha['usuario_id']): ?>
                    <div class="botoes">
                        <a 
                            href="EDIT_Res.php?id=<?= (int)$resenha['id_resenha'] ?>" 
                            class="botao editar"
                        >
                            Editar
                        </a>
                        <form 
                            action="DELETE_Res.php" 
                            method="POST" 
                            onsubmit="return confirm('Tem certeza que deseja excluir esta resenha?');" 
                            style="display:inline;"
                        >
                            <input type="hidden" name="id_resenha" value="<?= (int)$resenha['id_resenha'] ?>">
                            <button type="submit" class="botao excluir">Excluir</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p class="mensagem-vazia">Nenhuma resenha encontrada.</p>
<?php endif; ?>

<?php $conn->close(); ?>
</body>
</html>
