<?php
// Inclui o arquivo de conexão com o banco de dados
include('conexaobanco.php');

// Verifica se o ID do livro foi fornecido para exclusão
if (isset($_GET['id'])) {
    $id_livro = $_GET['id'];

    // Consulta SQL para excluir o livro
    $sql = "DELETE FROM livros WHERE id_livro = ?";

    // Prepara e executa a consulta
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
    }
}

$conn->close();
?>
