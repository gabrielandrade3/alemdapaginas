<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
    
require 'vendor/autoload.php'; // ou o caminho correto se baixou manualmente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $email = $_POST['email'];
    $codigo = rand(100000, 999999);
    $_SESSION['codigo_recuperacao'] = $codigo;

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'seuemail@gmail.com'; // seu e-mail
        $mail->Password = 'sua-senha-ou-senha-de-aplicativo'; // sua senha ou senha de app
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom('seuemail@gmail.com', 'Seu Nome ou Sistema');
        $mail->addAddress($email);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Código de Recuperação de Senha';
        $mail->Body    = "Seu código de recuperação é: <strong>$codigo</strong>";

        $mail->send();

        // Redirecionar para página de verificação
        header("Location: validarcodigo.php");
        exit;
    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    }
}
?>
