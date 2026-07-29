<?php

require_once __DIR__ . '/auth.php';

/*
 * Se o usuário já estiver logado,
 * redireciona para a página inicial.
 */
if (current_user()) {
    header('Location: index.php');
    exit;
}

$error = '';


/*
 * Processa o formulário de cadastro.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';


    /*
     * Validação dos dados.
     */

    if (mb_strlen($name) < 3) {

        $error = 'Informe seu nome completo.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = 'Informe um e-mail válido.';

    } elseif (strlen($password) < 6) {

        $error = 'A senha precisa ter pelo menos 6 caracteres.';

    } elseif ($password !== $confirm) {

        $error = 'As senhas não coincidem.';

    } else {

        /*
         * Cria o usuário através da função
         * responsável pelo cadastro.
         */

        $result = create_user(
            $name,
            $email,
            $password
        );


        /*
         * Cadastro realizado com sucesso.
         */

        if ($result === true) {

            header('Location: index.php?welcome=1');
            exit;
        }


        /*
         * Caso exista algum erro no cadastro,
         * exibe a mensagem retornada pela função.
         */

        $error = $result;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Criar conta — Vértice</title>


    <!-- =====================================================
         FONTES
         ===================================================== -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         CSS
         ===================================================== -->

    <link
        rel="stylesheet"
        href="styles.css?v=3"
    >

    <link
        rel="stylesheet"
        href="auth.css?v=3"
    >

</head>


<body class="auth-page">


    <!-- =====================================================
         LOGO
         ===================================================== -->

    <a
        class="auth-logo brand"
        href="index.php"
    >
        <b>V</b>
        <span>vértice</span>
    </a>


    <!-- Elementos decorativos -->

    <div class="auth-decoration one"></div>
    <div class="auth-decoration two"></div>


    <!-- =====================================================
         FORMULÁRIO DE CADASTRO
         ===================================================== -->

    <main class="auth-card register-card">

        <div class="card-top">

            <span class="card-icon">
                ✦
            </span>

            <p class="eyebrow">
                CLUBE VÉRTICE
            </p>

            <h1>
                Seu novo<br>
                <em>começo.</em>
            </h1>

            <p class="auth-subtitle">
                Crie sua conta e viva uma experiência
                de compra ainda mais especial.
            </p>

        </div>


        <!-- =================================================
             MENSAGEM DE ERRO
             ================================================= -->

        <?php if ($error): ?>

            <div class="form-error">

                <?php echo htmlspecialchars($error); ?>

            </div>

        <?php endif; ?>


        <!-- =================================================
             FORMULÁRIO
             ================================================= -->

        <form
            method="post"
            class="auth-form"
        >


            <!-- Nome -->

            <label>

                <span>
                    Nome completo
                </span>

                <input
                    required
                    type="text"
                    name="name"
                    placeholder="Como podemos te chamar?"
                    value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                >

            </label>


            <!-- E-mail -->

            <label>

                <span>
                    Seu e-mail
                </span>

                <input
                    required
                    type="email"
                    name="email"
                    placeholder="voce@email.com"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                >

            </label>


            <!-- Senha -->

            <label>

                <span>
                    Crie uma senha
                </span>

                <input
                    required
                    type="password"
                    name="password"
                    placeholder="Mínimo de 6 caracteres"
                >

            </label>


            <!-- Confirmação da senha -->

            <label>

                <span>
                    Confirme sua senha
                </span>

                <input
                    required
                    type="password"
                    name="confirm_password"
                    placeholder="Digite novamente"
                >

            </label>


            <!-- Termos de uso -->

            <label class="terms">

                <input
                    required
                    type="checkbox"
                >

                <span>
                    Li e aceito os termos de uso e
                    a política de privacidade.
                </span>

            </label>


            <!-- Botão -->

            <button
                class="button"
                type="submit"
            >

                Criar minha conta

                <span>
                    →
                </span>

            </button>

        </form>


        <!-- =================================================
             DIVISOR
             ================================================= -->

        <div class="auth-divider">
            <span>ou</span>
        </div>


        <!-- =================================================
             LOGIN
             ================================================= -->

        <p class="auth-switch">

            Já possui uma conta?

            <a href="login.php">
                Fazer login
            </a>

        </p>

    </main>


    <!-- =====================================================
         RODAPÉ
         ===================================================== -->

    <p class="auth-foot">
        © 2026 Vértice · Moda que acompanha você
    </p>

</body>

</html>
