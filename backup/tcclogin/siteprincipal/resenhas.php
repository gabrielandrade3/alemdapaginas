<?php
// Iniciar sessão para obter o ID do usuário logado
ini_set('session.cookie_path', '/');
session_start();
include('conexaobanco.php');
    
// Buscar os livros disponíveis para o select
$livros = $conn->query("SELECT id_livro, titulo FROM livros");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Resenha</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styleRES_MAIN.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <a href="site_livros.php" 
        class="botao-voltar position-fixed" 
        title="Voltar para lista de livros">
        <i class="fas fa-arrow-left"></i>
    </a>
    
    <div class="review-form">
        <h2>Bem-vindo à seção de resenhas</h2>
        <p>Compartilhe sua experiência de leitura com os outros leitores!</p>
        <h3>Adicione sua Resenha</h3>
    
        <form action="SEND_Resenha.php" method="POST">
            <label for="livro_id">Escolha o Livro:</label>
            <select name="livro_id" required>
                <option value="">-- Selecione --</option>
                <?php while ($livro = $livros->fetch_assoc()): ?>
                    <option value="<?= $livro['id_livro'] ?>"><?= htmlspecialchars($livro['titulo']) ?></option>
                <?php endwhile; ?>
            </select>
    
            <!-- Seletor de nota com valores de 0,5 até 5 -->
            <label for="nota">Nota (1 a 5):</label>
            <select name="nota" required>
                <option value="1">★</option>
                <option value="2">★★</option>
                <option value="3">★★★</option>
                <option value="4">★★★★</option>
                <option value="5">★★★★★</option>

            </select>
    
            <label for="comentario">Comentário:</label>
            <textarea name="comentario" rows="5" required></textarea>
    
            <button type="submit">Enviar Resenha</button>
        </form>
    </div>
    
</body>
</html>
