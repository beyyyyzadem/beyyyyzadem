<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ödeme Sayfası</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Kart Bilgilerinizi Girin</h2>
    <form action="checkout.php" method="POST">
        <div class="mb-3">
            <label>Kart Üzerindeki İsim</label>
            <input type="text" name="card_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kart Numarası</label>
            <input type="text" name="card_number" class="form-control" required maxlength="16">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Son Kullanma Tarihi</label>
                <input type="text" name="exp_date" class="form-control" placeholder="AA/YY" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>CVC</label>
                <input type="text" name="cvc" class="form-control" required maxlength="3">
            </div>
        </div>
        <button type="submit" class="btn btn-success">Ödemeyi Tamamla ve Siparişi Ver</button>
    </form>
</div>
</body>
</html>
