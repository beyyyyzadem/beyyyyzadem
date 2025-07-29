<?php
session_start();
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($product_id < 1 || $quantity < 1) {
        header("Location: product_detail.php?id=" . $product_id);
        exit;
    }

    // Ürün bilgisi alınıyor
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header("Location: product_detail.php?id=" . $product_id);
        exit;
    }

    // Stok kontrolü
    if ($quantity > $product['stock']) {
        $_SESSION['error'] = "Yeterli stok yok.";
        header("Location: product_detail.php?id=" . $product_id);
        exit;
    }

    // Sepet dizisi oturumda yoksa oluştur
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Ürün zaten sepette varsa adedi güncelle
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'id' => $product['id'],
            'title' => $product['title'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity
        ];
    }

    $_SESSION['success'] = "Ürün sepete eklendi.";
    header("Location: cart.php");
    exit;
}
?>
