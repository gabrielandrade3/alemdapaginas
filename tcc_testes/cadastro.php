<?php
session_start();
include('conexaobanco.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_usuario = $_POST['name_user'];
    $nome_exibicao = $_POST['name_exibir'];
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
    $_SESSION['erro_confirm_password'] = 'As senhas não coincidem!';
    header('Location: cadastro2.php');
    exit;
    }


    // Verificação se o e-mail ou nome de usuário já estão cadastrados
    $verifica_existencia = $conn->prepare("SELECT email, nome_usuario FROM usuarios WHERE email = ? OR nome_usuario = ?");
    $verifica_existencia->bind_param("ss", $email, $nome_usuario);
    $verifica_existencia->execute();
    $resultado = $verifica_existencia->get_result();

    if ($resultado->num_rows > 0) {
        $dadosExistentes = $resultado->fetch_assoc();

        // Verifica qual dado está duplicado e informa ao usuário
        if ($dadosExistentes['email'] === $email) {
            $_SESSION['erro_email'] =  'Este e-mail já está sendo usado.';
        } elseif ($dadosExistentes['nome_usuario'] === $nome_usuario) {
            $_SESSION['erro_nome_usuario'] = 'Este nome de usuário já está sendo usado';
        }

        header('Location: cadastro2.php');
        exit;
    }

    // Criptografa a senha antes de armazenar no banco
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir no banco de dados
        $stmt = $conn->prepare("INSERT INTO usuarios (nome_usuario, nome_exibicao, nascimento, email, senha, genero) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome_usuario, $nome_exibicao, $nascimento, $email, $senhaHash, $genero);

        if ($stmt->execute()) {
            $_SESSION['msg'] = ['tipo' => 'sucesso', 'texto' => 'Cadastro realizado com sucesso! Faça o login.'];
            header('Location: login.php');
        } else {
            $_SESSION['msg'] = ['tipo' => 'erro', 'texto' => 'Erro no cadastro. Tente novamente!'];
            header('Location: cadastro2.php');
        }

        $stmt->close();
    }

    $verifica_existencia->close();
    $conn->close();
?>
