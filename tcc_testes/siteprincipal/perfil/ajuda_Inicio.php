<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Além das Pág.| Ajuda </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="ajudaInicio.css">
</head>
<body>
    <button id="btn-voltar" type="button">← Voltar ao Site Principal</button>
    <div class="main-container">
        <header class="top-header">
            <h1>Central de Ajuda</h1>
        </header>

        <nav class="help-nav" aria-label="Navegação de ajuda">
            <ul>
                <li><a href="ajuda_Inicio.php" class="active"><i class="fas fa-home"></i> Início</a></li>
                <li><a href="ajuda_Perfil.php"><i class="fas fa-user"></i> Perfil</a></li>
                <li><a href="#"><i class="fas fa-lock"></i> Privacidade</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Configurações</a></li>
            </ul>
        </nav>

        <main class="faq-content">
            <section class="faq-item" id="faq1">
                <button class="faq-question">
                    <i class="fas fa-book-open"></i>
                    Como encontrar livros no site?
                    <span class="icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Você pode explorar nossa biblioteca de várias formas:</p>
                    <ol>
                        <li><strong>Barra de busca:</strong> No topo de qualquer página, digite o título ou autor (Também utilizado para a busca de usuários)</li>
                        <li><strong>Catálogo:</strong> Acesse "Livros Cadastrados" na aba inicial</li>
                        <li><strong>Gêneros:</strong> Navegue por categorias como Romance, Ficção, etc</li>
                        <li><strong>Listas:</strong> Explore listas criadas por outros usuários</li>
                    </ol>
                    <p><i class="fas fa-lightbulb"></i> Dica: Use filtros avançados para refinar sua busca.</p>
                </div>
            </section>

            <section class="faq-item" id="faq2">
                <button class="faq-question">
                    <i class="fas fa-users"></i>
                    Como encontrar outros usuários?
                    <span class="icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Para descobrir e conectar-se com outros leitores:</p>
                    <ul>
                        <li>Use a <strong>busca</strong> na barra superior (tanto para a pesquisa de livros e usuários)</li>
                        <li>Explore os <strong>perfis</strong> que comentaram em livros que você gosta</li>
                        <li>Verifique <strong>seguidores</strong> de autores/livros que você acompanha</li>
                    </ul>
                    <p><i class="fas fa-user-plus"></i> Você pode seguir usuários para ver suas atividades.</p>
                </div>
            </section>

            <section class="faq-item" id="faq3">
                <button class="faq-question">
                    <i class="fas fa-star-half-alt"></i>
                    Onde vejo as resenhas e avaliações?
                    <span class="icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <p>As resenhas estão disponíveis em vários lugares:</p>
                    <ol>
                        <li>Na <strong>página de cada livro</strong>, abaixo da sinopse</li>
                        <li>No <strong>perfil dos usuários</strong>, na seção "Resenhas"</li>
                        <li>Na página <strong>"Resenhas"</strong> no menu principal</li>
                    </ol>
                    <p><i class="fas fa-filter"></i> Você pode ordenar resenhas por data, relevância ou avaliação.</p>
                </div>
            </section>

            <section class="faq-item" id="faq4">
                <button class="faq-question">
                    <i class="fas fa-list"></i>
                    Como funcionam as listas de livros?
                    <span class="icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <p>As listas ajudam o usuário a ter um maior conforto e organização com base no que gosta
                        e quer ler
                    </p>
                    <ul>
                        <li><strong>Listas públicas:</strong> Criadas por usuários</li>
                        <li><strong>Listas privadas:</strong> Somente você vê (ex: "Para ler em 2025") </li>
                    </ul>
                    <p>Para criar uma lista:</p>
                    <ol>
                        <li>Vá até "Minhas Listas" ao clicar na foto de seu perfil</li>
                        <li>Clique em "Criar nova lista"</li>
                        <li>Adicione um título, descrição e livros que deseja ler, ou que tem interesse e etc</li>
                        <li>Escolha se será pública ou privada</li>
                    </ol>
                </div>
            </section>

            <section class="faq-item" id="faq5">
                <button class="faq-question">
                    <i class="fas fa-bell"></i>
                    Como receber notificações tanto seja de curtidas, seguidores e comentários novos?
                    <span class="icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <p>Configure suas preferências de notificação:</p>
                    <ol>
                        <li>Acesse "Configurações" > "Notificações"</li>
                        <li>Marque as opções desejadas:
                            <ul>
                                <li>Novos seguidores</li>
                                <li>Curtidas nas Resenhas</li>
                                <li>Novos comentários</li>
                            </ul>
                        </li>
                        <li>Salve suas preferências</li>
                    </ol>
                    <p><i class="fas fa-envelope"></i> Você pode ajustar a frequência das notificações.</p>
                </div>
            </section>

            <section class="contact-section">
                <h2>Não encontrou o que precisava?</h2>
                <p class="contact-info">Entre em contato conosco: <a href="mailto:suporteDasPaginas@gmail.com">SuporteDasPaginas@gmail.co</a></p>
            </section>
        </main>

        <footer class="main-footer">
            <p>&copy; <?php echo date("Y"); ?> Além das Páginas. Todos os direitos reservados.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questions = document.querySelectorAll('.faq-question');
            const btnVoltar = document.getElementById("btn-voltar");
            if (btnVoltar) {
            btnVoltar.addEventListener("click", () => {
            window.location.href = "../site_livros.php";
            });
            }
            
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