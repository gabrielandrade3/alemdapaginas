<?php
// Inicia sessão e conexão
session_start();
include('conexaobanco.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

// Verifica se a requisição foi via POST e o ID foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_resenha'])) {
    $id_resenha = (int) $_POST['id_resenha'];
    $usuario_id = $_SESSION['usuario_id'];

    // Verifica se a resenha pertence ao usuário
    $stmt = $conn->prepare("SELECT id_resenha FROM resenhas WHERE id_resenha = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $id_resenha, $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        die("Você não tem permissão para excluir esta resenha.");
    }

    // Exclui a resenha
    $delete = $conn->prepare("DELETE FROM resenhas WHERE id_resenha = ?");
    $delete->bind_param("i", $id_resenha);
    if ($delete->execute()) {
        header("Location: func_Res.php");
        exit;
    } else {
        echo "Erro ao excluir resenha.";
    }

} else {
    die("Requisição inválida.");
}

$conn->close();
?>
