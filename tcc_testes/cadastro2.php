<?php
session_start();
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    $tipo = $msg['tipo']; // 'erro' ou 'sucesso'
    $texto = $msg['texto'];
    // Apaga a mensagem para não aparecer novamente
    unset($_SESSION['msg']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="stylesscadastro.css">
    <title>Cadastro</title>
</head>
<body>
    <main id="form_container">
        <?php if (!empty($texto)): ?>
            <div class="msg <?= htmlspecialchars($tipo) ?>">
                <?= htmlspecialchars($texto) ?>
            </div>
        <?php endif; ?>

        <div id="form_header">
            <h1 id="form_title">
              Cadastro
            </h1>
            <form action="login.php" method="post">
            <button class="btn-default-exit">
            <i class="fa-solid fa-right-to-bracket"></i>
            </button>
            </form>
        </div>
        <form action="cadastro.php" method="post">
            <div id="input_container">
                <div class="input-box">
                    <label 
                        for="name" 
                        class="form-label"
                    >
                        Nome de usuário
                    </label>
                    <div class="input-field">
                        <input 
                            type="text"
                            name="name_user"
                            id="name_user"
                            class="form-control"
                            placeholder="Digite seu Nome de usuário"
                        required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                        <?php
                        // mensagem embaixo do campo
                        if (isset($_SESSION['erro_nome_usuario'])) {
                        echo '<div class="erro"><span class="erro-icon">!</span>' . htmlspecialchars($_SESSION['erro_nome_usuario']) . '</div>';
                        unset($_SESSION['erro_nome_usuario']);
                        }
                    ?>
                </div>

                <div class="input-box">
                    <label 
                        for="last_name" 
                        class="form-label"
                    >
                       Nome de Exibição
                    </label>
                    <div class="input-field">
                        <input 
                            type="text"
                            name="name_exibir"
                            id="name_exibir"
                            class="form-control"
                            placeholder="Digite seu Nome de Exibição"
                        required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>

                <div class="input-box">
                    <label 
                        for="birthdate" 
                        class="form-label"
                    >
                        Nascimento
                    </label>
                    <div class="input-field">
                        <input 
                            type="date"
                            name="birthdate"
                            id="birthdate"
                            class="form-control"
                        required>
                    </div>
                </div>

                <div class="input-box">
                    <label 
                        for="email" 
                        class="form-label"
                    >
                        E-mail
                    </label>
                    <div class="input-field">
                        <input 
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            placeholder="exemplo@gmail.com"
                        required>
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                        <?php
                        // mensagem embaixo do campo
                        if (isset($_SESSION['erro_email'])) {
                        echo '<div class="erro"><span class="erro-icon">!</span>' . htmlspecialchars($_SESSION['erro_email']) . '</div>';
                        unset($_SESSION['erro_email']);
                        }
                    ?>
                </div>

                <div class="input-box">
                    <label 
                        for="password" 
                        class="form-label"
                    >
                        Senha
                    </label>
                    <div class="input-field">
                        <input 
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="******"
                            minlength="6"
                        required>
                        <i class="fa-regular fa-eye-slash password-icon"></i>
                    </div>
                </div>

                <div class="input-box">
                    <label 
                        for="confirm_password" 
                        class="form-label"
                    >
                        Confirmar senha
                    </label>
                    <div class="input-field">
                        <input 
                            type="password"
                            name="confirm_password"
                            id="confirm_password"
                            class="form-control"
                            placeholder="*******"
                            minlength="6"
                        required>
                        <i class="fa-regular fa-eye-slash password-icon"></i>
                    </div>
                    <?php
                        if (isset($_SESSION['erro_confirm_password'])) {
                            echo '<div class="erro"><span class="erro-icon">!</span>' . htmlspecialchars($_SESSION['erro_confirm_password']) . '</div>';
                            unset($_SESSION['erro_confirm_password']);
                        }
                    ?>
                </div>

                <div class="radio-container">
                    <label class="form-label">
                        Gênero
                    </label>

                    <div id="gender_inputs">
                        <div class="radio-box">
                            <input 
                                type="radio"
                                name="gender"
                                id="female"
                                class="form-control"
                                value="female"
                            required>
                            <label 
                                for="female" 
                                class="form-label"
                            >
                                Feminino
                            </label>
                        </div>

                        <div class="radio-box">
                            <input 
                                type="radio"
                                name="gender"
                                id="male"
                                class="form-control"
                                value="male"
                            required>
                            <label 
                                for="male" 
                                class="form-label"
                            >
                                Masculino
                            </label>
                        </div>

                        <div class="radio-box">
                            <input 
                                type="radio"
                                name="gender"
                                id="other"
                                class="form-control"
                                value="other"
                            required>
                            <label 
                                for="other" 
                                class="form-label"
                            >
                                Outro
                            </label>
                        </div>
                    </div>


                </div>
            </div>

            <button type="submit" class="btn-default">
                <i class="fa-solid fa-check"></i>
                Criar conta
            </button>
        </form>
    </main>

    <script src="script.js"></script>
</body>
</html>

