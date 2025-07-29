<?php
require_once('auth.php');
require_once('../config/database.php');

$message = '';

// Ürün ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $seller_id = $_SESSION['user_id'];
    $category_id = 1; // Geçici olarak sabit, sonra kategori seçimi eklenecek

    // Resim yükleme işlemi
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        $target_path = "../assets/uploads/" . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
    } else {
        $image_name = null;
    }

    $stmt = $conn->prepare("INSERT INTO products (seller_id, category_id, title, description, price, stock, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$seller_id, $category_id, $title, $description, $price, $stock, $image_name]);

    $message = "✅ Ürün başarıyla eklendi!";
}
?>

<h2>Yeni Ürün Ekle</h2>

<?php if ($message): ?>
    <p style="color: green"><?= $message ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Ürün Başlığı" required><br><br>
    <textarea name="description" placeholder="Açıklama" required></textarea><br><br>
    <input type="number" name="price" placeholder="Fiyat" step="0.01" required><br><br>
    <input type="number" name="stock" placeholder="Stok Adedi" required><br><br>
    <input type="file" name="image"><br><br>
    <button type="submit">Ürünü Ekle</button>
</form>
