<?php
session_start();
require_once 'core/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        echo "Bu e-posta zaten kullanımda!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        
        // YENİ EKLENEN KISIM ↓
        $user_id = $pdo->lastInsertId();
        $_SESSION['user'] = $email;
        $_SESSION['user_id'] = $user_id;
        
        header("Location: dashboard.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form method="POST">
        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
        <input type="email" name="email" placeholder="E-posta" required>
        <input type="password" name="password" placeholder="Şifre" required>
        <button type="submit">Kayıt Ol</button>
    </form>
</body>
</html>