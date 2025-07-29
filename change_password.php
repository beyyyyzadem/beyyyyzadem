<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    $check = mysqli_query($conn, "SELECT password FROM users WHERE id = $user_id");
    $data = mysqli_fetch_assoc($check);

    if ($new != $confirm) {
        $message = "Yeni şifreler eşleşmiyor.";
    } elseif ($data['password'] != $current) {
        $message = "Mevcut şifre hatalı.";
    } else {
        mysqli_query($conn, "UPDATE users SET password = '$new' WHERE id = $user_id");
        $message = "Şifreniz başarıyla güncellendi.";
    }
}
?>

<?php include "includes/navbar.php"; ?>
<div style="max-width: 500px; margin: 30px auto;">
    <h2>Şifre Değiştir</h2>
    <?php if ($message): ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Mevcut Şifre:</label><br>
        <input type="password" name="current_password" required><br><br>

        <label>Yeni Şifre:</label><br>
        <input type="password" name="new_password" required><br><br>

        <label>Yeni Şifre (Tekrar):</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Güncelle</button>
    </form>
</div>
