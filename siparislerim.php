<?php
require_once 'includes/init.php';
require_once 'includes/auth.php';

// Örnek sipariş listesi verisi (gerçek sistemde veritabanından gelir)
$siparisler = [
    [
        'id' => 1001,
        'tarih' => '2025-07-25',
        'durum' => 'Kargoya Verildi',
        'toplam' => '459.90 TL'
    ],
    [
        'id' => 1002,
        'tarih' => '2025-07-21',
        'durum' => 'Hazırlanıyor',
        'toplam' => '219.50 TL'
    ]
];

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Siparişlerim</title>
    <link rel="stylesheet" href="assets/style.css"> <!-- varsa stil dosyan -->
</head>
<body>
    <h1>Merhaba, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></h1>
    <h2>Siparişlerim</h2>

    <?php if (empty($siparisler)): ?>
        <p>Hiç siparişiniz bulunmamaktadır.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Sipariş ID</th>
                    <th>Tarih</th>
                    <th>Durum</th>
                    <th>Toplam Tutar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($siparisler as $siparis): ?>
                    <tr>
                        <td>#<?php echo $siparis['id']; ?></td>
                        <td><?php echo $siparis['tarih']; ?></td>
                        <td><?php echo $siparis['durum']; ?></td>
                        <td><?php echo $siparis['toplam']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="index.php">Ana Sayfa</a></p>
</body>
</html>
