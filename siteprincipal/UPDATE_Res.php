<?php
// Iniciar sessão e conectar ao banco de dados
session_start();
include('conexaobanco.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para editar uma resenha.");
}

// Verificar se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados enviados
    $id_resenha = $_POST['id_resenha'];
    $livro_id = $_POST['livro_id'];
    $nota = $_POST['nota'];
    $comentario = $_POST['comentario'];

    // Verificar se a resenha pertence ao usuário logado
    $sql = "
        SELECT usuario_id
        FROM resenhas
        WHERE id_resenha = $id_resenha AND usuario_id = {$_SESSION['usuario_id']}
    ";

    $resultado = $conn->query($sql);

    // Se não encontrou a resenha ou não pertence ao usuário logado
    if ($resultado->num_rows == 0) {
        die("Você não tem permissão para editar esta resenha.");
    }

    // Atualizar a resenha no banco de dados
    $sql = "
        UPDATE resenhas
        SET livro_id = '$livro_id', nota = '$nota', comentario = '$comentario', data_resenha = NOW()
        WHERE id_resenha = '$id_resenha'
    ";

    if ($conn->query($sql)) {
        // Redirecionar para a página de resenhas ou exibir uma mensagem de sucesso
        header("Location: func_Res.php");
    } else {
        echo "Erro ao atualizar resenha: " . $conn->error;
    }
}

$conn->close();
?>
