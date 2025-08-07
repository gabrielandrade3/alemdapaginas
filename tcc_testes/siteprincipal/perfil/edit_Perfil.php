<?php
ini_set('session.cookie_path', '/');
session_start();
include('../conexaobanco.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Mensagem de retorno
$mensagem = "";

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = trim($_POST['bio']);

    // Atualiza bio e/ou imagem
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $foto = file_get_contents($_FILES['foto']['tmp_name']);
    $stmt = $conn->prepare("UPDATE usuarios SET bio = ?, foto_perfil = ? WHERE id = ?");
    $stmt->bind_param("sbi", $bio, $foto, $usuario_id);
    $stmt->send_long_data(1, $foto);
    }
    else {
        // Apenas bio
        $stmt = $conn->prepare("UPDATE usuarios SET bio = ? WHERE id = ?");
        $stmt->bind_param("si", $bio, $usuario_id);
    }

    if ($stmt->execute()) {
        $mensagem = "Perfil atualizado com sucesso.";
    } else {
        $mensagem = "Erro ao atualizar perfil.";
    }
    $stmt->close();
}

// Recupera os dados atuais para exibir
$bio = '';
$fotoPerfil = null;
$stmt = $conn->prepare("SELECT bio, foto_perfil FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($bio, $fotoPerfil);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleEditPerfil.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Editar Perfil</h2>

    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-info"><?= $mensagem ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <!-- Imagem atual -->
        <div class="mb-3">
            <label class="form-label">Foto de Perfil</label><br>
            <img id="preview" class="preview-img"
                 src="<?= $fotoPerfil ? 'data:image/jpeg;base64,' . base64_encode($fotoPerfil) : 'images/user.png' ?>"
                 alt="Foto de Perfil">
            <input type="file" name="foto" class="form-control mt-2" accept="image/*" onchange="previewImage(this)">
        </div>

        <!-- Bio -->
        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea name="bio" id="bio" class="form-control" rows="4" maxlength="255"><?= htmlspecialchars($bio) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="view_perfil.php" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const file = input.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = () => preview.src = reader.result;
        reader.readAsDataURL(file);
    }
}
</script>
</body>
</html>
