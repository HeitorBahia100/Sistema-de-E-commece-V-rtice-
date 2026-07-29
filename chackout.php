<?php
require_once __DIR__ . '/functions.php';
$products = get_products();
$cart = get_cart();
$cartCount = cart_count();
$total = cart_total();
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Escolha a forma de pagamento — Vértice</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container" style="max-width:800px;margin:40px auto;">
        <a href="cart.php">← Voltar ao carrinho</a>
        <h1>Finalizar compra</h1>
        <p>Itens no carrinho: <?php echo $cartCount; ?> — Total: <strong>R$ <?php echo number_format($total,2,',','.'); ?></strong></p>

        <form method="post" action="checkout_success.php">
            <fieldset>
                <legend>Escolha a forma de pagamento</legend>
                <label><input type="radio" name="payment" value="credit_card" required> Cartão de crédito</label><br>
                <label><input type="radio" name="payment" value="boleto"> Boleto bancário</label><br>
                <label><input type="radio" name="payment" value="pix"> Pix</label>
            </fieldset>
            <p style="margin-top:20px;"><button type="submit" class="button">Confirmar pagamento e finalizar</button></p>
        </form>
    </div>
</body>
</html>
