<?php
require_once __DIR__ . '/functions.php';

$products = get_products();
if (isset($_GET['remove'])) {
    remove_from_cart((int) $_GET['remove']);
    header('Location: cart.php?removed=1');
    exit;
}
if (isset($_GET['clear'])) {
    clear_cart();
    header('Location: cart.php?cleared=1');
    exit;
}

$cart = get_cart();
$cartCount = cart_count();
$total = cart_total();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Seu carrinho — Vértice</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="cart.css?v=1">
</head>
<body class="cart-body">
    <header class="cart-top">
        <div class="cart-container">
            <a class="brand" href="index.php"><b>V</b><span>vértice</span></a>
            <a class="continue-link" href="index.php">Continuar comprando</a>
        </div>
    </header>

    <?php if (isset($_GET['removed'])): ?><div class="cart-notice">Produto removido do carrinho.</div><?php endif; ?>
    <?php if (isset($_GET['cleared'])): ?><div class="cart-notice">Carrinho limpo com sucesso.</div><?php endif; ?>

    <main class="cart-main">
        <div class="cart-container">
            <div class="cart-heading">
                <div>
                    <p class="eyebrow">SEU PEDIDO</p>
                    <h1>Meu carrinho</h1>
                </div>
                <span><?php echo $cartCount; ?> <?php echo $cartCount === 1 ? 'item' : 'itens'; ?> selecionados</span>
            </div>

            <?php if (empty($cart)): ?>
                <section class="empty-cart">
                    <div class="empty-icon"><img src="assets/cart-icon.svg" alt=""></div>
                    <h2>Seu carrinho está vazio.</h2>
                    <p>Escolha as peças que combinam com você e elas aparecerão aqui.</p>
                    <a class="button" href="index.php">Explorar produtos <span>→</span></a>
                </section>
            <?php else: ?>
                <div class="cart-layout">
                    <section class="cart-items">
                        <?php foreach ($cart as $id => $qty):
                            if (!isset($products[$id])) continue;
                            $product = $products[$id];
                        ?>
                        <article class="cart-item">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <div>
                                <small><?php echo htmlspecialchars($product['category']); ?></small>
                                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                                <p>Quantidade: <?php echo $qty; ?></p>
                                <p>Disponível em estoque: <?php echo $product['stock']; ?></p>
                            </div>
                            <div class="cart-item-actions">
                                <strong>R$ <?php echo number_format($product['price'] * $qty, 2, ',', '.'); ?></strong>
                                <a class="remove-link" href="cart.php?remove=<?php echo $product['id']; ?>">Remover</a>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </section>

                    <aside class="cart-summary">
                        <div class="summary-box">
                            <h3>Resumo do pedido</h3>
                            <div class="summary-row"><span>Produtos</span><strong><?php echo $cartCount; ?> itens</strong></div>
                            <div class="summary-row"><span>Entrega</span><strong>A calcular</strong></div>
                            <div class="summary-total"><span>Total</span><strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong></div>
                            <a class="checkout-button" href="checkout.php">Finalizar compra <span>→</span></a>
                            <a class="clear-link" href="cart.php?clear=1">Limpar carrinho</a>
                            <div class="cart-assurances"><span>Pagamento seguro</span><span>Troca fácil em até 30 dias</span></div>
                        </div>
                    </aside>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
