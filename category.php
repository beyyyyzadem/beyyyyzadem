<?php
session_start();
include "includes/config.php";

if (!isset($_GET['cat']) || !is_numeric($_GET['cat'])) {
    echo "İlgili kategoriye ulaşılamıyor.";
    exit;
}

$category_id = (int)$_GET['cat'];
if ($category_id <= 0) {
    echo "İlgili kategoriye ulaşılamıyor.";
    exit;
}

// Kategori adı
$stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    echo "Kategori bulunamadı.";
    exit;
}

// Ürünleri çek
$stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
$stmt->execute([$category_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include "includes/navbar.php"; ?>

<div style="max-width: 1200px; margin: 40px auto; font-family: Arial, sans-serif;">
    <h2 style="margin-bottom: 20px;"><?= htmlspecialchars($category['name']) ?> Kategorisi</h2>

    <?php if (count($products) > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
            <?php foreach ($products as $product): ?>
                <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; padding: 10px; background: #fff;">
                    <a href="product_detail.php?id=<?= $product['id'] ?>">
                        <img src="assets/uploads/products/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" style="width: 100%; height: 180px; object-fit: contain;">
                        <h4 style="margin: 10px 0;"><?= htmlspecialchars($product['title']) ?></h4>
                        <p><?= number_format($product['price'], 2) ?> TL</p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Bu kategoriye ait ürün bulunmamaktadır.</p>
    <?php endif; ?>
</div>
