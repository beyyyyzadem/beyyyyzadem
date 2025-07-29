<?php
session_start();
include "includes/config.php";
include "includes/navbar.php";

if (!isset($_SESSION['user_id'])) {
    echo "<p style='text-align:center;'>Lütfen <a href='login.php'>giriş yapın</a>.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT f.id, p.title, p.image, p.price 
    FROM favorites f 
    JOIN products p ON f.product_id = p.id 
    WHERE f.user_id = ?
");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Favori Ürünlerim</title>
    <style>
        .favorites-container {
            max-width: 800px;
            margin: 40px auto;
        }
        .favorites-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .favorite-item {
            width: 180px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 6px;
        }
        .favorite-item img {
            width: 100%;
            height: 120px;
            object-fit: contain;
        }
    </style>
</head>
<body>

<div class="favorites-container">
    <h2>Favori Ürünlerim</h2>
    <?php if (count($items) === 0): ?>
        <p>Henüz favorilere eklenmiş bir ürününüz yok.</p>
    <?php else: ?>
        <div class="favorites-list">
            <?php foreach ($items as $item): ?>
                <div class="favorite-item">
                    <img src="assets/uploads/products/<?= htmlspecialchars($item['image']) ?>" alt="Ürün Görseli">
                    <p><?= htmlspecialchars($item['title']) ?></p>
                    <strong><?= number_format($item['price'], 2) ?> TL</strong>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
