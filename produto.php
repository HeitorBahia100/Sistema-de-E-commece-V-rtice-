<?php

require_once __DIR__ . '/functions.php';

$products = get_products();

$id = (int) ($_GET['id'] ?? 0);

/*
 * Verifica se o produto existe.
 */
if (!isset($products[$id])) {
    http_response_code(404);
    exit('Produto não encontrado.');
}

$product = $products[$id];


/*
 * Processa a adição do produto ao carrinho.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $quantity = max(
        1,
        min(
            (int) ($_POST['quantity'] ?? 1),
            $product['stock']
        )
    );

    add_to_cart($id, $quantity);

    /*
     * Se o usuário clicar em "Comprar agora",
     * será direcionado para o carrinho.
     *
     * Caso contrário, permanece na página do produto.
     */
    $action = $_POST['action'] ?? '';

    if ($action === 'buy') {
        header('Location: cart.php');
    } else {
        header(
            'Location: product.php?id=' . $id . '&added=1'
        );
    }

    exit;
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

    <title>
        <?php echo htmlspecialchars($product['name']); ?> — Vértice
    </title>


    <!-- Fontes -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >


    <!-- CSS -->

    <link
        rel="stylesheet"
        href="styles.css"
    >

    <link
        rel="stylesheet"
        href="product.css?v=1"
    >

</head>


<body class="product-page">


    <!-- =====================================================
         HEADER
         ===================================================== -->

    <header class="product-header">

        <a
            class="brand"
            href="index.php"
        >
            <b>V</b>
            <span>vértice</span>
        </a>


        <a
            href="cart.php"
            class="product-cart"
        >
            Ver carrinho

            <img
                src="assets/cart-icon.svg"
                alt="Carrinho"
            >

            <small>
                <?php echo cart_count(); ?>
            </small>

        </a>

    </header>


    <!-- =====================================================
         CONTEÚDO PRINCIPAL
         ===================================================== -->

    <main class="product-main">


        <!-- Voltar para produtos -->

        <a
            class="back-link"
            href="index.php#ofertas"
        >
            ← Voltar para produtos
        </a>


        <!-- =================================================
             MENSAGEM DE PRODUTO ADICIONADO
             ================================================= -->

        <?php if (isset($_GET['added'])): ?>

            <div class="product-notice">

                Produto adicionado ao carrinho.

                <a href="cart.php">
                    Ver carrinho →
                </a>

            </div>

        <?php endif; ?>


        <!-- =================================================
             DETALHES DO PRODUTO
             ================================================= -->

        <section class="product-detail">


            <!-- Imagem -->

            <div class="detail-image">

                <img
                    src="<?php echo htmlspecialchars($product['image']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                >


                <!-- Desconto -->

                <?php if ($product['old_price'] > $product['price']): ?>

                    <span>
                        -<?php
                            echo (int) round(
                                (1 - $product['price'] / $product['old_price']) * 100
                            );
                        ?>%
                    </span>

                <?php endif; ?>

            </div>


            <!-- =================================================
                 INFORMAÇÕES DO PRODUTO
                 ================================================= -->

            <div class="detail-info">


                <!-- Categoria -->

                <p class="eyebrow">
                    <?php echo htmlspecialchars($product['category']); ?>
                </p>


                <!-- Nome -->

                <h1>
                    <?php echo htmlspecialchars($product['name']); ?>
                </h1>


                <!-- Descrição -->

                <p class="detail-description">
                    <?php echo htmlspecialchars($product['description']); ?>
                </p>


                <!-- =================================================
                     PREÇO
                     ================================================= -->

                <div class="detail-price">

                    <strong>
                        R$
                        <?php
                            echo number_format(
                                $product['price'],
                                2,
                                ',',
                                '.'
                            );
                        ?>
                    </strong>


                    <?php if ($product['old_price'] > $product['price']): ?>

                        <del>
                            R$
                            <?php
                                echo number_format(
                                    $product['old_price'],
                                    2,
                                    ',',
                                    '.'
                                );
                            ?>
                        </del>

                    <?php endif; ?>

                </div>


                <!-- Parcelamento -->

                <p class="installments">
                    ou em até 6x de R$
                    <?php
                        echo number_format(
                            $product['price'] / 6,
                            2,
                            ',',
                            '.'
                        );
                    ?>
                    sem juros
                </p>


                <!-- =================================================
                     ESTOQUE
                     ================================================= -->

                <?php if ($product['stock'] > 0): ?>

                    <form method="post">


                        <!-- Quantidade -->

                        <label class="quantity-label">

                            Quantidade

                            <select name="quantity">

                                <?php
                                for (
                                    $i = 1;
                                    $i <= min(10, $product['stock']);
                                    $i++
                                ):
                                ?>

                                    <option value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </option>

                                <?php endfor; ?>

                            </select>


                            <span>
                                <?php echo $product['stock']; ?>
                                disponíveis
                            </span>

                        </label>


                        <!-- =================================================
                             AÇÕES
                             ================================================= -->

                        <div class="product-actions">

                            <button
                                name="action"
                                value="add"
                                class="outline-button"
                                type="submit"
                            >
                                Adicionar ao carrinho
                            </button>


                            <button
                                name="action"
                                value="buy"
                                class="buy-button"
                                type="submit"
                            >
                                Comprar agora

                                <span>→</span>

                            </button>

                        </div>

                    </form>


                <?php else: ?>


                    <!-- Produto sem estoque -->

                    <p class="out-of-stock">
                        Produto indisponível no momento.
                    </p>


                <?php endif; ?>


                <!-- =================================================
                     BENEFÍCIOS
                     ================================================= -->

                <div class="detail-benefits">

                    <span>
                        ✓ Envio para todo o Brasil
                    </span>

                    <span>
                        ✓ Troca fácil em até 30 dias
                    </span>

                </div>

            </div>

        </section>

    </main>

</body>

</html>
