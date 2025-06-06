<?php
require '../page_class/login_controller.php';

ini_set('session.cookie_path', '/');
session_start();

$login = new login_controller();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login->set_credentials($_POST);
    if ($login->validate()) {
        $login->attempt_login();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../page_styles/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="main_container">
        <form class="login_form" method="post">
            <h1>Log In</h1>

            <input type="text" name="email_input" placeholder="<?= $login->email_placeholder ?>" value="<?= htmlspecialchars($_POST['email_input'] ?? '') ?>">
            <input type="password" name="pass_input" placeholder="<?= $login->pass_placeholder ?>">

            <div class="remember">
                <input type="checkbox" id="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="login_button">Login</button>

            <?php if ($login->login_failed): ?>
                <p style="color: red;">Email atau password salah.</p>
            <?php endif; ?>

            <p class="terms">
                By continuing, you agree to the 
                <a href="#">Terms of Use</a> and 
                <a href="#">Privacy Policy</a>.
            </p>

            <p class="extra_links"><a href="#">Lupa password</a></p>
            <p class="extra_links">Belum memiliki akun? <a href="signup.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>
