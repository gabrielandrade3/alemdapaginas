<?php
ini_set('session.cookie_path', '/'); // Garante que o cookie da sessão funcione corretamente
session_start();
include('conexaobanco.php'); // Conexão com o banco de dados

$mensagem = ""; 
$mostrar_mensagem = false; // Flag para controlar se a mensagem de erro deve ser exibida

// Verifica se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Aplica trim diretamente nos dados do formulário (remove espaços extras)
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";

    // Verifica se os campos estão preenchidos
    if (empty($email) || empty($senha)) {
        $mensagem = "Preencha todos os campos!";
        $mostrar_mensagem = true;
    } else {
        // Evita SQL Injection
        $email = $conn->real_escape_string($email);
        $senha = $conn->real_escape_string($senha);

        // Valida formato de e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mensagem = "E-mail inválido!";
            $mostrar_mensagem = true;
        } else {
            // Consulta segura ao banco
            $sql = "SELECT id, senha FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            // Verifica se o usuário existe
            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();

                // Verifica senha
                if (password_verify($senha, $row['senha'])) {
                    $_SESSION['usuario_id'] = $row['id'];

                    // Login OK, redireciona
                    header("Location: ../tcclogin/siteprincipal/site_livros.php");
                    exit();
                } else {
                    // Senha incorreta
                    $mensagem = "Usuário ou senha inválidos!";
                    $mostrar_mensagem = true;
                }
            } else {
                // Usuário não encontrado
                $mensagem = "Usuário ou senha inválidos!";
                $mostrar_mensagem = true;
            }
        }
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
        
            <?php if ($mostrar_mensagem && !empty($mensagem)): ?>
                <div class="mensagem-erro"><?= htmlspecialchars($mensagem) ?></div>
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
    <script src="scriptlogin.js"></script>
</body>
</html>
