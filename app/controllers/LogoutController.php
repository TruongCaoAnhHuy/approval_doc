<?php
    if(isset($_SESSION["username"])) {
        unset($_SESSION["username"]);
        header("Location: login");
    }
    if(isset($_SESSION["authentic"])) {
        unset($_SESSION["authentic"]);
        header("Location: login");
    }