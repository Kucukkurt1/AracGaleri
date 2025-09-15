<?php
session_start();


if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === '12345') {
        $_SESSION['logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Kullanıcı adı veya şifre yanlış!';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Admin Girişi</title>
</head>
<body>
<h2>Admin Paneli Girişi</h2>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post" action="">
    <label>Kullanıcı Adı: <input type="text" name="username" required></label><br><br>
    <label>Şifre: <input type="password" name="password" required></label><br><br>
    <button type="submit">Giriş Yap</button>
</form>

</body>
</html>

