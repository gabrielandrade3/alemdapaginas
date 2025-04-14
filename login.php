<?php
include('conexaobanco.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $senha = isset($_POST["senha"]) ? $_POST["senha"] : "";

    if (empty($email) || empty($senha)) {
        echo "Preencha todos os campos!";
    } else {
        // Proteção contra SQL Injection
        $email = $conn->real_escape_string($email);
        $senha = $conn->real_escape_string($senha);

        // Consultar o banco de dados
        $sql = "SELECT id, senha FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);  // "s" significa string para o parâmetro
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verificar se o usuário foi encontrado
        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            // Verificar se a senha é correta
            if (password_verify($senha, $row['senha'])) {  // Comparação direta
                echo "Login bem-sucedido!";
            } else {
                echo "Usuário ou senha inválidos!";
            }
        } else {
            echo "Usuário ou senha inválidos!";
        }
    }
}

$conn->close();
?>
