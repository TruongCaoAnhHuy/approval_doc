<?php
    use Sonata\GoogleAuthenticator\GoogleAuthenticator;
    
    function get_qr_code() {

        $g = new GoogleAuthenticator();

        $secretKey = secret_key();

        $img = $g->getUrl($_SESSION["us_code"], '_SPV_Approval', $secretKey);
        return $img;
    }