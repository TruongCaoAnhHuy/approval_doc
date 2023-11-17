<?php
    use Sonata\GoogleAuthenticator\GoogleAuthenticator;

    global $us_bk;
    $us_bk = $user_configs;
    
    function secret_key() {
        global $us_bk;
        $secret = $us_bk[$_SESSION["us_code"]];
        return $secret;
    }