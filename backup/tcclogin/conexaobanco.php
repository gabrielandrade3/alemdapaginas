<?php
$servidor = "localhost";
$usuario = "root";
$senha = "jk123456"; // Se você tiver senha, coloque aqui
$banco = "loginpaginas";

// Criar conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

?>