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

    function matchcenter_protocol ($dbConnect, $CONSTPath) {
        $result = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        $navigation = competition_lafNavig();
        $result['navigation'] = $navigation;

        $result['answer'] = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');
        $result['answer']['maininfo'] = match_mainInfo($dbConnect, $CONSTPath);

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/protocol.php');
        $result['answer']['protocol'] = protocol_own($dbConnect, $_GET['match']);

        return $result;
    }