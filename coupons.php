<?php
session_start();
require_once "includes/config.php";
require_once "includes/navbar.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Kullanıcının kuponlarını çek
$stmt = $conn->prepare("SELECT code, discount_percent, expires_at, status FROM coupons WHERE user_id = ?");
$stmt->execute([$user_id]);
$coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İndirim Kuponlarım</title>
    <style>
        .coupon-table {
            width: 80%;
            margin: 40px auto;
            border-collapse: collapse;
        }
        .coupon-table th, .coupon-table td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        .coupon-table th {
            background: #f0f0f0;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">İndirim Kuponlarım</h2>

<?php if (count($coupons) === 0): ?>
    <p style="text-align:center;">Henüz bir kuponunuz bulunmamaktadır.</p>
<?php else: ?>
    <table class="coupon-table">
        <thead>
            <tr>
                <th>Kupon Kodu</th>
                <th>İndirim</th>
                <th>Son Kullanım</th>
                <th>Durum</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($coupons as $coupon): ?>
                <tr>
                    <td><?= htmlspecialchars($coupon['code']) ?></td>
                    <td>%<?= (int)$coupon['discount_percent'] ?></td>
                    <td><?= htmlspecialchars($coupon['expires_at']) ?></td>
                    <td><?= ucfirst($coupon['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
