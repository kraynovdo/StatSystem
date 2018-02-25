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
        if (strstr($_SERVER['HTTP_HOST'], 'amfoot.net')) {
            $HOST = 'amfoot.net';
        } else {
            $HOST = $_SERVER['HTTP_HOST'];
        }

    }



/*
 $navAlias = $controller.'/'.$action;
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/navigation.php');
            $navList = navigation_list($dbConnect, $CONSTPath, $result['navigation']['code']);

            $lvl = 1;
            $NAVCURRENT = NULL; $NAVCURRENT2 = NULL; $NAVCURRENT3 = NULL; $NAVCURRENT4 = NULL;
            $NAVIGATION = array(); $NAVIGATION2 = array(); $NAVIGATION3 = array(); $NAVIGATION4 = array();

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
                if (strlen($ids[0]) && $navList[$i]['id'] == $ids[0]) {
                    $NAVCURRENT = $navList[$i]['title'];
                }
                if (strlen($ids[1]) && $navList[$i]['id'] == $ids[1]) {
                    $NAVCURRENT2 = $navList[$i]['title'];
                }
                if (strlen($ids[2]) && $navList[$i]['id'] == $ids[2]) {
                    $NAVCURRENT3 = $navList[$i]['title'];
                }

                if (strlen($path[0]) && $navList[$i]['parent'] == $path[0]) {
                    $NAVIGATION[$navList[$i]['title']] = $navList[$i]['href'];
                }
                if (strlen($path[1]) && $navList[$i]['parent'] == $path[1]) {
                    $NAVIGATION2[$navList[$i]['title']] = $navList[$i]['href'];
                }
                if (strlen($path[2]) && $navList[$i]['parent'] == $path[2]) {
                    $NAVIGATION3[$navList[$i]['title']] = $navList[$i]['href'];
                }
            }

            $NAVIGATION4 = array();
            if (!count($NAVIGATION4) && ($NAVCURRENT3 || $NAVCURRENT2 || $NAVCURRENT) && $ids[0] != 3) {//TODO

    if ($NAVCURRENT3) {
        $cur = $NAVCURRENT3;
    } else {
        if ($NAVCURRENT2) {
            $cur = $NAVCURRENT2;
        }
        else {
            $cur = $NAVCURRENT;
        }
    }
    $NAVIGATION4[$cur] = '';
    $NAVCURRENT4 = $cur;
}

  */