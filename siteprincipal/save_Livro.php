<?php
include('conexaobanco.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $descricao = $_POST['descricao'];

    if (empty($titulo) || empty($autor) || empty($genero) || empty($descricao)) {
        echo "<script>alert('Preencha todos os campos obrigatórios.'); window.location.href = 'add_Livro.php';</script>";
        exit;
    }

    // Cria as pastas se não existirem
    if (!file_exists('uploads/capas')) {
        mkdir('uploads/capas', 0777, true);
    }
    if (!file_exists('uploads/pdf')) {
        mkdir('uploads/pdf', 0777, true);
    }

    // Upload da imagem de capa
    $capa_nome = $_FILES['capa']['name'];
    $capa_tmp = $_FILES['capa']['tmp_name'];
    $capa_destino = 'uploads/capas/' . uniqid() . '_' . basename($capa_nome);

    if (!move_uploaded_file($capa_tmp, $capa_destino)) {
        echo "<script>alert('Erro ao fazer upload da imagem da capa.'); window.location.href = 'add_Livro.php';</script>";
        exit;
    }

    // Upload do arquivo do livro
    $arquivo_destino = null;

    if (!empty($_FILES['arquivo']['name'])) {
        $arquivo_nome = $_FILES['arquivo']['name'];
        $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
        $arquivo_destino = 'uploads/pdf/' . uniqid() . '_' . basename($arquivo_nome);

        if (!move_uploaded_file($arquivo_tmp, $arquivo_destino)) {
            echo "<script>alert('Erro ao fazer upload do arquivo do livro.'); window.location.href = 'add_Livro.php';</script>";
            exit;
        }
    }

    // Insere no banco
    $sql = "INSERT INTO livros (titulo, autor, descricao, capa_url, arquivo_url, data_publicacao, genero_id)
            VALUES (?, ?, ?, ?, ?, CURDATE(), ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $titulo, $autor, $descricao, $capa_destino, $arquivo_destino, $genero);

    if ($stmt->execute()) {
        echo "<script>alert('Livro cadastrado com sucesso!'); window.location.href = 'site_livros.php';</script>";
    } else {
        echo "<script>alert('Erro ao salvar no banco de dados.'); window.location.href = 'add_Livro.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
