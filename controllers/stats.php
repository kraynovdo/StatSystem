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

        $fromCache = true;
        if (function_exists('memcache_connect')) {
            $mc = memcache_connect('localhost', 11211);
            $stats = memcache_get($mc, 'stats_match_' . $match);
        }
        else {
            $stats = array();
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');

        if (!$stats['return']) {
            $fromCache = false;
            $stats['return'] = statsAF_retTop($dbConnect, 'match', $_GET['match']);
        }
        $result['answer']['return'] = $stats['return'];

        if (!$stats['rush']) {
            $stats['rush'] = statsAF_rushTop($dbConnect, 'match', $_GET['match']);
        }
        $result['answer']['rush'] = $stats['rush'];

        if (!$stats['pass']) {
            $stats['pass'] = statsAF_passTop($dbConnect, 'match', $_GET['match']);
        }
        $result['answer']['pass'] = $stats['pass'];

        if (!$stats['qb']) {
            $stats['qb'] = statsAF_qbTop($dbConnect, 'match', $_GET['match']);
        }
        $result['answer']['qb'] = $stats['qb'];

        if (!$stats['int']) {
            $stats['int'] = statsAF_intTop($dbConnect, 'match', $_GET['match']);
        }
        $result['answer']['int'] = $stats['int'];

        if (!$stats['tac']) {
            $stats['tac'] = statsAF_tacTop($dbConnect, 'match', $_GET['match']);
        }
        $result['answer']['tac'] = $stats['tac'];

        if (!$stats['sack']) {
            $stats['sack'] = statsAF_sackTop($dbConnect, 'match', $_GET['match']);
        }
        $result['answer']['sack'] = $stats['sack'];

        if (!$stats['fg']) {
            $stats['fg'] = statsAF_fgTop($dbConnect, 'match', $_GET['match']);
        }
        $result['answer']['fg'] = $stats['fg'];

        if (!$fromCache && function_exists('memcache_set')) {
            memcache_set($mc, 'stats_match_'.$match, $stats, 0, 60);
        }

        return $result;
    }

    function stats_compAF($dbConnect, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        $result = array(
            'answer' => array(),
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
        );

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
        switch ($_GET['type']) {
            case 'rush' : $result['answer']['rush'] = statsAF_rushTop($dbConnect, 'comp', $_GET['comp'], null); break;
            case 'pass' : $result['answer']['pass'] = statsAF_passTop($dbConnect, 'comp', $_GET['comp'], null); break;
            case 'qb' : $result['answer']['qb'] = statsAF_qbTop($dbConnect, 'comp', $_GET['comp'], null); break;
            case 'ret' : $result['answer']['ret'] = statsAF_retTop($dbConnect, 'comp', $_GET['comp'], null); break;
            case 'int' : $result['answer']['int'] = statsAF_intTop($dbConnect, 'comp', $_GET['comp'], null); break;
            case 'tac' : $result['answer']['tac'] = statsAF_tacTop($dbConnect, 'comp', $_GET['comp'], null); break;
            case 'sack' : $result['answer']['sack'] = statsAF_sackTop($dbConnect, 'comp', $_GET['comp'], null); break;
            case 'fg' : $result['answer']['fg'] = statsAF_fgTop($dbConnect, 'comp', $_GET['comp'], null); break;
            default:


            $fromCache = true;
            if (function_exists('memcache_connect')) {
                $mc = memcache_connect('localhost', 11211);
                $stats = memcache_get($mc, 'stats_comp_' . $_GET['comp']);
            }
            else {
                $stats = array();
            }

            if (!$stats || !count($stats)) {
                $fromCache = false;
                $stats = array (
                    'rush' => statsAF_rushTop($dbConnect, 'comp', $_GET['comp'], 5),
                    'pass' => statsAF_passTop($dbConnect, 'comp', $_GET['comp'], 5),
                    'ret' => statsAF_retTop($dbConnect, 'comp', $_GET['comp'], 5),
                    'qb' => statsAF_qbTop($dbConnect, 'comp', $_GET['comp'], 5),
                    'tac' => statsAF_tacTop($dbConnect, 'comp', $_GET['comp'], 5),
                    'sack' => statsAF_sackTop($dbConnect, 'comp', $_GET['comp'], 5),
                    'int' => statsAF_intTop($dbConnect, 'comp', $_GET['comp'], 5),
                    'fg' => statsAF_fgTop($dbConnect, 'comp', $_GET['comp'], 5)
                );
            }

            $result['answer']['rush'] = $stats['rush'];
            $result['answer']['pass'] = $stats['pass'];;
            $result['answer']['ret'] = $stats['ret'];
            $result['answer']['qb'] = $stats['qb'];
            $result['answer']['tac'] = $stats['tac'];
            $result['answer']['sack'] = $stats['sack'];
            $result['answer']['int'] = $stats['int'];
            $result['answer']['fg'] = $stats['fg'];
            if (function_exists('memcache_set') && !$fromCache) {
                memcache_set($mc, 'stats_comp_'.$_GET['comp'], $stats, 0, 300);
            }
        }
        return $result;
    }

    function stats_personAF ($dbConnect, $CONSTPath, $person, $comp) {
        $result = array(
            'answer' => array()
        );
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
        $arg = array('person' => $_GET['person'], 'comp' => $comp);
        $result['answer']['stats'] = array(
            'rush' => statsAF_rushTop($dbConnect, 'person', $arg),
            'pass' => statsAF_passTop($dbConnect, 'person', $arg),
            'ret' => statsAF_retTop($dbConnect, 'person', $arg),
            'qb' => statsAF_qbTop($dbConnect, 'person', $arg),
            'int' => statsAF_intTop($dbConnect, 'person', $arg),
            'tac' => statsAF_tacTop($dbConnect, 'person', $arg),
            'sack' => statsAF_sackTop($dbConnect, 'person', $arg),
            'fg' => statsAF_fgTop($dbConnect, 'person', $arg)
        );

        return $result;
    }

    function stats_teamAF($dbConnect, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
        $comps = team_comps($dbConnect, $_GET['team']);

        $stats_type = 1;
        $compId = null;
        for ($i = 0; $i < count($comps); $i++) {
            if ($comps[$i]['id'] == $_GET['comp']) {
                $stats_type = $comps[$i]['stats_type'];
                $compId = $_GET['comp'];
            }
        }

        if (!$compId && count($comps)) {
            $compId = $comps[0]['id'];
            $stats_type = $comps[0]['stats_type'];
        }

        $result = array(
            'answer' => array(
                'comps' => $comps,
                'compId' => $compId
            )
        );
        $result['navigation'] = team_NAVIG($dbConnect, $_GET['team'], count($comps));

        if ($compId && $stats_type == 3) {


            if (function_exists('memcache_connect')) {
                $mc = memcache_connect('localhost', 11211);
                $stats = memcache_get($mc, 'stats_team_' . $_GET['team'] . '_' . $compId);
            }
            else {
                $stats = array();
            }
            if (!$stats || !count($stats)) {
                $fromCache = false;
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
                $arg = array('team' => $_GET['team'], 'comp' => $compId);
                $stats = array(
                    'rush' => statsAF_rushTop($dbConnect, 'team', $arg),
                    'pass' => statsAF_passTop($dbConnect, 'team', $arg),
                    'ret' => statsAF_retTop($dbConnect, 'team', $arg),
                    'qb' => statsAF_qbTop($dbConnect, 'team', $arg),
                    'int' => statsAF_intTop($dbConnect, 'team', $arg),
                    'tac' => statsAF_tacTop($dbConnect, 'team', $arg),
                    'sack' => statsAF_sackTop($dbConnect, 'team', $arg),
                    'fg' => statsAF_fgTop($dbConnect, 'team', $arg)
                );
            }
            $result['answer']['stats'] = $stats;
            if (function_exists('memcache_set') && !$fromCache) {
                memcache_set($mc, 'stats_team_'.$_GET['team'] . '_' . $_GET['comp'], $stats, 0, 60);
            }
        }
        if ($compId && $stats_type == 2) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/action.php');
            $result['answer']['points'] = action_teamstats($dbConnect, $CONSTPath, $_GET['team'], $compId);
        }

        $result['answer']['stats_type'] = $stats_type;

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

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/admin.php');
            $result = array(
                'answer' => $answer,
                'navigation' => admin_NAVIG($dbConnect, $_GET['comp'])
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

