<?php
session_start();
include('conexaobanco.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Você precisa estar logado para acessar essa página.'); window.location.href='index.html';</script>";
    exit();
}

$id = $_SESSION['usuario_id'];

// Buscar dados do usuário
$stmt = $conn->prepare("SELECT nome, sobrenome, nascimento, email, genero FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="perfil.css"> <!-- Você pode criar ou adaptar um CSS -->
</head>
<body>
    <div class="perfil-container">
        <h1>Bem-vindo(a), <?php echo htmlspecialchars($usuario['nome']); ?>!</h1>
        <div class="perfil-info">
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
            <p><strong>Sobrenome:</strong> <?php echo htmlspecialchars($usuario['sobrenome']); ?></p>
            <p><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars($usuario['nascimento']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
            <p><strong>Gênero:</strong> <?php echo htmlspecialchars($usuario['genero']); ?></p>
        </div>
        <a href="recuperarS.html">Alterar Senha</a> |
        <a href="logout.php">Sair</a>
    </div>
</body>
</html>