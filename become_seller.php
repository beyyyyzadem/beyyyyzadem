<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Daha önce başvurdu mu?
$check = $conn->prepare("SELECT * FROM seller_requests WHERE user_id = ?");
$check->execute([$user_id]);

if ($check->rowCount() > 0) {
    echo "Zaten başvuru yapmışsınız.";
    exit;
}

// Form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $store_name = $_POST['store_name'] ?? '';
    $description = $_POST['description'] ?? '';

    $insert = $conn->prepare("INSERT INTO seller_requests (user_id, store_name, description, status, requested_at) VALUES (?, ?, ?, 'beklemede', NOW())");
    $insert->execute([$user_id, $store_name, $description]);

    echo "Başvurunuz alınmıştır. En kısa sürede değerlendirilecektir.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Satıcı Başvurusu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
    <h2>Satıcı Olmak İstiyorum</h2>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label>Mağaza Adı</label>
            <input type="text" name="store_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kısa Açıklama</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary">Başvuruyu Gönder</button>
    </form>
</body>
</html>
