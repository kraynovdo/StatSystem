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
            $navList = navigation_list($dbConnect, $CONSTPath, $result['navigation']['code']);

            $lvl = 1;
            $NAVCURRENT = NULL; $NAVCURRENT2 = NULL; $NAVCURRENT3 = NULL;
            $path = array();
            $ids = array();

            for ($i = 0; $i < count($navList); $i++) {
                if ($navList[$i]['alias'] == $navAlias) {
                    $parent = $navList[$i]['parent'];
                    array_unshift($path, $navList[$i]['parent']);
                    array_unshift($ids, $navList[$i]['id']);
                    break;
                }
            }

            //Идем вверх
            while ($parent) {
                for ($i = 0; $i < count($navList); $i++) {
                    if ($navList[$i]['id'] == $parent) {
                        $parent = $navList[$i]['parent'];
                        array_unshift($path, $navList[$i]['parent']);
                        array_unshift($ids, $navList[$i]['id']);
                        break;
                    }
                }
            }
            //Идем вниз
            $go = false;
            $parent = $ids[count($path) - 1];
            do {
                $go = false;
                for ($i = 0; $i < count($navList); $i++) {
                    if ($navList[$i]['parent'] == $parent) {
                        $go = true;
                        $parent = $navList[$i]['id'];
                        array_push($path, $navList[$i]['parent']);
                        array_push($ids, $parent);
                        break;
                    }
                }
            } while($go);

            for ($i = 0; $i < count($navList); $i++) {
                if (strlen($path[0]) && $navList[$i]['parent'] == $path[0]) {
                    $NAVIGATION[$navList[$i]['title']] = $navList[$i]['href'];
                }
                if (strlen($path[1]) && $navList[$i]['parent'] == $path[1]) {
                    $NAVIGATION2[$navList[$i]['title']] = $navList[$i]['href'];
                }
                if (strlen($path[2]) && $navList[$i]['parent'] == $path[2]) {
                    $NAVIGATION3[$navList[$i]['title']] = $navList[$i]['href'];
                }

                if (strlen($ids[0]) && $navList[$i]['id'] == $ids[0]) {
                    $NAVCURRENT = $navList[$i]['title'];
                }
                if (strlen($ids[0]) && $navList[$i]['id'] == $ids[1]) {
                    $NAVCURRENT2 = $navList[$i]['title'];
                }
                if (strlen($ids[0]) && $navList[$i]['id'] == $ids[2]) {
                    $NAVCURRENT3 = $navList[$i]['title'];
                }
            }

        }
        else {
            $NAVIGATION = $result['navigation']['menu'] ? $result['navigation']['menu'] : array('Главная' => '/');
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
        $NAVIGATION = array('Главная' => '/');
        $header = '';
        $logo = 'themes/img/fafr_logo.png';
        $theme = '';
    }

    if (strstr($_SERVER['HTTP_HOST'], 'amfoot.ru')) {
        $HOST='amfoot.ru';
    }
    else {
        $HOST = $_SERVER['HTTP_HOST'];
    }

    $detect = new Mobile_Detect;
    $IS_MOBILE =  $detect->isMobile() ||  $detect->isAndroidOS() ||  $detect->isiOS();
