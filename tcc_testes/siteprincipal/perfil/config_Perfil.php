<?php
ini_set('session.cookie_path', '/');
session_start();
include('../conexaobanco.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensagem = "";

// Atualiza dados e privacidade
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_dados'])) {
        $nome_exibicao = $_POST['nome_exibicao'];
        $nascimento = $_POST['nascimento'];
        $genero = $_POST['genero'];

        $stmt = $conn->prepare("SELECT nome_exibicao, nascimento, genero FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $dados_atuais = $stmt->get_result()->fetch_assoc();

        if (
            $dados_atuais['nome_exibicao'] === $nome_exibicao &&
            $dados_atuais['nascimento'] === $nascimento &&
            $dados_atuais['genero'] === $genero
        ) {
            $mensagem = "Nenhuma alteração foi feita.";
        } else {
            $stmt = $conn->prepare("UPDATE usuarios SET nome_exibicao=?, nascimento=?, genero=? WHERE id=?");
            $stmt->bind_param("sssi", $nome_exibicao, $nascimento, $genero, $usuario_id);
            $stmt->execute();
            $mensagem = "Dados atualizados com sucesso!";
        }
    }

    if (isset($_POST['update_notificacoes'])) {
        $notif_seguidores = isset($_POST['notif_seguidores']) ? 1 : 0;
        $notif_curtidas = isset($_POST['notif_curtidas']) ? 1 : 0;
        $notif_comentarios = isset($_POST['notif_comentarios']) ? 1 : 0;

        $stmt = $conn->prepare("SELECT notif_seguidores, notif_curtidas, notif_comentarios FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $dados_atuais = $stmt->get_result()->fetch_assoc();

        if (
            (int)$dados_atuais['notif_seguidores'] === $notif_seguidores &&
            (int)$dados_atuais['notif_curtidas'] === $notif_curtidas &&
            (int)$dados_atuais['notif_comentarios'] === $notif_comentarios
        ) {
            $mensagem = "Nenhuma alteração nas notificações.";
        } else {
            $stmt = $conn->prepare("UPDATE usuarios SET notif_seguidores=?, notif_curtidas=?, notif_comentarios=? WHERE id=?");
            $stmt->bind_param("iiii", $notif_seguidores, $notif_curtidas, $notif_comentarios, $usuario_id);
            $stmt->execute();
            $mensagem = "Preferências de notificações atualizadas!";
        }
    }
}

// Carrega dados do usuário
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Configurações do Perfil</title>
    <link rel="stylesheet" href="configPerfil.css">
    <script src="scriptconfig.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<!-- Div escondida para o JS detectar mensagem -->
<div id="toast-msg" style="display:none;" data-msg="<?= htmlspecialchars($mensagem) ?>"></div>

<button id="btn-voltar" type="button">← Voltar ao Site Principal</button>

<h2>Configurações</h2>

<div class="config-container">
    <div class="config-menu">
        <button class="tab-btn active" data-target="dados">
            <i class="fas fa-lock"></i> Dados e Privacidade
        </button>
        <button class="tab-btn" data-target="notificacoes">
            <i class="fas fa-bell"></i> Notificações
        </button>
    </div>

    <div class="config-content">
        <div id="dados" class="config-section active">
            <h3>Dados e Privacidade</h3>
            <form method="POST">
                <input type="hidden" name="update_dados" value="1">

                <label>Nome de Usuário: 
                    <input type="text" value="<?= htmlspecialchars($usuario['nome_usuario']) ?>" readonly>
                </label><br>

                <label>Email: 
                    <input type="email" value="<?= htmlspecialchars($usuario['email']) ?>" readonly>
                </label><br>

                <label>Nome de Exibição: 
                    <input type="text" name="nome_exibicao" value="<?= htmlspecialchars($usuario['nome_exibicao']) ?>">
                </label><br>

                <label>Data de Nascimento: 
                    <input type="date" name="nascimento" value="<?= $usuario['nascimento'] ?>">
                </label><br>

                <label>Gênero: 
                    <select name="genero">
                        <option value="male" <?= $usuario['genero'] == 'male' ? 'selected' : '' ?>>Masculino</option>
                        <option value="female" <?= $usuario['genero'] == 'female' ? 'selected' : '' ?>>Feminino</option>
                        <option value="other" <?= $usuario['genero'] == 'other' ? 'selected' : '' ?>>Outro</option>
                    </select>
                </label><br>

                <button type="submit">Salvar Dados</button>
            </form>
        </div>

        <div id="notificacoes" class="config-section">
            <h3>Notificações</h3>
            <form method="POST">
                <input type="hidden" name="update_notificacoes" value="1">
                <label><input type="checkbox" name="notif_seguidores" <?= $usuario['notif_seguidores'] ? 'checked' : '' ?>> Novos seguidores</label><br>
                <label><input type="checkbox" name="notif_curtidas" <?= $usuario['notif_curtidas'] ? 'checked' : '' ?>> Curtidas nas reviews</label><br>
                <label><input type="checkbox" name="notif_comentarios" <?= $usuario['notif_comentarios'] ? 'checked' : '' ?>> Novos comentários</label><br>
                <button type="submit">Salvar Notificações</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
