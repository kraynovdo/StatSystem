<?php
    //OK
    function error_index ($code) {
        $text = '';
        switch($code) {
            case 404: $text = 'Страница не найдена'; break;
            case 403: $text = 'Доступ запрещен'; break;
        };
        $result = array();
        $result['navigation'] = array(
            'header' => 'Упс!',
            'menu' => array()
        );
        $result['answer'] = array(
            'code' => $code,
            'text' => $text
        );
        return $result;
    }