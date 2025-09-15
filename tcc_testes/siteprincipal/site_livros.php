<?php
ini_set('session.cookie_path', '/'); // Sessão válida em todo o site
session_start();
include('conexaobanco.php');

// Recupera nome de exibição do usuário, se estiver logado
$nomeExibicao = '';
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conn->prepare("SELECT nome_exibicao, foto_perfil FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($nomeExibicao, $fotoPerfil);
    $stmt->fetch();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Além das Pág.</title>

    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Sacramento&family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Miniver&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Miniver&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleprincipal.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="site_livros.php">Menu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="dicas-de-livros.html">Dicas</a></li>
                    <li class="nav-item"><a class="nav-link" href="resenhas.php">Criar Resenha</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorias
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="generos/romance.php">Romance</a></li>
                            <li><a class="dropdown-item" href="generos/suspense.php">Suspense</a></li>
                            <li><a class="dropdown-item" href="generos/poesia.php">Poesia</a></li>
                            <li><a class="dropdown-item" href="generos/fantasia.php">Fantasia</a></li>
                            <li><a class="dropdown-item" href="generos/ficientifica.php">Ficção Científica</a></li>
                            <li><a class="dropdown-item" href="generos/biografia.php">Biografia</a></li>
                            <li><a class="dropdown-item" href="generos/autoajuda.php">Autoajuda</a></li>
                            <li><a class="dropdown-item" href="generos/aventura.php">Aventura</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="add_Livro.php">Adicionar Livro</a></li>
                    <li class="nav-item"><a class="nav-link" href="func_livros.php">Livros Cadastrados</a></li>
                    <li class="nav-item"><a class="nav-link" href="Func_Res.php">Resenhas</a></li>
                </ul>

                <!-- Campo de busca + perfil -->
                <div class="d-flex align-items-center">
                    <form class="d-flex me-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>

                    <?php if (!empty($nomeExibicao)): ?>
                        <!-- Perfil do usuário logado -->
                        <div class="hero position-relative">
                            <img src="data:image/jpeg;base64,<?= base64_encode($fotoPerfil) ?>" class="user-pic" onclick="toggleMenu()" title="Perfil">

                            <div class="sub-menu-wrap" id="subMenu">
                                <div class="sub-menu">
                                    <div class="user-info">
                                        <img src="data:image/jpeg;base64,<?= base64_encode($fotoPerfil) ?>" class="user-pic">
                                        <h3><?= htmlspecialchars($nomeExibicao) ?></h3>
                                    </div>
                                    <hr>

                                    <a href="../siteprincipal/perfil/view_Perfil.php" class="sub-menu-link">
                                    <i class="fas fa-user-circle"></i>
                                    <p>Perfil</p>
                                    <span>›</span>
                                </a>

                                <a href="../siteprincipal/perfil/config_Perfil.php" class="sub-menu-link">
                                    <i class="fas fa-cog"></i>
                                    <p>Configurações</p>
                                    <span>›</span>
                                </a>

                                <a href="../siteprincipal/perfil/ajuda_Inicio.php" class="sub-menu-link">
                                    <i class="fas fa-question-circle"></i>
                                    <p>Ajuda</p>
                                    <span>›</span>
                                </a>

                                <a href="minha_Lista.php" class="sub-menu-link">
                                    <i class="fas fa-bookmark"></i>
                                    <p>Minhas Listas</p>
                                    <span>›</span>
                                </a>

                                <a href="../siteprincipal/perfil/logoutperfil.php" class="sub-menu-link">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <p>Sair</p>
                                    <span>›</span>
                                </a>
        

                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Caso não esteja logado -->
                        <a href="../login.php" class="btn btn-outline-secondary ms-2" title="Fazer Login">
                            <i class="fas fa-sign-in-alt"></i> Entrar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <header>
        <h1>Além das Páginas</h1>
    </header>

    <main>
        <section>
            <h2>Bem-vindo ao seu novo refúgio literário</h2>
            <br>
            <p>Olá, leitoras e leitores.</p>
            <p>Você acaba de cruzar a fronteira entre o real e o imaginário. Este espaço não é apenas sobre livros — é sobre experiências. Aqui, as histórias não se leem apenas com os olhos, mas se vivem com a alma.

              Cada clique é um passo rumo ao seu próprio universo literário.</p>
        </section>

    <section class="literary-terms">
  <h1>Você já ouviu falar em...</h1>

  <div class="term">
    <input type="checkbox" id="ressaca-literaria">
    <label for="ressaca-literaria">Ressaca literária</label>
    <p>
      É aquele sentimento de vazio que aparece depois de terminar um livro muito marcante. Você se envolve tanto 
      com a história, os personagens e o universo narrativo, que sente que nada mais vai superar aquilo. Por isso, 
      é difícil começar outra leitura logo em seguida. Pode durar dias ou até semanas. Durante a ressaca, 
      leitores geralmente ficam pensando no enredo, revivendo cenas ou relendo trechos favoritos. 
      É um sinal de que o livro realmente impactou você. Embora incômoda, é uma experiência quase universal entre 
      leitores assíduos. Um bom livro pode curar essa fase.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="plot-twist">
    <label for="plot-twist">Plot twist</label>
    <p>
      É uma reviravolta inesperada no enredo, geralmente no momento em que o leitor menos espera. Esse recurso 
      é usado para surpreender, chocar ou mudar totalmente a direção da história. Pode revelar que um personagem
       era vilão, que algo visto como verdade era mentira ou que tudo foi um sonho, por exemplo. Um bom plot twist
        muda a perspectiva do leitor sobre tudo que leu até ali. Para funcionar bem, ele precisa fazer sentido 
        dentro da narrativa e não parecer forçado. Um plot twist bem construído pode transformar um livro comum
         em inesquecível.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="prologo">
    <label for="prologo">Prólogo</label>
    <p>
      O prólogo é a introdução da história, uma parte inicial que ocorre antes do evento principal do livro. 
      Ele pode servir para apresentar um contexto importante, uma cena do passado, ou até um mistério que será 
      desenvolvido depois. Nem toda história tem prólogo, mas quando tem, ele ajuda a preparar o leitor para o que 
      virá, estabelecendo o tom ou o cenário. Muitas vezes, o prólogo funciona para criar curiosidade e prender o 
      interesse logo no começo da leitura.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="epilogo">
    <label for="epilogo">Epílogo</label>
    <p>
      O epílogo é a parte final do livro, que ocorre depois dos eventos principais da história. Ele mostra o que 
      aconteceu com os personagens depois do clímax, resolvendo pontas soltas ou dando uma visão do futuro. Serve 
      para dar uma sensação de fechamento para o leitor e pode ser usado para sugerir novas histórias ou continuar 
      a narrativa em uma sequência. Diferente do final tradicional, o epílogo traz detalhes adicionais que 
      enriquecem a conclusão.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="antagonista">
    <label for="antagonista">Antagonista</label>
    <p>
      O antagonista é o personagem que cria o conflito principal da história ao se opor ao protagonista. 
      Ele pode ser um vilão, uma força da natureza, ou até mesmo uma ideia contrária. Seu papel é fundamental 
      para gerar tensão e drama, pois é a partir dessa oposição que a trama se desenvolve. Um antagonista bem 
      construído torna a história mais rica, já que desafia o herói e testa suas habilidades, crenças e motivações.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="enemies-to-lovers">
    <label for="enemies-to-lovers">Enemies to Lovers</label>
    <p>
      É um trope narrativo muito popular em romances, onde dois personagens que começam se odiando profundamente 
      acabam se apaixonando. Essa dinâmica cria muita tensão e conflito emocional, já que o ódio inicial esconde 
      sentimentos mais profundos que vão se revelar ao longo da história. A transição do antagonismo para o amor 
      proporciona momentos intensos, engraçados e emocionantes para o leitor.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="friends-to-lovers">
    <label for="friends-to-lovers">Friends to Lovers</label>
    <p>
      Neste trope, dois amigos de longa data percebem que seus sentimentos ultrapassam a amizade e se apaixonam. 
      A história geralmente foca no desenvolvimento dessa descoberta e na adaptação para essa nova relação. É um 
      tema querido porque traz uma sensação de segurança e confiança pré-existente, além de mostrar o valor da 
      amizade como base para o amor.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="grumpy-sunshine">
    <label for="grumpy-sunshine">Grumpy Sunshine</label>
    <p>
      Este trope apresenta dois personagens com personalidades opostas: um é rabugento, mal-humorado (grumpy) e o 
      outro é alegre, otimista e cheio de energia (sunshine). A interação entre esses dois cria um contraste 
      divertido e muitas vezes comovente, pois cada um influencia e transforma o outro, resultando em crescimento 
      pessoal e um relacionamento especial.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="chosen-one">
    <label for="chosen-one">Chosen One</label>
    <p>
      É o personagem principal que foi escolhido ou destinado a cumprir uma missão importante, muitas vezes para 
      salvar o mundo ou mudar o destino. Esse arquétipo é comum em histórias de fantasia e aventura. Geralmente, 
      o escolhido enfrenta grandes desafios e precisa superar dificuldades para alcançar seu propósito, 
      muitas vezes descobrindo sua verdadeira força e identidade ao longo da jornada.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="slow-burn">
    <label for="slow-burn">Slow Burn</label>
    <p>
      Slow burn é um tipo de relacionamento romântico que se desenvolve lentamente, capítulo após capítulo, com 
      muita tensão, olhares, trocas de palavras, mas sem pressa. A construção cuidadosa faz o momento da união 
      final ser muito mais impactante, pois o leitor se envolve profundamente na evolução dos personagens e 
      seus sentimentos. É um dos estilos favoritos para quem gosta de romance mais realista e emocional.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="triangulo-amoroso">
    <label for="triangulo-amoroso">Triângulo amoroso</label>
    <p>
      O triângulo amoroso envolve três personagens onde dois disputam o amor de um terceiro. Esse tipo de 
      conflito cria muita tensão, drama e dilemas emocionais. Os personagens precisam lidar com ciúmes, escolhas 
      difíceis e sentimentos contraditórios. É um recurso clássico que gera interesse e mantém o leitor na 
      expectativa sobre quem o protagonista vai escolher no final.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="fake-dating">
    <label for="fake-dating">Fake dating</label>
    <p>
      Fake dating é um trope onde dois personagens fingem estar em um relacionamento por alguma razão 
      prática — para enganar outras pessoas, ganhar vantagem, ou resolver um problema. Porém, essa farsa 
      costuma evoluir para um romance verdadeiro, com muita química, descobertas e momentos engraçados. 
      É um enredo divertido e muito popular em romances contemporâneos.
    </p>
  </div>

  <div class="term">
    <input type="checkbox" id="dual-pov">
    <label for="dual-pov">Dual POV (Ponto de vista duplo)</label>
    <p>
      É quando a narrativa alterna entre dois protagonistas — geralmente em romances — mostrando a história 
      sob a perspectiva de cada um, em capítulos intercalados. Isso ajuda o leitor a entender os sentimentos, 
      pensamentos e motivações dos dois personagens de forma mais profunda, criando uma conexão maior e uma visão
       mais completa dos eventos.
    </p>
  </div>
</section>
<br><br><br>
  
<section>
    <div class="quiz">  
    <p>Chegou a hora de atravessar o portal. Qual gênero vai conquistar seu coração? </p>
    <h4>Aventura mágica, romance cheio de charme ou suspense que prende? Venha descobrir!</h4>

    <br><br><br>
<iframe 
    src="https://quiz-de-g-nero--averagegrass2866494.on.websim.ai/?v=17" 
    width="100%" 
    height="1500" 
    style="border:none;">
</iframe>
</div>
  
</section>   


       
    </main>

    <footer>
        <p>&copy; 2025 Meu Site de Livros</p>
    </footer>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>

    <!-- Bootstrap Bundle com Popper.js (necessário para dropdown funcionar) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
