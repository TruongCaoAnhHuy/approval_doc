<?php
    use Sonata\GoogleAuthenticator\GoogleAuthenticator;
    
    function get_qr_code() {

        $g = new GoogleAuthenticator();

        $secretKey = secret_key();

        $img = $g->getUrl("Approval", '_SPV', $secretKey);
        return $img;
    }