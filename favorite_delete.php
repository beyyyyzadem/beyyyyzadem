<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$_SESSION['user_id'], $_POST['product_id']]);
}

header("Location: favorites.php");
exit;
