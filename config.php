<?php
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $global_config = array(
            'dbString' => 'mysql:host=localhost;dbname=StatSystem',
            'dbUser' => 'root',
            'dbPassword' => ''
        );
    }
    else {
        $global_config = array(
            'dbString' => 'mysql:host=localhost;dbname=bh56558_StatSystem',
            'dbUser' => 'bh56558_user',
            'dbPassword' => '0cc9afd'
        );
    }