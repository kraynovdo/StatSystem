<?php
    function matchcenter_index ($dbConnect, $CONSTPath) {
        $result = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        $navigation = competition_lafNavig();
        $result['navigation'] = $navigation;

        $result['answer'] = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');
        $result['answer']['maininfo'] = match_mainInfo($dbConnect, $CONSTPath);

        return $result;
    }