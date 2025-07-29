<?php
session_start();
include "includes/config.php";

$search = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$query = "SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%' LIMIT 50";
$result = mysqli_query($conn, $query);
?>

<?php include "includes/navbar.php"; ?>
<div style="max-width: 1000px; margin: 30px auto;">
    <h2>"<?php echo htmlspecialchars($search); ?>" için arama sonuçları</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div style="border: 1px solid #eee; padding: 10px;">
                <img src="assets/uploads/products/<?php echo $row['image']; ?>" style="width: 100%; height: 180px; object-fit: cover;">
                <h4><?php echo $row['name']; ?></h4>
                <p><?php echo number_format($row['price'], 2); ?> TL</p>
                <a href="product_detail.php?id=<?php echo $row['id']; ?>">İncele</a>
            </div>
        <?php } ?>
    </div>
</div>
