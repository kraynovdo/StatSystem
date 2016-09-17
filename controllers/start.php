<?php
    function start_NAVIG() {
        $navig_arr = array(
                'Главная страница' => '/'
        );
        if ($_SESSION['userID'] && $_SESSION['userType'] == 3) {
            $navig_arr['Администрирование'] = '/?r=admin';
        }
        return $navig_arr;
    }
    function start_index(){
        $result = array();
        $result['navigation'] = start_NAVIG();
        $result['answer'] = 'Главная страница';
        return $result;
    }