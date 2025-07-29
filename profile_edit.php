<?php
session_start();
require_once "includes/config.php";
require_once "includes/navbar.php";

// Giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = $error = "";

// Form gönderildiyse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);

    if (empty($full_name) || empty($email)) {
        $error = "Lütfen tüm alanları doldurun.";
    } else {
        $sql = "UPDATE users SET full_name = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$full_name, $email, $user_id])) {
            $success = "Bilgiler başarıyla güncellendi.";
        } else {
            $error = "Bir hata oluştu. Lütfen tekrar deneyin.";
        }
    }
}

// Mevcut bilgileri getir
$sql = "SELECT full_name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div style="max-width: 600px; margin: 30px auto; font-family: Arial, sans-serif;">
    <h2>Profil Bilgilerini Güncelle</h2>

    <?php if ($success): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px;"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Ad Soyad:</label>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required style="width:100%; padding:10px; margin:10px 0;">
        
        <label>E-Posta:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required style="width:100%; padding:10px; margin:10px 0;">

        <button type="submit" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px;">Güncelle</button>
    </form>
</div>
