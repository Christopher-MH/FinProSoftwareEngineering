<?php
require "../page_class/login_controller.php";
$login_controller = new login_controller();

if(isset($_POST["login_button"])){
    $login_controller->login($_POST);
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
        <form class="login_form" method="POST" action="">
            <h1>Log In</h1>
            <input type="text" name="email_input" placeholder="Email" value="<?php echo htmlspecialchars($login_controller->email ?? ''); ?>" required>
            <input type="password" name="password_input" placeholder="Password" required>
            <h2 style="display: <?php echo $login_controller->fail_login; ?>;">*Wrong email or password</h2>

            <div class="remember">
                <input type="checkbox" id="remember">
                <label for="remember">Remember me</label>
            </div>

            <input type = "submit" name = "login_button" value = "Log in" class="login_button">

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
