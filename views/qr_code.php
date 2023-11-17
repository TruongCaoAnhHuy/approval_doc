<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <title>SPV</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
</head>
<body>
    <header class="d-flex justify-content-between align-items-center">
        <div class="title">SPV</div>
        <div class="control">
            | <a href="<?php echo $db_bk["base_url"]?>/login" id="qr_to_login" class="logout_btn" onclick="qr_to_login()">Login</a>
        </div>
    </header>

    <div class="wrapper wrapper-pd">
        <div class="login-wrapper">
            <div class="login_header">
                QR_CODE
            </div>
            <p class="text-danger error_msg"><?php echo isset($_SESSION['error_msg']) ? $_SESSION['error_msg'] : ''?></p>
            <div class="login_content">
                <div class="form-group  d-flex align-items-center justify-content-center">
                    <img 
                        src="<?php echo get_qr_code()?>" 
                        alt="qr_code"
                    >
                </div>
            </div>
        </div>
    </div>

    <footer class="d-flex align-items-center justify-content-between position-fixed bottom-0">
        <div class="copy-right">2023 © Copyright by [company name]</div>
        <div class="footer-menu">
            <ul class="footer-menu_list d-flex align-items-center">
                <li class="footer-menu_item" id="date_value">27/10/2023</li>
                <li class="footer-menu_item">Period: 10</li>
                <li class="footer-menu_item" id="year">Year: 2023</li>
                <li class="footer-menu_item" id="server">Server: <?php echo $db_bk["hostname"] ? $db_bk["hostname"] : '' ?></li>
                <li class="footer-menu_item">Database: <?php echo $db_bk["database"] ? $db_bk["database"] : '' ?></li>
            </ul>
        </div>
    </footer>
</body>

<script text="javascript" src="./assets/js/date_time.js"></script>
<script text="javascript" src="./assets/js/login.js"></script>

<script>
    function qr_to_login() {
        <?php
            if(isset($_SESSION["qr_code"])) {
                unset($_SESSION["qr_code"]);
            }
        ?>
    }
</script>
</html>