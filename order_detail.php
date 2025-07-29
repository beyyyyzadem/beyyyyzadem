<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['code'])) {
    die("Sipariş kodu bulunamadı.");
}

$order_code = mysqli_real_escape_string($conn, $_GET['code']);
$user_id = $_SESSION['user_id'];

// Sipariş kontrolü
$query = "SELECT * FROM orders WHERE order_code='$order_code' AND user_id=$user_id";
$order_result = mysqli_query($conn, $query);

if (mysqli_num_rows($order_result) == 0) {
    die("Sipariş bulunamadı.");
}

$order = mysqli_fetch_assoc($order_result);

// Sipariş ürünleri
$product_result = mysqli_query($conn, "SELECT * FROM order_items WHERE order_code='$order_code'");
?>

<?php include "includes/navbar.php"; ?>
<div style="max-width: 900px; margin: 30px auto;">
    <h2>Sipariş Detayı: <?php echo $order['order_code']; ?></h2>
    <p><strong>Tarih:</strong> <?php echo $order['created_at']; ?></p>
    <p><strong>Durum:</strong> <?php echo $order['status']; ?></p>
    <p><strong>Toplam Tutar:</strong> <?php echo number_format($order['total_amount'], 2); ?> TL</p>

    <h3>Ürünler</h3>
    <table border="1" width="100%" cellpadding="10" cellspacing="0">
        <tr>
            <th>Ürün Adı</th>
            <th>Adet</th>
            <th>Birim Fiyat</th>
        </tr>
        <?php while ($item = mysqli_fetch_assoc($product_result)) { ?>
            <tr>
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['price'], 2); ?> TL</td>
            </tr>
        <?php } ?>
    </table>
</div>
