<?php
    if (!$CONSTPath) $CONSTPath = '';
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/config.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/Mobile_Detect.php');
    header("Content-Type: text/html; charset=utf-8");
    if (strstr($_SERVER['HTTP_HOST'], 'amfoot.net')) {
        ini_set("session.cookie_domain",".amfoot.net");
    } else if (strstr($_SERVER['HTTP_HOST'], 'amfoot.ru')) {
        ini_set("session.cookie_domain",".amfoot.ru");
    }   
    session_start();




    //database
    $dbConnect = new PDO($global_config['dbString'], $global_config['dbUser'], $global_config['dbPassword']);
    $dbConnect->query('SET NAMES utf8');

    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/common.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/router.php');

    $dbConnect = null;