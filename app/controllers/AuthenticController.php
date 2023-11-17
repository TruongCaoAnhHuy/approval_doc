<?php
    use Sonata\GoogleAuthenticator\GoogleAuthenticator;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
        if (isset($_POST['otp'])) {

            $otp = $_POST['otp'];
            $secretKey = secret_key();
            $g = new GoogleAuthenticator();

            if ($g->checkCode($secretKey, $otp)) {
                unset($_SESSION["error_msg"]);
                $_SESSION['authentic'] = true;
                header("Location: document");
            } else {
                header("Location: authentwofa");
                $_SESSION['error_msg'] = "OTP sai. Vui lòng kiểm tra thông tin đăng nhập.";
            }
        }
    }
