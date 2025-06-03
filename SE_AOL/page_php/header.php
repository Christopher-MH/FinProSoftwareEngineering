<?php
    ini_set('session.cookie_path', '/');
    session_start();
    $is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../page_styles/header.css">
    </head>

    <body>
        <header class="main-header">
            <div class="logo">
                <img src="../page_assets/logo_trashtrade.png" alt="Trash Trade Logo">
            </div>
            <nav class="navbar">
                <a href="home.php">Home</a>
                <a href="services.php">Services</a>
                <a href="about_us.php">About Us</a>
                <a href="redeem.php">Redeem</a>
                <a href="contact.php">Contact Us</a>
                <a href="profile.php">Profile</a>
            </nav>
            <div class="auth-buttons">
            <?php if ($is_logged_in): ?>
                <a href="logout.php" class="login_button">Log Out</a>
            <?php else: ?>
                <a href="login.php" class="login_button">Login</a>
                <a href="signup.php" class="login_button">Sign Up</a>
            <?php endif; ?>
            </div>
        </header>
    </body>
</html>