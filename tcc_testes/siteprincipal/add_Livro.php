<?php
include('conexaobanco.php'); // Conexão com o banco

// Consulta SQL para buscar os gêneros cadastrados
$sql = "SELECT id, nome FROM generos";
$result = $conn->query($sql); // Executa a consulta
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Livro</title>
    <!-- Importa o CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Importa o CSS do Font Awesome para os ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleADD.css">
</head>
<body>

<!-- Ícone de saída fixado no topo -->
<a href="site_livros.php" 
   class="btn btn-danger position-fixed top-0 start-0 m-3 shadow-sm rounded-circle" 
   title="Sair">
   <i class="fas fa-arrow-left"></i>
</a>

<div class="container mt-5">
    <h2 class="mb-4">Adicionar Livro</h2>

    <!-- Formulário de envio para salvar o livro no banco -->
    <form action="save_Livro.php" method="POST" enctype="multipart/form-data">
        
        <!-- Campo para o título do livro -->
        <div class="mb-3">
            <label for="titulo" class="form-label">Título do Livro</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>

        <!-- Campo para o nome do autor -->
        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" class="form-control" id="autor" name="autor" required>
        </div>

        <!-- Campo de seleção de gênero (popular dinamicamente com PHP) -->
        <div class="mb-3">
            <label for="genero" class="form-label">Gênero</label>
            <select class="form-select" id="genero" name="genero" required>
                <option value="">Selecione...</option>
                <?php
                // Verifica se há gêneros no banco e preenche o <select> com eles
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nome']) . '</option>';
                    }
                } else {
                    echo '<option value="">Nenhum gênero cadastrado</option>';
                }
                ?>
            </select>
        </div>

        <!-- Campo para descrição do livro -->
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição </label>
            <textarea class="form-control" id="descricao" name="descricao" rows="4" required></textarea>
        </div>

        <!-- Campo para envio da imagem da capa do livro -->
        <div class="mb-3">
            <label for="capa" class="form-label">Capa do Livro (Imagem)</label>
            <input type="file" class="form-control" id="capa" name="capa" accept="image/*" required>
        </div>

        <!-- Novo campo para envio do arquivo PDF (ou outro tipo de documento) -->
        <div class="mb-3">
            <label for="arquivo" class="form-label">Arquivo do Livro (PDF ou outro)</label>
            <input type="file" class="form-control" id="arquivo" name="arquivo" accept=".pdf,.doc,.docx,.txt,.epub">
        </div>

        <!-- Botões de ação -->
        <button type="submit" class="btn btn-primary">Cadastrar Livro</button>
    </form>
</div>

</body>
</html>
