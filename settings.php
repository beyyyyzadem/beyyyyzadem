<?php
session_start();
require_once "includes/config.php";
require_once "includes/navbar.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Bilgileri çek
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if ($name && $email) {
        $update = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $update->execute([$name, $email, $user_id]);
        echo "<p style='color:green;'>Bilgileriniz güncellendi.</p>";
        $_SESSION['user']['name'] = $name; // Navbar için güncelle
        $user['name'] = $name;
        $user['email'] = $email;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hesap Ayarları</title>
</head>
<body>
    <h2>Hesap Ayarlarım</h2>
    <form method="post" style="max-width:400px;">
        <label>Ad Soyad:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>

        <label>E-posta:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

        <button type="submit">Güncelle</button>
    </form>
</body>
</html>
