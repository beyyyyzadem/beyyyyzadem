<?php
session_start();
require 'core/database.php';

// GEÇİCİ USER_ID DÜZELTMESİ (Eski oturumlar için)
if(isset($_SESSION['user']) && !isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$_SESSION['user']]);
    $user = $stmt->fetch();
    if($user) {
        $_SESSION['user_id'] = $user['id'];
    } else {
        session_destroy();
        header("Location: login.php");
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ... diğer kodlarınız buradan sonra gelmeli
?>