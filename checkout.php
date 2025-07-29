<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Sepet verilerini al
$query = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$query->execute([$user_id]);
$cart_items = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($cart_items) == 0) {
    echo "Sepetiniz boş.";
    exit;
}

// Sipariş oluştur
$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['quantity'] * $item['price'];
}

// Siparişi veritabanına kaydet
$orderQuery = $conn->prepare("INSERT INTO orders (user_id, total_price, status, created_at) VALUES (?, ?, 'hazırlanıyor', NOW())");
$orderQuery->execute([$user_id, $total_amount]);

$order_id = $conn->lastInsertId();

// Sipariş detaylarını kaydet
foreach ($cart_items as $item) {
    $detailQuery = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $detailQuery->execute([
        $order_id,
        $item['product_id'],
        $item['quantity'],
        $item['price']
    ]);

    // Stok azalt
    $stockQuery = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    $stockQuery->execute([$item['quantity'], $item['product_id']]);
}

// Sepeti temizle
$deleteQuery = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$deleteQuery->execute([$user_id]);

echo "Siparişiniz başarıyla oluşturuldu. Sipariş Numaranız: #" . $order_id;
?>
