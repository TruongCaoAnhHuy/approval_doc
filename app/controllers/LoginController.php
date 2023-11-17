<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['us'])) {

        $username = $_POST['us'];

        $pdo = connect_db();

        // Sử dụng prepared statement và bindParam
        $sql = "SELECT * FROM ADUsers WHERE ADUserName = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            unset($_SESSION["error_msg"]);
            $_SESSION['username'] = $username;
            $_SESSION['us_code'] = $username;

            header("Location: authentwofa");
        } else {
            header("Location: login");
            $_SESSION['error_msg'] = "Tên người dùng không tồn tại. Vui lòng kiểm tra thông tin đăng nhập.";
        }
    }
}
