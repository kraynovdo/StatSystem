<?php
    function start_NAVIG() {
        $navig_arr = array(
                'Новости' => '/?r=news',
                'Команды' => '/?r=team',
                //'Документы' => '/?r=document',
                'Кубок России' => 'http://cup2015.amfoot.net',
                'Чемпионат России' => 'http://champ2015.amfoot.net'

        );
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $navig_arr['Чемпионат России'] = '/?r=competition/view&comp=1';
        }

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