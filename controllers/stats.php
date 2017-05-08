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
            $result['answer']['return'] = common_getlist($dbConnect, '
            SELECT stat.*, P.surname, P.name, T.logo FROM (
                SELECT
                  count(A.id) AS num, sum(value) AS sumr, team, person, SUM(CASE WHEN (PG.id AND PG.point = 6) THEN 1 ELSE 0 END) AS td
                FROM
                  `stataction` A
                      LEFT JOIN (
                          SELECT
                              SP.person, SP.action
                          FROM
                              statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                          WHERE
                              SPT.code = "returner"
                      ) AS SP_INFO ON SP_INFO.action = A.id
                      LEFT JOIN (
                          SELECT
                              SC.value, SC.action
                          FROM
                              statchar SC LEFT JOIN statchartype SCT ON SC.chartype = SCT.id
                          WHERE
                              SCT.code = "retyds"
                      ) AS SC_INFO ON SC_INFO.action = A.id

                      LEFT JOIN statactiontype AT ON A.actiontype = AT.id
                      LEFT JOIN pointsget PG ON PG.id = A.pointsget
                WHERE
                  A.share AND `match` = :match AND AT.code = "return"
                GROUP BY
                person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('match' => $match));
            $stats['return'] = $result['answer']['return'];
        }

        if ($stats['rush']) {
            $result['answer']['rush'] = $stats['rush'];
        }
        else {
            $result['answer']['rush'] = common_getlist($dbConnect, '
            SELECT stat.*, P.surname, P.name, T.logo FROM (
                SELECT
                  count(A.id) AS num, sum(value) AS sumr, team, person, SUM(CASE WHEN (PG.id AND PG.point = 6) THEN 1 ELSE 0 END) AS td
                FROM
                  `stataction` A
                      LEFT JOIN (
                          SELECT
                              SP.person, SP.action
                          FROM
                              statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                          WHERE
                              SPT.code = "runner"
                      ) AS SP_INFO ON SP_INFO.action = A.id
                      LEFT JOIN (
                          SELECT
                              SC.value, SC.action
                          FROM
                              statchar SC LEFT JOIN statchartype SCT ON SC.chartype = SCT.id
                          WHERE
                              SCT.code = "runyds"
                      ) AS SC_INFO ON SC_INFO.action = A.id

                      LEFT JOIN statactiontype AT ON A.actiontype = AT.id
                      LEFT JOIN pointsget PG ON PG.id = A.pointsget
                WHERE
                  A.share AND `match` = :match AND AT.code = "rush"
                GROUP BY
                person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('match' => $match));
            $stats['rush'] = $result['answer']['rush'];
        }
        if ($stats['pass']) {
            $result['answer']['pass'] = $stats['pass'];
        }
        else {
            $result['answer']['pass'] = common_getlist($dbConnect, '
            SELECT stat.*, P.surname, P.name, T.logo FROM (
                SELECT count(A.id) AS num, sum(value) AS sumr, team, person, SUM(CASE WHEN (PG.id AND PG.point = 6) THEN 1 ELSE 0 END) AS td
                FROM `stataction` A
                    LEFT JOIN (
                          SELECT
                              SP.person, SP.action
                          FROM
                              statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                          WHERE
                              SPT.code = "receiver"
                      ) AS SP_INFO ON SP_INFO.action = A.id
                    LEFT JOIN (
                          SELECT
                              SC.value, SC.action
                          FROM
                              statchar SC LEFT JOIN statchartype SCT ON SC.chartype = SCT.id
                          WHERE
                              SCT.code = "passyds"
                      ) AS SC_INFO ON SC_INFO.action = A.id
                LEFT JOIN statactiontype AT ON A.actiontype = AT.id
                LEFT JOIN pointsget PG ON PG.id = A.pointsget
                WHERE A.share AND `match` = :match AND AT.code = "pass" AND SP_INFO.person
                GROUP BY person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('match' => $match));
            $stats['pass'] = $result['answer']['pass'];
        }
        if ($stats['qb']) {
            $result['answer']['qb'] = $stats['qb'];
        }
        else {
            $result['answer']['qb'] = common_getlist($dbConnect, '
            SELECT stat.*, P.surname, P.name, T.logo FROM (
                            SELECT count(A.id) AS num, sum(value) AS sumr, team, SP_INFO.person,
                sum(case WHEN REC_INFO.person IS NULL THEN 0 ELSE 1 END) AS rec,
                sum(case WHEN INT_INFO.person IS NULL THEN 0 ELSE 1 END) AS inter,
                sum(case WHEN A.pointsget = 1 THEN 1 ELSE 0 END) AS td
                FROM `stataction` A
                  LEFT JOIN (
                      SELECT
                          SP.person, SP.action
                      FROM
                          statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                      WHERE
                          SPT.code = "passer"
                  ) AS SP_INFO ON SP_INFO.action = A.id
                  LEFT JOIN (
                      SELECT
                          SP.person, SP.action
                      FROM
                          statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                      WHERE
                          SPT.code = "receiver"
                  ) AS REC_INFO ON REC_INFO.action = A.id
                  LEFT JOIN (
                      SELECT
                          SP.person, SP.action
                      FROM
                          statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                      WHERE
                          SPT.code = "intercept"
                  ) AS INT_INFO ON INT_INFO.action = A.id
                LEFT JOIN (
                      SELECT
                          SC.value, SC.action
                      FROM
                          statchar SC LEFT JOIN statchartype SCT ON SC.chartype = SCT.id
                      WHERE
                          SCT.code = "passyds"
                  ) AS SC_INFO ON SC_INFO.action = A.id
                  LEFT JOIN statactiontype AT ON A.actiontype = AT.id
                WHERE A.share AND `match` = :match AND AT.code = "pass" AND SP_INFO.person
                GROUP BY person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('match' => $match));
            $stats['qb'] = $result['answer']['qb'];
        }
        if ($stats['int']) {
            $result['answer']['int'] = $stats['int'];
        }
        else {
            $result['answer']['int'] = common_getlist($dbConnect, 'SELECT stat.*, P.surname, P.name, T.logo FROM
                (SELECT
                    count(SP.id) AS cnt, person, A.team2 AS team
                FROM
                    statperson SP LEFT JOIN statpersontype SPT ON SPT.id = SP.persontype
                        LEFT JOIN stataction A ON A.id = SP.action
                WHERE
                    A.share AND SPT.code = "intercept" AND A.`match` = :match
                GROUP BY
                    person) stat
                LEFT JOIN person P ON stat.person = P.id
                            LEFT JOIN team T ON stat.team = T.id
                ORDER BY
                    cnt DESC, P.surname ASC', array(
                    'match' => $match
            ));
            $stats['int'] = $result['answer']['int'];
        }
        if ($stats['tac']) {
            $result['answer']['tac'] = $stats['tac'];
        }
        else {
            $result['answer']['tac'] = common_getlist($dbConnect, 'SELECT
              TT.logo, stat.solo, stat.assist, P.name, P.surname, TT.id AS team
            FROM
              (SELECT
                person, team2, SUM(case WHEN tcount = 1 THEN 1 ELSE 0 END) AS solo,
                      SUM(case WHEN tcount = 1 THEN 0 ELSE 1 END) AS assist
              FROM (

                  SELECT
                          A.id, count(A.id) AS tcount
                  FROM
                          stataction A LEFT JOIN statperson SP ON SP.action = A.id
                          LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                  WHERE
                          A.share AND `match` = :match AND SPT.code = "tackle"
                  GROUP BY
                           A.id
              ) T JOIN stataction A2 ON A2.id = T.id
               JOIN statperson SP2 ON SP2.action = A2.id
                          JOIN statpersontype SPT2 ON SP2.persontype = SPT2.id
               WHERE SPT2.code = "tackle"
               GROUP BY person, team2) stat
            LEFT JOIN
               team TT ON stat.team2 = TT.id
            LEFT JOIN
               person P ON P.id = stat.person
            ORDER BY
               solo DESC, assist DESC', array(
                'match' => $match
            ));
            $stats['tac'] = $result['answer']['tac'];
        }
        if ($stats['fg']) {
            $result['answer']['fg'] = $stats['fg'];
        }
        else {
            $result['answer']['fg'] = common_getlist($dbConnect, 'SELECT stat.*, P.surname, P.name, T.logo FROM (
            SELECT
                person, team,
                    SUM(1) AS numr,
                    SUM(CASE 1 WHEN PG.point = 3 THEN 1 ELSE 0 END) AS fg,
                    SUM(CASE 1 WHEN PG.point = 1 THEN 1 ELSE 0 END) AS pt
            FROM
                statperson SP LEFT JOIN statpersontype SPT ON SPT.id = SP.persontype
                    LEFT JOIN stataction A ON A.id = SP.action
                    LEFT JOIN pointsget PG ON PG.id = A.pointsget
            WHERE
                A.share AND A.`match` = :match AND SPT.code = "fgkicker"
            GROUP BY
                person
            ) AS stat LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY fg DESC, pt DESC, surname ASC', array(
                'match' => $match
            ));
            $stats['fg'] = $result['answer']['fg'];
        }
        if (function_exists('memcache_set')) {
            memcache_set($mc, 'stats_match_'.$match, $stats, 0, 60);
        }

        return $result;
    }

    function stats_compAF($dbConnect, $CONSTPath) {
        $comp = $_GET['comp'];
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');
        $result = array(
            'answer' => array(),
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
        );

        $result['answer']['match'] = match_mainInfo($dbConnect, $CONSTPath);
        $result['answer']['rush'] = common_getlist($dbConnect, '
            SELECT stat.*, P.surname, P.name, T.logo FROM (
                SELECT
                  count(A.id) AS num, sum(value) AS sumr, team, person
                FROM
                  `stataction` A
                      LEFT JOIN (
                          SELECT
                              SP.person, SP.action
                          FROM
                              statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                          WHERE
                              SPT.code = "runner"
                      ) AS SP_INFO ON SP_INFO.action = A.id
                      LEFT JOIN (
                          SELECT
                              SC.value, SC.action
                          FROM
                              statchar SC LEFT JOIN statchartype SCT ON SC.chartype = SCT.id
                          WHERE
                              SCT.code = "runyds"
                      ) AS SC_INFO ON SC_INFO.action = A.id

                      LEFT JOIN statactiontype AT ON A.actiontype = AT.id
                WHERE
                  A.share AND competition = :comp AND AT.code = "rush"
                GROUP BY
                person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('comp' => $comp));

        $result['answer']['pass'] = common_getlist($dbConnect, '
            SELECT stat.*, P.surname, P.name, T.logo FROM (
                SELECT count(A.id) AS num, sum(value) AS sumr, team, person
                FROM `stataction` A
                    LEFT JOIN (
                          SELECT
                              SP.person, SP.action
                          FROM
                              statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                          WHERE
                              SPT.code = "receiver"
                      ) AS SP_INFO ON SP_INFO.action = A.id
                    LEFT JOIN (
                          SELECT
                              SC.value, SC.action
                          FROM
                              statchar SC LEFT JOIN statchartype SCT ON SC.chartype = SCT.id
                          WHERE
                              SCT.code = "passyds"
                      ) AS SC_INFO ON SC_INFO.action = A.id
                    LEFT JOIN statactiontype AT ON A.actiontype = AT.id
                WHERE A.share AND competition = :comp AND AT.code = "pass" AND SP_INFO.person
                GROUP BY person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('comp' => $comp));

        $result['answer']['qb'] = common_getlist($dbConnect, '
                SELECT stat.*, P.surname, P.name, T.logo FROM (
                                SELECT count(A.id) AS num, sum(value) AS sumr, team, SP_INFO.person,
                    sum(case WHEN REC_INFO.person IS NULL THEN 0 ELSE 1 END) AS rec,
                    sum(case WHEN INT_INFO.person IS NULL THEN 0 ELSE 1 END) AS inter,
                    sum(case WHEN A.pointsget = 1 THEN 1 ELSE 0 END) AS td
                    FROM `stataction` A
                      LEFT JOIN (
                          SELECT
                              SP.person, SP.action
                          FROM
                              statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                          WHERE
                              SPT.code = "passer"
                      ) AS SP_INFO ON SP_INFO.action = A.id
                      LEFT JOIN (
                          SELECT
                              SP.person, SP.action
                          FROM
                              statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                          WHERE
                              SPT.code = "receiver"
                      ) AS REC_INFO ON REC_INFO.action = A.id
                      LEFT JOIN (
                          SELECT
                              SP.person, SP.action
                          FROM
                              statperson SP LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                          WHERE
                              SPT.code = "intercept"
                      ) AS INT_INFO ON INT_INFO.action = A.id
                    LEFT JOIN (
                          SELECT
                              SC.value, SC.action
                          FROM
                              statchar SC LEFT JOIN statchartype SCT ON SC.chartype = SCT.id
                          WHERE
                              SCT.code = "passyds"
                      ) AS SC_INFO ON SC_INFO.action = A.id
                      LEFT JOIN statactiontype AT ON A.actiontype = AT.id
                    WHERE A.share AND competition = :comp AND AT.code = "pass" AND SP_INFO.person
                    GROUP BY person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('comp' => $comp));

            $result['answer']['tackle'] = common_getlist($dbConnect, 'SELECT
              TT.logo, stat.solo, stat.assist, P.name, P.surname
            FROM
              (SELECT
                person, team2, SUM(case WHEN tcount = 1 THEN 1 ELSE 0 END) AS solo,
                      SUM(case WHEN tcount = 1 THEN 0 ELSE 1 END) AS assist
              FROM (

                  SELECT
                          A.id, count(A.id) AS tcount
                  FROM
                          stataction A LEFT JOIN statperson SP ON SP.action = A.id
                          LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                  WHERE
                          A.share AND competition = :comp AND SPT.code = "tackle"
                  GROUP BY
                           A.id
              ) T JOIN stataction A2 ON A2.id = T.id
               JOIN statperson SP2 ON SP2.action = A2.id
                          JOIN statpersontype SPT2 ON SP2.persontype = SPT2.id
               WHERE SPT2.code = "tackle"
               GROUP BY person, team2) stat
            LEFT JOIN
               team TT ON stat.team2 = TT.id
            LEFT JOIN
               person P ON P.id = stat.person
            ORDER BY
               solo DESC, assist DESC', array('comp' => $comp));

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

