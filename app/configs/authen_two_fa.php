<?php    
    function secret_key() {
        $secret = get_user_name_excel()[$_SESSION["us_code"]];
        return $secret;
    }