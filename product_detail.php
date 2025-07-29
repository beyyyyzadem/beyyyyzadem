<?php 
session_start();
include "includes/config.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Geçersiz ürün ID";
    exit;
}

$product_id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Ürün bulunamadı.";
    exit;
}
?>

<?php include "includes/navbar.php"; ?>

<div style="max-width: 1200px; margin: 40px auto; font-family: Arial, sans-serif;">
    <div style="display: flex; gap: 40px;">
        <div style="flex: 1;">
            <img src="assets/uploads/products/<?= htmlspecialchars($product['image']) ?>" 
                 alt="<?= htmlspecialchars($product['title']) ?>" 
                 style="width: 100%; border-radius: 8px; max-height: 450px; object-fit: contain;">
        </div>

        <div style="flex: 1;">
            <h1 style="margin-bottom: 15px;"><?= htmlspecialchars($product['title']) ?></h1>
            <p style="color: #888; font-size: 14px; margin-bottom: 10px;">Stok: <?= $product['stock'] ?></p>
            <p style="font-size: 24px; font-weight: bold; color: #e67e22;"><?= number_format($product['price'], 2) ?> TL</p>

            <p style="margin: 20px 0;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Sepete Ekle Formu -->
                <form method="post" action="actions/add_to_cart.php" style="margin-bottom: 10px;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" style="width: 60px; padding: 5px;">
                    <button type="submit" style="padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 4px;">Sepete Ekle</button>
                </form>

                <!-- Favorilere Ekle Formu -->
                <form method="post" action="actions/add_to_favorites.php">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" style="padding: 8px 16px; background: #e74c3c; color: white; border: none; border-radius: 4px;">❤️ Favorilere Ekle</button>
                </form>
            <?php else: ?>
                <p><a href="login.php">Giriş yaparak sepete veya favorilere ekleyebilirsiniz.</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>
