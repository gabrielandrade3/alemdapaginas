<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Além das Pág.| Ajuda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="ajudaPerfil.css">
</head>
<body>
    <div class="main-container">
        <header class="top-header">
            <h1>Central de Ajuda</h1>
            <p></p>
        </header>

        <nav class="help-nav" aria-label="Navegação de ajuda">
            <ul>
                <li><a href="ajuda_Inicio.php"><i class="fas fa-home"></i> Início</a></li>
                <li><a href="#" class="active"><i class="fas fa-user"></i> Perfil</a></li>
                <li><a href="#"><i class="fas fa-lock"></i> Privacidade</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </nav>

        <main class="faq-content">
            <section class="faq-item" id="faq1">
                <button class="faq-question">
                    <i class="fas fa-user-edit"></i>
                    Como altero minha foto de perfil?
                    <span class="icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Para alterar sua foto de perfil:</p>
                    <ol>
                        <li>Acesse seu perfil clicando em sua foto no canto superior direito</li>
                        <li>Selecione "Editar Perfil"</li>
                        <li>"Editar Perfil" novamente ao lado de seu nome</li>
                        <li>Selecione uma nova imagem do seu dispositivo</li>
                        <li>Clique em "Salvar Alterações"</li>
                    </ol>
                    <p><strong>Formatos aceitos:</strong> JPG, PNG ou GIF (até 2MB)</p>
                </div>
            </section>

            <section class="faq-item" id="faq2">
                <button class="faq-question">
                    <i class="fas fa-id-card"></i>
                    Posso alterar meu nome de exibição?
                    <span class="icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Sim, você pode alterar seu nome de exibição a qualquer momento:</p>
                    <ol>
                        <li>Vá até "Editar Perfil"</li>
                        <li>Atualize o campo "Nome de Exibição"</li>
                        <li>Clique em "Salvar Alterações"</li>
                    </ol>
                    <p><i class="fas fa-info-circle"></i> Observação: Seu nome de exibição será visível publicamente.</p>
                </div>
            </section>

            <section class="faq-item" id="faq3">
                <button class="faq-question">
                    <i class="fas fa-lock"></i>
                    Minhas informações são visíveis para outros usuários?
                    <span class="icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <ul>
                        <li><strong>Público:</strong> Nome de exibição e foto de perfil</li>
                        <li><strong>Privado:</strong> E-mail e informações de conta</li>
                    </ul>
                    <p>Você pode personalizar essas configurações em "Configurações" > "Privacidade".</p>
                </div>
            </section>

            <section class="faq-item" id="faq4">
                <button class="faq-question">
                    <i class="fas fa-trash-alt"></i>
                    Como excluir minha conta permanentemente?
                    <span class="icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Para excluir sua conta:</p>
                    <ol>
                        <li>Acesse "Configurações da Conta"</li>
                        <li>Role até a seção "Excluir Conta"</li>
                        <li>Digite sua senha para confirmar</li>
                        <li>Clique em "Excluir Conta Permanentemente"</li>
                    </ol>
                    <p><i class="fas fa-exclamation-triangle"></i> Atenção: Esta ação é irreversível.</p>
                </div>
            </section>

            <section class="contact-section">
                <h2>Precisa de mais ajuda?</h2>
                <p class="contact-info">Entre em contato conosco pelo e-mail: <a href="mailto:suporteDasPaginas@gmail.com">suporteDasPaginas@gmail.com</a></p>
            </section>
        </main>

        <footer class="main-footer">
            <p>&copy; <?php echo date("Y"); ?> Além das Páginas. Todos os direitos reservados.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questions = document.querySelectorAll('.faq-question');
            
            questions.forEach(question => {
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const icon = this.querySelector('.icon i');
                    
                    // Alternar a classe active na resposta
                    answer.classList.toggle('active');
                    
                    // Alternar ícone
                    if (answer.classList.contains('active')) {
                        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                    } else {
                        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                    }
                });
            });
        });
    </script>
</body>
</html>