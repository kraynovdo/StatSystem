<?php
    /*View*/
    if (isset($result['navigation'])) {
        $theme = '';
        if ($result['navigation']['theme']) {
            $theme = $result['navigation']['theme'];
        }
        $logo = 'themes/img/fafr_logo.png';

        /*Обработка меню навигации*/
        if ($result['navigation']['code']) {
            $navAlias = $controller.'/'.$action;
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/navigation.php');
            $navArr = navigation_list($dbConnect, $CONSTPath, $result['navigation']['code']);

            for ($i = 0; $i < count($navArr); $i++) {
                $NAVIGATION[$navArr[$i]['title']] = $navArr[$i]['href'];
                if ($navArr[$i]['alias'] == $navAlias) {
                    $NAVCURRENT = $navArr[$i]['title'];
                    $NAVCURRENTID = $navArr[$i]['id'];
                }
            }

            if ($NAVCURRENTID) {
                $navArr = navigation_list($dbConnect, $CONSTPath, $result['navigation']['code'], $NAVCURRENTID);
                for ($i = 0; $i < count($navArr); $i++) {
                    $NAVIGATION2[$navArr[$i]['title']] = $navArr[$i]['href'];
                    if ($navArr[$i]['alias'] == $navAlias) {
                        $NAVCURRENT2 = $navArr[$i]['title'];
                        $NAVCURRENTID2 = $navArr[$i]['id'];
                    }
                }
            }
            if ($NAVCURRENTID2) {
                $navArr = navigation_list($dbConnect, $CONSTPath, $result['navigation']['code'], $NAVCURRENTID2);
                for ($i = 0; $i < count($navArr); $i++) {
                    $NAVIGATION3[$navArr[$i]['title']] = $navArr[$i]['href'];
                    if ($navArr[$i]['alias'] == $navAlias) {
                        $NAVCURRENT3 = $navArr[$i]['title'];
                        $NAVCURRENTID3 = $navArr[$i]['id'];
                    }
                }
            }
        }
        else {
            $NAVIGATION = $result['navigation']['menu'] ? $result['navigation']['menu'] : array();
        }
        /**/




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
        $navigation = $navigation['menu'];
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
