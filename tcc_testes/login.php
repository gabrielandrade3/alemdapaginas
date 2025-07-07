<?php
ini_set('session.cookie_path', '/');
session_start();
include('conexaobanco.php');

$mensagem = ""; // Nova variável para mensagens


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $senha = isset($_POST["senha"]) ? $_POST["senha"] : "";

if (empty($email) || empty($senha)) {
    $mensagem = "Preencha todos os campos!";
}       

        $email = $conn->real_escape_string($email);
        $senha = $conn->real_escape_string($senha);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mensagem = "E-mail inválido!";
        }

        $sql = "SELECT id, senha FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            if (password_verify($senha, $row['senha'])) {
                $_SESSION['usuario_id'] = $row['id'];
                // LOGIN OK
                header("Location: ../tcclogin/siteprincipal/site_livros.php");
                exit();
            } else {
                // SENHA INCORRETA
                $mensagem = "Usuário ou senha inválidos!";
            }
        } else {
            // USUÁRIO NÃO ENCONTRADO
            $mensagem = "Usuário ou senha inválidos!";
        }
    }


$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'rel='stylesheet'> 
    <link rel="stylesheet" href="styless.css">
    <title>Login</title>
</head>
<body>
    <main class="container">
        <?php if (!empty($mensagem)): ?>
            <div class="mensagem-erro">
                <?= htmlspecialchars($mensagem) ?>
            </div>
            <?php endif; ?>

        
        <form action="login.php" method="post">
            <h1>Login</h1>
        <div class="input-box">
            <input placeholder="Usuário" type="email" name="email" required>
            <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
            <input placeholder="Senha" type="password" name="senha" required>
            <i class="bx bxs-lock-alt"></i>
        </div>

        <div class="remember-forgot">
            <label>
                <input type="checkbox">
                Lembrar Senha
            </label>
                <a href="recuperarS.html">Esqueceu a Senha?</a>
        </div>

            <button type="submit" class="login">Login</button>

            <div class="register-link">
            <p>Não tem uma conta? <a href="cadastro2.php">Cadastre-se</a></p>
        </div>
        
        </form>
    </main>
</body>
</html>
