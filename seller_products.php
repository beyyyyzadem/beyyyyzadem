<?php
session_start();
require_once 'config/database.php';

$seller_id = isset($_GET['seller_id']) ? (int)$_GET['seller_id'] : 0;

if ($seller_id <= 0) {
    die("Satıcı bulunamadı.");
}

// Satıcı bilgisi
$stmt_seller = $conn->prepare("SELECT store_name FROM sellers WHERE id = ?");
$stmt_seller->execute([$seller_id]);
$seller = $stmt_seller->fetch(PDO::FETCH_ASSOC);

if (!$seller) {
    die("Satıcı bulunamadı.");
}

// Satıcının ürünleri
$stmt_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
$stmt_products->execute([$seller_id]);
$products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($seller['store_name']); ?> | Ürünleri</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f7f8fa;
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        h2 {
            margin-bottom: 30px;
            color: #333;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 25px;
        }
        .product-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            padding: 15px;
            transition: 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
        }
        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
        }
        .product-name {
            font-size: 16px;
            font-weight: bold;
            margin-top: 12px;
            color: #222;
        }
        .product-price {
            color: #f36f21;
            font-size: 15px;
            margin: 6px 0;
        }
        .product-desc {
            font-size: 13px;
            color: #666;
            height: 40px;
            overflow: hidden;
        }
        .detail-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 14px;
            background: #f36f21;
            color: white;
            border-radius: 5px;
            font-size: 13px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container">
    <h2><?php echo htmlspecialchars($seller['store_name']); ?> Mağazasındaki Ürünler</h2>

    <div class="product-grid">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo !empty($product['image']) ? 'assets/uploads/' . $product['image'] : 'https://via.placeholder.com/300x180?text=Ürün'; ?>" alt="">
                    <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                    <div class="product-price">₺<?php echo number_format($product['price'], 2, ',', '.'); ?></div>
                    <div class="product-desc"><?php echo htmlspecialchars(mb_substr($product['description'], 0, 80)) . '...'; ?></div>
                    <a class="detail-button" href="product_detail.php?id=<?php echo $product['id']; ?>">Detay</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Bu satıcıya ait henüz ürün eklenmemiş.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
