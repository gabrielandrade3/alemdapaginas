<?php
ini_set('session.cookie_path', '/');
session_start();
include('conexaobanco.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Você precisa estar logado para enviar uma resenha.'); window.location.href = '../index.html';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $livro_id = intval($_POST['livro_id']);
    $usuario_id = $_SESSION['usuario_id'];
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $nota = intval($_POST['nota']);

    // Insere a resenha
    $stmt = $conn->prepare("INSERT INTO resenhas (livro_id, usuario_id, comentario, nota) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $livro_id, $usuario_id, $comentario, $nota);

    if ($stmt->execute()) {
        echo "<script>alert('Resenha enviada com sucesso!'); window.location.href = 'site_livros.php';</script>";
    } else {
        echo "<script>alert('Erro ao enviar resenha.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>