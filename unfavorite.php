<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['user_id']) || !isset($_POST['product_id'])) {
    header("Location: favorites.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);

$stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND product_id = ?");
$stmt->execute([$user_id, $product_id]);

header("Location: favorites.php");
exit;
