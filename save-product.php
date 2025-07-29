<?php
session_start();
require 'core/database.php';

if (!isset($_SESSION['user_id'])) {
    die("Lütfen giriş yapın!");
}

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$price = (float)$_POST['price'];
$category = $_POST['category'];

// Resim yükleme
$target_dir = "uploads/";
$image_name = uniqid() . '_' . basename($_FILES["image"]["name"]);
$target_file = $target_dir . $image_name;

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $stmt = $pdo->prepare("INSERT INTO products 
        (user_id, title, description, price, category, image) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $description, $price, $category, $image_name]);
    header("Location: dashboard.php?success=1");
} else {
    die("Resim yüklenemedi!");
}
?>