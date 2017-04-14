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
              `match` = :match AND AT.code = "rush"
            GROUP BY
            person, team
        ) AS stat
        LEFT JOIN person P ON stat.person = P.id
        LEFT JOIN team T ON stat.team = T.id
        ORDER BY sumr DESC, num ASC', array('match' => $match));

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
            WHERE `match` = :match AND AT.code = "pass" AND SP_INFO.person
            GROUP BY person, team
        ) AS stat
        LEFT JOIN person P ON stat.person = P.id
        LEFT JOIN team T ON stat.team = T.id
        ORDER BY sumr DESC, num ASC', array('match' => $match));

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
                WHERE `match` = :match AND AT.code = "pass" AND SP_INFO.person
                GROUP BY person, team
        ) AS stat
        LEFT JOIN person P ON stat.person = P.id
        LEFT JOIN team T ON stat.team = T.id
        ORDER BY sumr DESC, num ASC', array('match' => $match));



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
                  competition = :comp AND AT.code = "rush"
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
                WHERE competition = :comp AND AT.code = "pass" AND SP_INFO.person
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
                    WHERE competition = :comp AND AT.code = "pass" AND SP_INFO.person
                    GROUP BY person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('comp' => $comp));

        return $result;
    }


    function stats_screenAF ($dbConnect, $CONSTPath, $IS_MOBILE) {
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

