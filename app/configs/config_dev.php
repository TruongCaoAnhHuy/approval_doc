<?php
    $env_var = parse_ini_file('.env.dev');

    $config = array(
        'hostname' => isset($env_var) ? $env_var["SERVERNAME"] : '',
        'username' => isset($env_var) ? $env_var["USERNAME"] : '',
        'password' => isset($env_var) ? $env_var["PASSWORD"] : '',
        'database' => isset($env_var) ? $env_var["DATABASE"] : '',
        'base_url' => isset($env_var) ? $env_var["BASEPATH"] : ''
    );
    