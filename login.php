<?php
require_once __DIR__ . '/auth.php';
if (current_user()) { header('Location: index.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (login_user($_POST['email'] ?? '', $_POST['password'] ?? '')) { header('Location: index.php'); exit; }
    $error = 'E-mail ou senha incorretos.';
}
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Entrar — Vértice</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet"><link rel="stylesheet" href="styles.css?v=3"><link rel="stylesheet" href="auth.css?v=3"></head>
<body class="auth-page"><a class="auth-logo brand" href="index.php"><b>V</b><span>vértice</span></a><div class="auth-decoration one"></div><div class="auth-decoration two"></div><main class="auth-card"><div class="card-top"><span class="card-icon">↗</span><p class="eyebrow">BEM-VINDO DE VOLTA</p><h1>Entre na sua<br><em>conta.</em></h1><p class="auth-subtitle">Acompanhe seus pedidos e descubra seleções feitas para você.</p></div><?php if ($error): ?><div class="form-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?><form method="post" class="auth-form"><label><span>Seu e-mail</span><input required type="email" name="email" placeholder="voce@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"></label><label><span>Sua senha</span><input required type="password" name="password" placeholder="Digite sua senha"></label><div class="form-options"><label><input type="checkbox"> <span>Lembrar de mim</span></label><a href="#">Esqueci minha senha</a></div><button class="button" type="submit">Entrar na conta <span>→</span></button></form><div class="auth-divider"><span>ou</span></div><p class="auth-switch">Ainda não tem uma conta? <a href="register.php">Criar conta grátis</a></p></main><p class="auth-foot">© 2026 Vértice · Moda que acompanha você</p></body></html>
