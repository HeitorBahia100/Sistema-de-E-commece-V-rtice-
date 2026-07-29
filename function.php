<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/products.php';

function get_cart(): array {
    return $_SESSION['cart'] ?? [];
}

function add_to_cart(int $id, int $qty = 1): void {
    $products = get_products();
    if (!isset($products[$id])) {
        return;
    }

    if ($products[$id]['stock'] < 1) {
        return;
    }

    $cart = get_cart();
    if (isset($cart[$id])) {
        $cart[$id] = min($cart[$id] + $qty, $products[$id]['stock']);
    } else {
        $cart[$id] = min($qty, $products[$id]['stock']);
    }
    $_SESSION['cart'] = $cart;
}

function remove_from_cart(int $id): void {
    $cart = get_cart();
    if (isset($cart[$id])) {
        unset($cart[$id]);
        $_SESSION['cart'] = $cart;
    }
}

function clear_cart(): void {
    unset($_SESSION['cart']);
}

function cart_count(): int {
    return array_sum(get_cart());
}

function cart_total(): float {
    $total = 0;
    $products = get_products();
    foreach (get_cart() as $id => $qty) {
        if (isset($products[$id])) {
            $total += $products[$id]['price'] * $qty;
        }
    }
    return $total;
}
