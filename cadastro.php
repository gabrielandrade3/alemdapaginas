<?php
include('conexaobanco.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['name'];
    $sobrenome = $_POST['last_name'];
    $nascimento = $_POST['birthdate'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptografar senha
    $genero = $_POST['gender'];

    // Verificar se o email já existe
    $verifica_email = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $verifica_email->bind_param("s", $email);
    $verifica_email->execute();
    $resultado = $verifica_email->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>alert('E-mail já cadastrado!'); window.location.href='cadastro2.html';</script>";
    } else {
        // Inserir no banco de dados
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, sobrenome, nascimento, email, senha, genero) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome, $sobrenome, $nascimento, $email, $senha, $genero);

        if ($stmt->execute()) {
            echo "<script>alert('Cadastro realizado com sucesso, Faça o Login!'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Erro no cadastro,Faça novamente!'); window.location.href='cadastro2.html';</script>";
        }

        $stmt->close();
    }

    $verifica_email->close();
    $conn->close();
}
?>