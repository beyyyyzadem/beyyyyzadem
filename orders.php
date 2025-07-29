<?php
session_start();
include("includes/config.php");
include("includes/navbar.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$sql->execute([$user_id]);
$orders = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h3>Siparişlerim</h3>
    <?php if (count($orders) > 0): ?>
        <ul class="list-group">
            <?php foreach ($orders as $order): ?>
                <li class="list-group-item">
                    Sipariş No: #<?= $order['id'] ?> |
                    Tarih: <?= $order['order_date'] ?> |
                    Durum: <?= $order['status'] ?> |
                    Toplam: <?= $order['total_price'] ?> TL
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Henüz bir siparişiniz yok.</p>
    <?php endif; ?>
</div>
