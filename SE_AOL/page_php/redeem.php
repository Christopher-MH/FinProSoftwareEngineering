<?php
require '../page_class/redeem_controller.php';

ini_set('session.cookie_path', '/');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$controller = new redeem_controller($_SESSION['user_id']);

if (isset($_POST['redeem_voucher'])) {
    if ($controller->redeem($_POST['voucher_id'])) {
        header("Location: redeem.php?success=true");
    } else {
        header("Location: redeem.php?error=not_enough_points");
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../page_styles/redeem.css">
    </head>

    <body>
        <div id="header-placeholder"></div>
        <div class="main-container">
            <div class="container_A">
                <h1>Tukarkan Poin<br></br>Dapatkan Hadiah</h1>
                <p>Tersedia berbagai hadiah berupa voucher, termasuk makan, belanja, game, dan sebagainya!</p>
            </div>

            <div class="container_B">
                <img src="../page_assets/klhk_sponsor.png" alt="KLHK Logo">
                <img src="../page_assets/ovo_sponsor.png" alt="OVO Logo">
                <img src="../page_assets/gopay_sponsor.png" alt="GoPay Logo">
                <img src="../page_assets/paypal_sponsor.png" alt="PayPal Logo">
            </div>

            <div class="container_C">
                <div class="container_D">
                    <h1>Tukarkan Poin Anda</h1>
                    <p>Terima kasih banyak sudah berpartisipasi aktif dalam menjaga kebersihan lingkungan
                        dan pemanfaatan kembali sampah! Tukarkan poin yang anda dapatkan dengan
                        berbagai voucher hadiah menarik.
                    </p>
                </div>
                <div class="container_E">
                    <h2>Jumlah Poin Anda: <?= $controller->get_user_point(); ?></h2>
                </div>
                <div class="voucher-container">
                    <?php foreach ($controller->voucher_list as $voucher): ?>
                        <div class="voucher-item">
                            <img src="<?= $voucher['photo_path'] ?>" alt="<?= $voucher['nama'] ?>">
                            <h3><?= $voucher['nama'] ?></h3>
                            <p><?= $voucher['deskripsi'] ?></p>
                            <p class="harga"><?= $voucher['harga'] ?> poin</p>
                            <form method="post">
                                <input type="hidden" name="voucher_id" value="<?= $voucher['voucher_id'] ?>">
                                <button type="submit" name="redeem_voucher" <?= !$voucher['redeemable'] ? 'disabled class="btn-disabled"' : '' ?>>Redeem</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <script src = "../page_scripts/redeem.js"></script>
        <script>
            document.querySelectorAll("form").forEach(form => {
                form.addEventListener("submit", function(e) {
                    const confirmed = confirm("Apakah Anda yakin ingin redeem voucher ini?");
                    if (!confirmed) e.preventDefault();
                });
            });
        </script>
    </body>
    <style>
    .voucher-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
        padding: 30px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .voucher-item {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 20px;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease;
    }

    .voucher-item:hover {
        transform: translateY(-5px);
    }

    .voucher-item img {
        max-width: 100%;
        height: 150px;
        object-fit: cover;
        margin-bottom: 15px;
        border-radius: 10px;
    }

    .voucher-item h3 {
        font-size: 18px;
        margin: 10px 0 5px;
        color: #333;
    }

    .voucher-item p {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }

    .voucher-item .harga {
        font-weight: bold;
        color: #008000;
        margin-top: auto;
    }

    .voucher-item form {
        margin-top: 15px;
    }

    .voucher-item button {
        padding: 10px 20px;
        border: none;
        background-color: #28a745;
        color: white;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .voucher-item button:hover {
        background-color: #218838;
    }

    .voucher-item .btn-disabled {
        background-color: #ccc !important;
        color: #666 !important;
        cursor: not-allowed !important;
        pointer-events: none;
    }

    .btn-disabled {
        background-color: gray;
        color: white;
        cursor: not-allowed;
        opacity: 0.6;
    }
    </style>
</html>