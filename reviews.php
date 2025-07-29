<?php
session_start();
include("includes/config.php");
include("includes/navbar.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = $conn->prepare("SELECT r.*, p.title FROM reviews r JOIN products p ON r.product_id = p.id WHERE r.user_id = ?");
$sql->execute([$user_id]);
$reviews = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h3>Değerlendirmelerim</h3>
    <?php if ($reviews): ?>
        <ul class="list-group">
            <?php foreach ($reviews as $review): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($review['title']) ?></strong><br>
                    Puan: <?= $review['rating'] ?>/5<br>
                    Yorum: <?= htmlspecialchars($review['comment']) ?><br>
                    Tarih: <?= $review['created_at'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Hiç değerlendirme yapmadınız.</p>
    <?php endif; ?>
</div>
