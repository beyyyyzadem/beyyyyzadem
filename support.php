<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Destek ve Mesajlar</title>
</head>
<body>
    <h1>Mesajlarım / Destek</h1>
    <p>Burada aldığınız destek mesajları listelenecek.</p>
</body>
</html>
