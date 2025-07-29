<?php
session_start();

// Sepeti tamamen temizle
unset($_SESSION['cart']);

header("Location: cart.php");
exit;
