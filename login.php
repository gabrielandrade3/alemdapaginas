<?php
ini_set('session.cookie_path', '/');
session_start();
include('conexaobanco.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $senha = isset($_POST["senha"]) ? $_POST["senha"] : "";

    if (empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!'); window.location.href = 'index.html';</script>";
    } else {
        $email = $conn->real_escape_string($email);
        $senha = $conn->real_escape_string($senha);

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
                echo "<script>alert('Login bem-sucedido!'); window.location.href = '../tcclogin/siteprincipal/site_livros.php';</script>";
            } else {
                // SENHA INCORRETA
                echo "<script>alert('Usuário ou senha inválidos!'); window.location.href = 'index.html';</script>";
            }
        } else {
            // USUÁRIO NÃO ENCONTRADO
            echo "<script>alert('Usuário ou senha inválidos!'); window.location.href = 'index.html';</script>";
        }
    }
}

$conn->close();
?>
