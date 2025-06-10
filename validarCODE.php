<?php
session_start();

// Verifica se o código de recuperação foi enviado e armazenado na sessão
if (!isset($_SESSION['codigo_recuperacao'])) {
    echo "Nenhum código de recuperação foi gerado.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém o código inserido pelo usuário
    $codigo_inserido = $_POST['codigo'];

    // Verifica se o código inserido corresponde ao código gerado
    if ($codigo_inserido == $_SESSION['codigo_recuperacao']) {
        echo "Código válido! Você pode agora alterar sua senha.";
        // Redirecionar para a página de mudança de senha, por exemplo
    } else {
        echo "Código inválido! Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Código</title>
</head>
<body>
    <div class="container">
        <h2>Validar Código</h2>
        <form method="post">
            <label for="codigo">Digite o Código de Recuperação:</label>
            <input type="text" name="codigo" placeholder="Código de 6 dígitos" required>

            <button type="submit">Validar Código</button>
        </form>
    </div>
</body>
</html>
