<?php
// Iniciar sessão e conectar ao banco de dados
session_start();
include('conexaobanco.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para editar uma resenha.");
}

// Verificar se o ID da resenha foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID da resenha inválido.");
}

$id_resenha = $_GET['id'];

// Buscar a resenha do banco de dados
$sql = "
    SELECT r.id_resenha, r.comentario, r.nota, r.livro_id
    FROM resenhas r
    WHERE r.id_resenha = $id_resenha AND r.usuario_id = {$_SESSION['usuario_id']}
";

$resultado = $conn->query($sql);

// Se a resenha não foi encontrada ou não pertence ao usuário logado, redireciona
if ($resultado->num_rows == 0) {
    die("Resenha não encontrada ou você não tem permissão para editá-la.");
}

$resenha = $resultado->fetch_assoc();

// Buscar livros disponíveis para o select
$livros = $conn->query("SELECT id_livro, titulo FROM livros");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Resenha</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styleRES_MAIN.css">
</head>
<body>
    
    <div class="review-form">
        <h2>Editar Resenha</h2>
        <p>Altere a resenha que você escreveu anteriormente.</p>
    
        <form action="UPDATE_Res.php" method="POST">
            <!-- Campo oculto para enviar o ID da resenha -->
            <input type="hidden" name="id_resenha" value="<?= $resenha['id_resenha'] ?>">

            <label for="livro_id">Escolha o Livro:</label>
            <select name="livro_id" required>
                <option value="">-- Selecione --</option>
                <?php while ($livro = $livros->fetch_assoc()): ?>
                    <option value="<?= $livro['id_livro'] ?>" <?= $livro['id_livro'] == $resenha['livro_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($livro['titulo']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
    
            <!-- Seletor de nota com valores de 1 a 5 -->
            <label for="nota">Nota (1 a 5):</label>
            <select name="nota" required>
                <option value="1" <?= $resenha['nota'] == 1 ? 'selected' : '' ?>>★</option>
                <option value="2" <?= $resenha['nota'] == 2 ? 'selected' : '' ?>>★★</option>
                <option value="3" <?= $resenha['nota'] == 3 ? 'selected' : '' ?>>★★★</option>
                <option value="4" <?= $resenha['nota'] == 4 ? 'selected' : '' ?>>★★★★</option>
                <option value="5" <?= $resenha['nota'] == 5 ? 'selected' : '' ?>>★★★★★</option>
            </select>
    
            <label for="comentario">Comentário:</label>
            <textarea name="comentario" rows="5" required><?= htmlspecialchars($resenha['comentario']) ?></textarea>
    
            <button type="submit">Atualizar Resenha</button>
        </form>
    </div>
    
</body>
</html>

<?php
$conn->close();
?>
