<?php
session_start();
include("includes/config.php");
include("includes/navbar.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = $conn->prepare("SELECT * FROM users WHERE id = ?");
$sql->execute([$user_id]);
$user = $sql->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h3>Kullanè©≈cè©≈ Bilgilerim</h3>
    <ul class="list-group">
        <li class="list-group-item"><strong>Ad:</strong> <?= htmlspecialchars($user['name']) ?></li>
        <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
        <li class="list-group-item"><strong>Kayè©≈t Tarihi:</strong> <?= $user['created_at'] ?></li>
    </ul>
</div>
