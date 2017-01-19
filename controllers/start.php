<?php
    function start_NAVIG() {
        $navig_arr = array(
            'code' => 'main',
            'title' => 'Федерация Американского Футбола России',
            'description' => 'Официальный сайт Федерации Американского Футбола России (ФАФР). Здесь вы можете найти свежие новости, информацию о соревнованиях и командах',
            'keywords' => array('Федерация Американского Футбола России', 'ФАФР')
        );
        return $navig_arr;
    }
    function start_index($dbConnect, $CONSTPath){
        $result = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/news.php');
        $news = news_index($dbConnect, $CONSTPath);
        $result['answer']['news'] = $news['answer'];
        $newsmain = news_index($dbConnect, $CONSTPath, true);
        $result['answer']['newsmain'] = $newsmain['answer'];
        $result['navigation'] = start_NAVIG();
        return $result;
    }