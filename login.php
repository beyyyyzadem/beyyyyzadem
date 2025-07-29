<?php
session_start();
require_once 'includes/config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name']
            ];
            header("Location: index.php");
            exit;
        } else {
            $message = "Hatalı e-posta veya şifre.";
        }
    } else {
        $message = "Lütfen tüm alanları doldurun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .login-container {
            width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
        }
        .login-container .register-link {
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="login-container">
    <h2>Giriş Yap</h2>
    <?php if ($message): ?>
        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="email" name="email" placeholder="E-Posta" required>
        <input type="password" name="password" placeholder="Şifre" required>
        <button type="submit">Giriş Yap</button>
    </form>
    <div class="register-link">
        Henüz üye değil misiniz? <a href="register.php">Abone Ol</a>
    </div>
</div>

</body>
</html>
