<?php
// Inicia a sessão e conecta ao banco de dados
session_start();
include('conexaobanco.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para ver as resenhas.");
}

// Consulta SQL para buscar resenhas com informações do livro e do usuário
$sql = "
    SELECT 
        r.id_resenha, 
        r.comentario, 
        r.nota, 
        r.data_resenha,
        u.nome AS nome_usuario, 
        l.titulo AS titulo_livro,
        l.capa_url AS imagem_capa,
        r.usuario_id
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
    
<a href="site_livros.php" 
   class="botao-voltar position-fixed" 
   title="Voltar para lista de livros">
   <i class="fas fa-arrow-left"></i>
</a>
    <h1>Resenhas</h1>


    <?php if ($resultado->num_rows > 0): ?>
        <?php while ($resenha = $resultado->fetch_assoc()): ?>
            <div class="resenha">
                <!-- Exibe a imagem da capa -->
                <img src="<?= htmlspecialchars($resenha['imagem_capa']) ?>" alt="Capa de <?= htmlspecialchars($resenha['titulo_livro']) ?>">
                <div class="conteudo">
                    <h3><?= htmlspecialchars($resenha['titulo_livro']) ?></h3>
                    <p><strong>Usuário:</strong> <?= htmlspecialchars($resenha['nome_usuario']) ?></p>
                    
                    <!-- Exibe as estrelas baseado na nota -->
                    <p><strong>Nota:</strong>
                        <?php
                        // Exibe as estrelas de acordo com a nota
                        $nota = $resenha['nota'];
                        // Exibe as estrelas cheias
                        for ($i = 0; $i < $nota; $i++) {
                            echo '<span class="estrela">★</span>';
                        }
                        // Preenche as estrelas restantes até 5 com estrelas vazias
                        for ($i = $nota; $i < 5; $i++) {
                            echo '<span class="estrela">☆</span>';
                        }
                        ?>
                    </p>

                    <p><?= nl2br(htmlspecialchars($resenha['comentario'])) ?></p>
                    <p><em>Enviado em: <?= $resenha['data_resenha'] ?></em></p>

                    <!-- Verifica se o usuário logado é o autor da resenha -->
                    <?php if ($_SESSION['usuario_id'] == $resenha['usuario_id']): ?>
                        <div class="botoes">
    <!-- Botão de edição -->
    <a href="EDIT_Res.php?id=<?= $resenha['id_resenha'] ?>" class="botao editar">Editar</a>

    <!-- Botão de exclusão via POST -->
                    <form action="DELETE_Res.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta resenha?');" style="display:inline;">
                        <input type="hidden" name="id_resenha" value="<?= $resenha['id_resenha'] ?>">
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

</body>
</html>

<?php
$conn->close();
?>
