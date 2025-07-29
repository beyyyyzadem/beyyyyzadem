<?php
session_start();
require_once "includes/config.php";

// Giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $cart_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Sadece bu kullanıcıya aitse sil
    $sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$cart_id, $user_id]);
}

// Silindikten sonra sepete geri dön
header("Location: cart.php");
exit();
