<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['us']) && isset($_POST['pw'])) {
        $username = $_POST['us'];
        $password = $_POST['pw'];

        $pdo = connect_db();

        // Sử dụng prepared statement và bindParam
        $sql = "SELECT * FROM ADUsers WHERE ADUserName = :username AND AAStatus = 'Alive'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $password === md5(pass_qr()) ) {
            unset($_SESSION["error_msg"]);
            
            $_SESSION['qr_code'] = true;
            $_SESSION['us_code'] = $username;

            header("Location: qr_code");
        } else {
            header("Location: login_qrcode");
            $_SESSION['error_msg'] = "Đăng nhập thất bại. Vui lòng kiểm tra thông tin đăng nhập.";
        }
    }
}
