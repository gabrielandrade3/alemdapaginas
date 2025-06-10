<?php
// Inclui o arquivo de conexão com o banco de dados
include('conexaobanco.php');

// Verifica se o ID do livro foi passado via GET
if (isset($_GET['id'])) {
    $id_livro = $_GET['id'];

    // Consulta para pegar os dados do livro a ser editado, agora com arquivo_url
    $sql = "SELECT livros.id_livro, livros.titulo, livros.autor, livros.descricao, livros.capa_url, livros.arquivo_url, livros.data_publicacao, livros.genero_id, generos.nome AS genero
            FROM livros
            JOIN generos ON livros.genero_id = generos.id
            WHERE livros.id_livro = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_livro);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $livro = $resultado->fetch_assoc();
    } else {
        echo "Livro não encontrado!";
        exit;
    }
} else {
    echo "ID do livro não especificado!";
    exit;
}

// Processamento do formulário para atualizar os dados do livro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $descricao = $_POST['descricao'];
    $genero = $_POST['genero'];
    $data_publicacao = $_POST['data_publicacao'];
    $capa = $_FILES['capa'];
    $arquivo = $_FILES['arquivo'];

    // Processa nova capa (imagem)
    if ($capa['error'] == 0) {
        $diretorioCapa = 'uploads/capas/';
        $nomeCapa = uniqid() . '-' . $capa['name'];
        $caminho_capa = $diretorioCapa . $nomeCapa;
        move_uploaded_file($capa['tmp_name'], $caminho_capa);
    } else {
        $caminho_capa = $livro['capa_url'];
    }

    // Processa novo arquivo (PDF ou outro)
    if ($arquivo['error'] == 0) {
        $diretorioArquivo = 'uploads/arquivos/';
        $nomeArquivo = uniqid() . '-' . $arquivo['name'];
        $caminho_arquivo = $diretorioArquivo . $nomeArquivo;
        move_uploaded_file($arquivo['tmp_name'], $caminho_arquivo);
    } else {
        $caminho_arquivo = $livro['arquivo_url'];
    }

    // Atualiza o banco
    $sql = "UPDATE livros SET 
            titulo = ?, 
            autor = ?, 
            descricao = ?, 
            genero_id = (SELECT id FROM generos WHERE nome = ? LIMIT 1), 
            data_publicacao = ?, 
            capa_url = ?, 
            arquivo_url = ? 
            WHERE id_livro = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $titulo, $autor, $descricao, $genero, $data_publicacao, $caminho_capa, $caminho_arquivo, $id_livro);
    $stmt->execute();

    header('Location: func_Livros.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styleEDIT.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Editar Livro</h2>

    <form action="edit_livros.php?id=<?php echo $livro['id_livro']; ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_livro" value="<?php echo $livro['id_livro']; ?>">

        <div class="mb-3">
            <label for="titulo" class="form-label">Título do Livro</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" class="form-control" id="autor" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="genero" class="form-label">Gênero</label>
            <select class="form-select" id="genero" name="genero" required>
                <option value="">Selecione...</option>
                <option value="Romance" <?php if ($livro['genero'] == 'Romance') echo 'selected'; ?>>Romance</option>
                <option value="Suspense" <?php if ($livro['genero'] == 'Suspense') echo 'selected'; ?>>Suspense</option>
                <option value="Poesia" <?php if ($livro['genero'] == 'Poesia') echo 'selected'; ?>>Poesia</option>
                <option value="Fantasia" <?php if ($livro['genero'] == 'Fantasia') echo 'selected'; ?>>Fantasia</option>
                <option value="Autoajuda" <?php if ($livro['genero'] == 'Autoajuda') echo 'selected'; ?>>Autoajuda</option>
                <option value="Outro" <?php if ($livro['genero'] == 'Outro') echo 'selected'; ?>>Outro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($livro['descricao']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="capa" class="form-label">Capa do Livro (Imagem)</label>
            <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
            <?php if ($livro['capa_url']): ?>
                <img src="<?php echo htmlspecialchars($livro['capa_url']); ?>" alt="Capa Atual" width="100" height="150" class="mt-2">
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="arquivo" class="form-label">Arquivo do Livro (PDF ou outro)</label>
            <input type="file" class="form-control" id="arquivo" name="arquivo" accept=".pdf,.epub,.doc,.docx,.txt">
            <?php if ($livro['arquivo_url']): ?>
                <a href="<?php echo htmlspecialchars($livro['arquivo_url']); ?>" target="_blank" class="btn btn-outline-primary btn-sm mt-2">Ver Arquivo Atual</a>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="data_publicacao" class="form-label">Data de Publicação</label>
            <input type="date" class="form-control" id="data_publicacao" name="data_publicacao" value="<?php echo $livro['data_publicacao']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Livro</button>
        <a href="func_Livros.php" class="text-decoration-none text-dark d-inline-block mb-3">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 1-.708 0L4.5 8.207l-.354.353a.5.5 0 0 1 0-.707l3.5-3.5a.5.5 0 1 1 .708.707L5.707 7.5H11.5a.5.5 0 0 1 0 1H5.707l2.647 2.646a.5.5 0 0 1 0 .708z"/>
    </svg>
    <span class="ms-1">Voltar</span>
</a>

    </form>
</div>

</body>
</html>

<?php
$conn->close();
?>
