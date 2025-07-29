<?php
session_start();
include "includes/config.php";

if (!isset($_POST['cart_id'], $_POST['quantity'])) {
    header("Location: cart.php");
    exit;
}

$cart_id = intval($_POST['cart_id']);
$quantity = max(1, intval($_POST['quantity']));

$stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
$stmt->execute([$quantity, $cart_id]);

header("Location: cart.php");
exit;
