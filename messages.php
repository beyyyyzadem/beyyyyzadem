<?php
session_start();
require_once "includes/config.php";
require_once "includes/navbar.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Kullanıcının mesajlarını çek
$stmt = $conn->prepare("SELECT subject, message, created_at FROM messages WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Mesajlarım</title>
    <style>
        .messages-container {
            max-width: 800px;
            margin: 40px auto;
        }
        .message-box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .message-box h4 {
            margin: 0 0 10px;
        }
        .message-box small {
            color: #888;
        }
    </style>
</head>
<body>

<div class="messages-container">
    <h2>Destek Taleplerim</h2>

    <?php if (count($messages) === 0): ?>
        <p>Henüz gönderdiğiniz bir destek mesajı bulunmamaktadır.</p>
    <?php else: ?>
        <?php foreach ($messages as $msg): ?>
            <div class="message-box">
                <h4><?= htmlspecialchars($msg['subject']) ?></h4>
                <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                <small>Gönderim tarihi: <?= htmlspecialchars($msg['created_at']) ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
