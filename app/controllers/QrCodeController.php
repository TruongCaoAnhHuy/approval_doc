<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['us']) && isset($_POST['pw'])) {

        $username = $_POST['us'];
        $password = $_POST['pw'];

        $pdo = connect_db();

        // Sử dụng prepared statement và bindParam
        $sql = "SELECT * FROM ADUsers WHERE ADUserName = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && json_encode($password) === json_encode(md5($user_configs[$username])) ) {
            unset($_SESSION["error_msg"]);
            $_SESSION['qr_code'] = true;
            header("Location: qr_code");
        } else {
            header("Location: login_qrcode");
            $_SESSION['error_msg'] = "Đăng nhập thất bại. Vui lòng kiểm tra thông tin đăng nhập.";
        }
    }
}