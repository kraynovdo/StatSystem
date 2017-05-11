<?php
    function stats_add($dbConnect, $CONSTPath) {
        $params = array(
            'type' => $_GET['type']
        );
        $result['answer']['action'] = common_getrecord($dbConnect,
            'SELECT id, name, code FROM statactiontype WHERE id = :type', $params);
        $result['answer']['chartype'] = common_getlist($dbConnect,
            'SELECT id, name, code FROM statchartype WHERE actiontype = :type ORDER BY id', $params);

        $result['answer']['persontype'] = common_getlist($dbConnect,
            'SELECT id, name, code, offdef FROM statpersontype WHERE actiontype = :type ORDER BY id', $params);

        $result['answer']['point'] = common_getlist($dbConnect,
            'SELECT
                    P.id, S.pointsget, P.name
                 FROM
                    statpoint S LEFT JOIN pointsget P ON P.id = S.pointsget
                 WHERE actiontype = :type ORDER BY id', $params);
        return $result;
    }

    function stats_matchAF($dbConnect, $CONSTPath) {
        $match = $_GET['match'];
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');
        $result = array(
            'answer' => array(),
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
        );

        $result['answer']['match'] = match_mainInfo($dbConnect, $CONSTPath);

        if (function_exists('memcache_connect')) {
            $mc = memcache_connect('localhost', 11211);
            $stats = memcache_get($mc, 'stats_match_' . $match);
        }

        if ($stats['return']) {
            $result['answer']['return'] = $stats['return'];
        }
        else {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
            $result['answer']['return'] = statsAF_retTop($dbConnect, 'match', $_GET['match']);
            $stats['return'] = $result['answer']['return'];
        }

        if ($stats['rush']) {
            $result['answer']['rush'] = $stats['rush'];
        }
        else {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
            $result['answer']['rush'] = statsAF_rushTop($dbConnect, 'match', $_GET['match']);
            $stats['rush'] = $result['answer']['rush'];
        }
        if ($stats['pass']) {
            $result['answer']['pass'] = $stats['pass'];
        }
        else {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
            $result['answer']['pass'] = statsAF_passTop($dbConnect, 'match', $_GET['match']);
            $stats['pass'] = $result['answer']['pass'];
        }
        if ($stats['qb']) {
            $result['answer']['qb'] = $stats['qb'];
        }
        else {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
            $result['answer']['qb'] = statsAF_qbTop($dbConnect, 'match', $_GET['match']);
            $stats['qb'] = $result['answer']['qb'];
        }
        if ($stats['int']) {
            $result['answer']['int'] = $stats['int'];
        }
        else {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
            $result['answer']['int'] = statsAF_intTop($dbConnect, 'match', $_GET['match']);
            $stats['int'] = $result['answer']['int'];
        }
        if ($stats['tac']) {
            $result['answer']['tac'] = $stats['tac'];
        }
        else {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
            $result['answer']['tac'] = statsAF_tacTop($dbConnect, 'match', $_GET['match']);
            $stats['tac'] = $result['answer']['tac'];
        }
        if ($stats['fg']) {
            $result['answer']['fg'] = $stats['fg'];
        }
        else {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
            $result['answer']['fg'] = statsAF_fgTop($dbConnect, 'match', $_GET['match']);
            $stats['fg'] = $result['answer']['fg'];
        }
        if (function_exists('memcache_set')) {
            memcache_set($mc, 'stats_match_'.$match, $stats, 0, 60);
        }

        return $result;
    }

    function stats_compAF($dbConnect, $CONSTPath) {
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');
        $result = array(
            'answer' => array(),
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
        );

        $result['answer']['match'] = match_mainInfo($dbConnect, $CONSTPath);
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
        $result['answer']['rush'] = statsAF_rushTop($dbConnect, 'comp', $_GET['comp']);
        $result['answer']['pass'] = statsAF_passTop($dbConnect, 'comp', $_GET['comp']);
        $result['answer']['qb'] = statsAF_qbTop($dbConnect, 'comp', $_GET['comp']);
        $result['answer']['tackle'] = statsAF_tacTop($dbConnect, 'comp', $_GET['comp']);

        return $result;
    }


    function stats_screenAF ($dbConnect, $CONSTPath, $IS_MOBILE) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4) || ($_SESSION['userType'] == 5)) {
            $answer = array();
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');

            if (!$IS_MOBILE) {
                $plBpl = match_playbyplayAF($dbConnect, $CONSTPath, $_GET['match'], 1);
                $answer['event'] = $plBpl['answer']['event'];

                $matchinfo = $plBpl['answer']['match'];
            }
            else {
                $matchinfo = match_mainInfo($dbConnect, $CONSTPath);
            }
            $answer['matchInfo'] = $matchinfo;

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/screenAF.php');
            $teamCookie = $_COOKIE['stats-' . $_GET['match'] . '-team'];
            $teamID = $teamCookie ? $teamCookie : $matchinfo['team1'];
            $answer['teamID'] = $teamID;


            $rosters = array();




            $roster = screenAF_listplayers($dbConnect, $CONSTPath, $_GET['match'], $matchinfo['team1']);
            $rosters[$matchinfo['team1']] = $roster;
            $roster = screenAF_listplayers($dbConnect, $CONSTPath, $_GET['match'], $matchinfo['team2']);
            $rosters[$matchinfo['team2']] = $roster;
            $answer['rosters'] = $rosters;



            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statconfig.php');
            $answer['statconfig'] = statconfig_list($dbConnect, $CONSTPath);

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
            $result = array(
                'answer' => $answer,
                'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
            );
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function stats_share($dbConnect) {
        $data = common_getrecord($dbConnect, '
                    SELECT
                      share
                    FROM
                      stataction AS A
                    WHERE
                      `match` = :id
                    LIMIT 1', array(
            'id' => $_POST['match']
        ));
        if (count($data)) {
            $oldShare = $data['share'];
            $share = 1 - $oldShare;

            $match = $_POST['match'];
            common_query($dbConnect, '
                    UPDATE
                      stataction
                    SET share = :share WHERE `match` = :id', array(
                'id' => $match,
                'share' => $share
            ));
            return $share."";
        }
    }

