<?php
session_start();
include('conexaobanco.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['name'];
    $sobrenome = $_POST['last_name'];
    $nascimento = $_POST['birthdate'];
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $senha = $_POST['password'];
    $confirmaSenha = $_POST['confirm_password'];
    $genero = $_POST['gender'];

    // Validação do e-mail
    if (!$email) {
        $_SESSION['msg'] = ['tipo' => 'erro', 'texto' => 'E-mail inválido!'];
        header('Location: cadastro2.php');
        exit;
    }

    if (strlen($senha) < 6) {
    $_SESSION['msg'] = ['tipo' => 'erro', 'texto' => 'A senha deve ter no mínimo 6 caracteres!'];
    header('Location: cadastro2.php');
    exit;
    }

    // Verificar se as senhas coincidem
    if ($senha !== $confirmaSenha) {
        $_SESSION['msg'] = ['tipo' => 'erro', 'texto' => 'As senhas não coincidem!'];
        header('Location: cadastro2.php');
        exit;
        }

    // Verificar se o email já existe
    $verifica_email = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $verifica_email->bind_param("s", $email);
    $verifica_email->execute();
    $resultado = $verifica_email->get_result();


    if ($resultado->num_rows > 0) {
        $_SESSION['msg'] = ['tipo' => 'erro', 'texto' => 'E-mail já cadastrado!'];
        header('Location: cadastro2.php');
    } else {

     // Criptografar a senha antes de salvar
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir no banco de dados
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, sobrenome, nascimento, email, senha, genero) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome, $sobrenome, $nascimento, $email, $senhaHash, $genero);

        if ($stmt->execute()) {
            $_SESSION['msg'] = ['tipo' => 'sucesso', 'texto' => 'Cadastro realizado com sucesso! Faça o login.'];
            header('Location: login.php'); // Página de login
        } else {
            $_SESSION['msg'] = ['tipo' => 'erro', 'texto' => 'Erro no cadastro. Tente novamente!'];
            header('Location: cadastro2.php');
        }

        $stmt->close();
    }

    $verifica_email->close();
    $conn->close();
}
?>