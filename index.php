<?php
    if (!$CONSTPath) $CONSTPath = '';

    if (strstr($_SERVER['HTTP_HOST'], 'ulaf.amfoot.net')) {
    	$HOST='amfoot.net';
    }
    else {


	    if (strstr($_SERVER['HTTP_HOST'], 'amfoot.net') && !strstr($_SERVER['HTTP_HOST'], 'ulaf')) {
	        $url = $_SERVER['REQUEST_URI'];
	        $hostNew = str_replace('amfoot.net', 'amfoot.ru', $_SERVER['HTTP_HOST']);
	        header ('Location: //' . $hostNew . $url);
	    } else if (strstr($_SERVER['HTTP_HOST'], 'amfoot.ru')) {
	        $HOST='amfoot.ru';
	    }
	    else {
	        $HOST = $_SERVER['HTTP_HOST'];
	    }
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/config.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/Mobile_Detect.php');
    header("Content-Type: text/html; charset=utf-8");




    if (strstr($_SERVER['HTTP_HOST'], 'amfoot.ru')) {
        ini_set("session.cookie_domain",".amfoot.ru");
    }
    session_start();




    //database
    $dbConnect = new PDO($global_config['dbString'], $global_config['dbUser'], $global_config['dbPassword']);
    $dbConnect->query('SET NAMES utf8');

    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/common.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/router.php');

    $dbConnect = null;