<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['product_id'])) {
    header("Location: favorites.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = (int) $_POST['product_id'];

$stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND product_id = ?");
$stmt->execute([$user_id, $product_id]);

header("Location: favorites.php");
exit;
