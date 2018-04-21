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

            //TODO отдельная тема для ФАФР
            if ($result['navigation']['code'] == 'main' || $result['navigation']['code'] == 'reg') {
                $theme = 'fafr-federation';
            }

            $code = $result['navigation']['code'];
            $pageId = $result['navigation']['pageId'];

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/navigation.php');
            $navList = navigation_list($dbConnect, $CONSTPath, $result['navigation']['code']);

            $NAVCURRENT = NULL; $NAVCURRENT2 = NULL;
            $NAVIGATION = array(); $NAVIGATION2 = array();

            for ($i = 0; $i < count($navList); $i++) {
                if ($navList[$i]['parent'] == 0) {
                    array_push($NAVIGATION, array(
                        'id' => $navList[$i]['id'],
                        'title' => $navList[$i]['title'],
                        'href' => $navList[$i]['href'],
                    ));
                    if ($pageId == $navList[$i]['id']) {
                        $NAVCURRENT = $pageId;
                    }
                }
            }

            if (!$NAVCURRENT) {
                for ($i = 0; $i < count($navList); $i++) {
                    if (($navList[$i]['parent'] != 0) && ($pageId == $navList[$i]['id'])) {
                        $NAVCURRENT = $navList[$i]['parent'];
                        $NAVCURRENT2 = $pageId;
                    }
                }
                for ($i = 0; $i < count($navList); $i++) {
                    if (($navList[$i]['parent'] == $NAVCURRENT)) {
                        array_push($NAVIGATION2, array(
                            'id' => $navList[$i]['id'],
                            'title' => $navList[$i]['title'],
                            'href' => $navList[$i]['href'],
                        ));
                    }
                }
            }

            $FOOTER_NAV = array();

            $curColumn = 0;
            $hasTwoMainInColumn = false;
            for ($i = 0; $i < count($navList); $i++) {
                if ($navList[$i]['parent'] == 0) {

                    if (!$FOOTER_NAV[$curColumn]) {
                        $FOOTER_NAV[$curColumn] = array();
                    }

                    $curPar = $navList[$i]['id'];
                    array_push($FOOTER_NAV[$curColumn], array(
                        'id' => $navList[$i]['id'],
                        'title' => $navList[$i]['title'],
                        'href' => $navList[$i]['href'],
                        'main' => true
                    ));

                    $childCount = 0;
                    for ($j = 0; $j < count($navList); $j++) {
                        if (($navList[$j]['parent'] == $curPar)) {
                            array_push($FOOTER_NAV[$curColumn], array(
                                'id' => $navList[$j]['id'],
                                'title' => $navList[$j]['title'],
                                'href' => $navList[$j]['href'],
                                'main' => false
                            ));
                            $childCount++;
                        }
                    }
                    if ($childCount == 0 && $hasTwoMainInColumn == false) {

                        array_push($FOOTER_NAV[$curColumn], array(
                            'id' => -1,
                            'title' => '&nbsp;',
                        ));
                        $hasTwoMainInColumn = true;
                    }
                    else {
                        $curColumn++;
                        $hasTwoMainInColumn = false;
                    }
                }
            }

        }
        else {
            $NAVIGATION = $result['navigation']['menu'] ? $result['navigation']['menu'] : array('Главная' => '/');
        }
        /**/




        $header = $result['navigation']['header'] ? $result['navigation']['header'] : 'Федерация американского футбола России';
        $subheader = $result['navigation']['subheader'] ? $result['navigation']['subheader'] : '';
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
        $NAVIGATION = array('Главная' => '/');
        $header = '';
        $logo = 'themes/img/fafr_logo.png';
        $theme = '';
    }

    if (strstr($_SERVER['HTTP_HOST'], 'amfoot.ru')) {
        $HOST='amfoot.ru';
    }
    else {
        if (strstr($_SERVER['HTTP_HOST'], 'amfoot.net')) {
            $HOST = 'amfoot.net';
        } else {
            $HOST = $_SERVER['HTTP_HOST'];
        }

    }