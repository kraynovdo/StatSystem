<?php
    $CONSTPath = '/..';
    if (!$_GET['r']) {
        $_GET['r'] = 'competition/view';
    }
    $_GET['comp'] = 1;
    if (strstr($_SERVER['HTTP_HOST'], 'amfoot.net')) {
        ini_set("session.cookie_domain",".amfoot.net");
    } else if (strstr($_SERVER['HTTP_HOST'], 'amfoot.ru')) {
        ini_set("session.cookie_domain",".amfoot.ru");
    }
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/index.php');