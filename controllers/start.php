<?php
    function start_NAVIG() {
        $navig_arr = array(
            'Главная' => '/',
            'Фафр' => '/',
            'Турниры' => '/',
            'Сборные' => '/',
            'Регионы' => '/'
        );
        return $navig_arr;
    }
    function start_index(){
        $result = array();
        $result['navigation'] = start_NAVIG();
        $result['answer'] = 'Главная страница';
        return $result;
    }