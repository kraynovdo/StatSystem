<?php
    function matchcenter_index ($dbConnect, $CONSTPath) {
        $result = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        $navigation = competition_lafNavig();
        $result['navigation'] = $navigation;

        $result['answer'] = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');
        $result['answer']['maininfo'] = match_mainInfo($dbConnect, $CONSTPath);

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/action.php');
        $result['answer']['action'] = action_listInMatch($dbConnect, $CONSTPath, $_GET['match']);

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

    function matchcenter_roster ($dbConnect, $CONSTPath) {
        $result = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        $navigation = competition_lafNavig();
        $result['navigation'] = $navigation;

        $result['answer'] = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');
        $maininfo = match_mainInfo($dbConnect, $CONSTPath);
        $result['answer']['maininfo'] = $maininfo;

        $team1 = $maininfo['team1'];
        $team2 = $maininfo['team2'];

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/matchroster.php');
        $team1roster = matchroster_index($dbConnect, $CONSTPath, $team1);
        $team2roster = matchroster_index($dbConnect, $CONSTPath, $team2);
        $result['answer']['team1roster'] = $team1roster['answer'];
        $result['answer']['team2roster'] = $team2roster['answer'];

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/roster.php');
        $result['answer']['face1'] = rosterface_list($dbConnect, $CONSTPath, $team1, $_GET['comp']);
        $result['answer']['face2'] = rosterface_list($dbConnect, $CONSTPath, $team2, $_GET['comp']);

        return $result;
    }