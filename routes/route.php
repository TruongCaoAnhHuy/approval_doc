<?php
    // Lấy URL hiện tại
    $current_url_ = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // Loại bỏ query parameters
    $url_parts = parse_url($current_url_);
    $base_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'];

    // Xử lý $route để xác định tài nguyên hoặc hành động cần thực hiện.
    $route = basename($url_parts['path']);

    switch ($route) {
        // page
        case 'document':
            if(isset($_SESSION["authentic"])) {
                include 'views/home.php'; 
            } else {
                include 'views/login.php'; 
            }
            break;
        case 'document/outbox':
            include 'views/outbox.php';
            break;
        case 'authentwofa':
            if(isset($_SESSION["username"])){
                include 'views/authentic.php';
            } else {
                include 'views/login.php'; 
            }
            break;
        case 'login':
            include 'views/login.php';
            break;
        case 'login_qrcode':
            include 'views/login_qrcode.php';
            break;
        case 'qr_code':
            if(isset($_SESSION["qr_code"])) {
                include 'views/qr_code.php'; 
            } else {
                include 'views/login_qrcode.php';
            }
            break;

        // controller
        case 'approval':
            include 'app/controllers/ApprovalController.php';
            break;
        case 'authentic':
            include 'app/controllers/LoginController.php';
            break;
        case 'authentic_two_fa':
            include 'app/controllers/AuthenticController.php';
            break;
        case 'authentic_qr':
            include 'app/controllers/QrCodeController.php';
            break;
        case 'logout':
            include 'app/controllers/LogoutController.php';
            break;
        default:
            include 'error_404.php';
    }