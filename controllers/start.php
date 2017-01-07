<?php
    function start_NAVIG() {
        $navig_arr = array(
            'code' => 'main'
        );
        return $navig_arr;
    }
    function start_index($dbConnect, $CONSTPath){
        $result = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/news.php');
        $news = news_index($dbConnect, $CONSTPath);
        $result['answer']['news'] = $news['answer'];
        $result['navigation'] = start_NAVIG();
        return $result;
    }