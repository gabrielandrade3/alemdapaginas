<?php
// Inclui o arquivo de conexão com o banco de dados
include('conexaobanco.php');

// Verifica se o ID do livro foi fornecido para exclusão
if (isset($_GET['id'])) {
    $id_livro = $_GET['id'];

    // 1. Verifica se existem resenhas ligadas a esse livro
    $sql_check = "SELECT COUNT(*) FROM resenhas WHERE livro_id = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("i", $id_livro);
        $stmt_check->execute();
        $stmt_check->bind_result($qtd_resenhas);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($qtd_resenhas > 0) {
            // Se houver resenhas, exibe mensagem e não deleta
            echo "Não é possível excluir: tem resenhas com esse livro.";
            $conn->close();
            exit;
        }
    }

    // 2. Se não tem resenhas, pode excluir o livro
    $sql = "DELETE FROM livros WHERE id_livro = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_livro);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redireciona para a página de listagem de livros após a exclusão
            header("Location: func_Livros.php");
            exit;
        } else {
            echo "Erro ao excluir o livro ou livro não encontrado.";
        }
        $stmt->close();
    }
}

$conn->close();
?>
