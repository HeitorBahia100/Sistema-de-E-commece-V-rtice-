<?php
require_once __DIR__ . '/auth.php';
$products = get_products();
if (isset($_GET['add'])) { add_to_cart((int) $_GET['add']); header('Location: index.php?added=1#ofertas'); exit; }
$cartItems = cart_count();
$user = current_user();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vértice — Moda que acompanha você</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="navigation.css?v=1">
    <link rel="stylesheet" href="store.css?v=1">
</head>
<body>
    <div class="topbar"><div class="container"><span>Frete grátis para compras acima de R$ 199</span><span>Até 6x sem juros · Troca fácil em 30 dias</span></div></div>
    <header class="main-header">
        <div class="container header-row">
            <a class="brand" href="index.php"><b>V</b><span>vértice</span></a>
            <label class="search"><span>⌕</span><input type="search" placeholder="O que você está procurando?"></label>
            <nav class="header-actions"><a href="#ofertas" aria-label="Favoritos">♡</a><?php if ($user): ?><?php if (is_owner()): ?><a class="account-link" href="admin.php">Painel</a><?php endif; ?><a class="account-name" href="logout.php" title="Sair da conta">Olá, <?php echo htmlspecialchars(explode(' ', $user['name'])[0]); ?></a><?php else: ?><a class="account-link" href="login.php">Entrar</a><?php endif; ?><a href="cart.php" class="cart" aria-label="Carrinho"><img src="assets/cart-icon.svg" alt="Carrinho"><small><?php echo $cartItems; ?></small></a></nav>
        </div>
        <div class="nav-wrap"><nav class="container menu"><a href="#ofertas">Novidades</a><div class="menu-item"><button type="button">Feminino</button><div class="submenu"><a href="#ofertas">Camisas</a><a href="#ofertas">Camisetas</a><a href="#ofertas">Shorts</a><a href="#ofertas">Calças</a><a href="#ofertas">Calcinhas</a></div></div><div class="menu-item"><button type="button">Masculino</button><div class="submenu"><a href="#ofertas">Camisas</a><a href="#ofertas">Camisetas</a><a href="#ofertas">Shorts</a><a href="#ofertas">Calças</a><a href="#ofertas">Cuecas</a></div></div><div class="menu-item"><button type="button">Acessórios</button><div class="submenu"><a href="#ofertas">Bolsas</a><a href="#ofertas">Mochilas</a><a href="#ofertas">Cintos</a><a href="#ofertas">Bonés e chapéus</a><a href="#ofertas">Óculos</a><a href="#ofertas">Relógios</a></div></div><div class="menu-item"><button type="button">Calçados</button><div class="submenu"><a href="#ofertas">Tênis</a><a href="#ofertas">Sandálias</a><a href="#ofertas">Chinelos</a><a href="#ofertas">Sapatos</a><a href="#ofertas">Botas</a></div></div><a class="sale" href="#ofertas">Sale</a></nav></div>
    </header>
    <main>
        <?php if (isset($_GET['added'])): ?><div class="notice">Produto adicionado ao carrinho. <a href="cart.php">Ver carrinho →</a></div><?php endif; ?>
        <?php if (isset($_GET['welcome'])): ?><div class="notice">Sua conta foi criada. Boas-vindas à Vértice!</div><?php endif; ?>
        <section class="hero container">
            <div class="hero-copy"><p class="eyebrow">COLEÇÃO OUTONO · 2026</p><h1>Vista a sua<br><em>melhor versão.</em></h1><p>Peças autorais para deixar sua rotina mais leve, bonita e cheia de personalidade.</p><a class="button" href="#ofertas">Comprar agora <span>→</span></a></div>
            <div class="hero-image"><img src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1200&q=90" alt="Modelo usando roupas da nova coleção"><div class="hero-stamp"><strong>nova</strong><span>coleção</span></div></div>
        </section>
        <section class="container promos"><a class="promo coral" href="#ofertas"><span>Essenciais</span><strong>Casacos<br>com até 30% off</strong><i>VER PEÇAS →</i></a><a class="promo navy" href="#ofertas"><span>Para levar</span><strong>Bolsas que<br>contam histórias</strong><i>VER PEÇAS →</i></a><a class="promo sand" href="#ofertas"><span>Passos leves</span><strong>Calçados para<br>todo caminho</strong><i>VER PEÇAS →</i></a></section>
        <section class="benefits"><div class="container"><div><b>♧</b><p><strong>Compra segura</strong><span>Seus dados protegidos</span></p></div><div><b>▧</b><p><strong>Entrega para todo Brasil</strong><span>Rastreie seu pedido</span></p></div><div><b>♙</b><p><strong>Troca descomplicada</strong><span>Até 30 dias para trocar</span></p></div></div></section>
        <section class="container products" id="ofertas"><div class="section-heading"><div><p class="eyebrow">ESCOLHIDOS PARA VOCÊ</p><h2>Ofertas da semana</h2></div><a href="#ofertas">Ver todos →</a></div><div class="product-grid"><?php foreach ($products as $product): ?><article class="product-card"><a class="product-photo" href="product.php?id=<?php echo $product['id']; ?>"><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"><?php if ($product['old_price'] > $product['price']): ?><span>-<?php echo (int) round((1 - $product['price'] / $product['old_price']) * 100); ?>%</span><?php endif; ?></a><div class="product-info"><p><?php echo htmlspecialchars($product['category']); ?></p><h3><a href="product.php?id=<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></a></h3><div><strong>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></strong><?php if ($product['old_price'] > $product['price']): ?><del>R$ <?php echo number_format($product['old_price'], 2, ',', '.'); ?></del><?php endif; ?></div><a class="add" href="?add=<?php echo $product['id']; ?>">Adicionar <span>+</span></a></div></article><?php endforeach; ?></div></section>
        <section class="newsletter"><div class="container"><div><p class="eyebrow">CLUBE VÉRTICE</p><h2>Um pouco de estilo<br>na sua caixa de entrada.</h2></div><form><input type="email" placeholder="Seu melhor e-mail"><button type="button">Quero receber</button></form></div></section>
    </main>
    <footer><div class="container"><a class="brand" href="index.php"><b>V</b><span>vértice</span></a><p>Moda feita para os seus melhores momentos.</p><small>© 2026 Vértice. Todos os direitos reservados.</small></div></footer>
</body>
</html>
