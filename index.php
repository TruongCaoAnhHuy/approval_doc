<?php  
    session_set_cookie_params(0);
    session_start();

    require 'vendor/autoload.php';

    require 'app/configs/config.php';
    require 'app/configs/database.php';
    require 'app/configs/config_user.php';
    require 'app/configs/authen_two_fa.php';
    
    require 'app/models/PanelModel.php';
    require 'app/models/DocModel.php';
    require 'app/models/AuthenticModel.php';

    require 'routes/route.php'
?>