<?php
    /*View*/
    $theme = '';
    if ($result['navigation']['theme']) {
        $theme = $result['navigation']['theme'];
    }
    $logo = 'themes/img/fafr_logo.png';
    if (isset($result['navigation'])) {
        if (!isset($result['navigation']['menu'])) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/start.php');
            $navigation = start_NAVIG();
        }
        else {
            $navigation = $result['navigation'] ? $result['navigation']['menu'] : array();
        }

        $header = $result['navigation']['header'] ? $result['navigation']['header'] : 'Федерация американского футбола России';
        $title = $result['navigation']['title'] ? $result['navigation']['title'] : '';
        $description = $result['navigation']['description'] ? $result['navigation']['description'] : '';

        $basekeywords = array('Американский футбол', 'Американский футбол в России', 'Амфут');
        if ($result['navigation']['keywords']) {
            $keywordsArr = array_merge($basekeywords, $result['navigation']['keywords']);
        }
        else {
            $keywordsArr = array();
        }
        $keywords = implode(',', $keywordsArr);

        if ($result['navigation']['logo']) {
            $logo = 'upload/' . $result['navigation']['logo'];
        }
    } else {
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/start.php');
        $navigation = start_NAVIG();
        $header = '';
    }

    if (strstr($_SERVER['HTTP_HOST'], 'amfoot.ru')) {
        $HOST='amfoot.ru';
    }
    else {
        $HOST = $_SERVER['HTTP_HOST'];
    }

    $detect = new Mobile_Detect;
    $IS_MOBILE =  $detect->isMobile() ||  $detect->isAndroidOS() ||  $detect->isiOS();
