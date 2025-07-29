<?php
session_start();
include "includes/config.php";
include "includes/navbar.php";

if (!isset($_SESSION['user_id'])) {
    echo "<p style='text-align:center;'>Lütfen <a href='login.php'>giriş yapın</a>.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT c.id, p.title, p.price, c.quantity, p.image 
                        FROM cart c 
                        JOIN products p ON c.product_id = p.id 
                        WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="max-width: 800px; margin: 40px auto;">
    <h2>Sepetim</h2>
    <?php if (count($items) == 0): ?>
        <p>Sepetiniz boş.</p>
    <?php else: ?>
        <table width="100%" cellpadding="10" border="1">
            <tr><th>Ürün</th><th>Adet</th><th>Fiyat</th><th>Toplam</th></tr>
            <?php $total = 0; foreach ($items as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['price'], 2) ?> TL</td>
                <td><?= number_format($subtotal, 2) ?> TL</td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h3>Toplam: <?= number_format($total, 2) ?> TL</h3>
    <?php endif; ?>
</div>
