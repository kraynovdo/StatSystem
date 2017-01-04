<?php
    if (isset($_GET['r']) && ($_GET['r'] != '')){
        $route = $_GET['r'];
        $routeArr = explode ('/', $route);
        $controller = $routeArr[0];
        $action = (count($routeArr) > 1) ? $routeArr[1] : 'index';
    }
    else {
        $controller = 'news';
        $action = 'index';
        $_GET['federation'] = 11;
    }


    /*Controller*/
    $controllerFile = $_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/' . $controller . '.php';
    $error_code = 0;
    if (file_exists($controllerFile)) {
        require_once($controllerFile);
        $methodName = $controller . '_' . $action;


        if (function_exists($methodName)) {
            $result = $methodName($dbConnect, $CONSTPath);
            if ($result == 'ERROR-403') {
                $error_code = 403;
            }
        }
        else {
            $error_code = 404;
        }

    }
    else {
        $error_code = 404;
    }

    if ($error_code) {
        $controller = 'error';
        $action = 'index';
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/error.php');
        $result = error_index($error_code);
    }

    $content = $_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/' . $controller . '/' . $action . '.php';
    $answer = $result['answer'];
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        if ($_GET['xhrView']) {
            if (file_exists($content)) {
                require $content;
            }
        }
        else {
            header("Content-Type: text/json; charset=utf-8");
            print json_encode($result);
        }

    }
    else {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/_viewconfig.php');
        $page = $result['page'];
        if (!$page) {
            if (strpos($action, 'print') === false) {
                if ($controller == 'start') {
                    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/main2.php');
                }
                else {
                    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/main.php');
                }
            }
            else {
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/print.php');
            }
        }
        else {
            header ('Location: '.$page);
        }
    }
