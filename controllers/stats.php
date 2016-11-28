<?php
    function stats_add($dbConnect, $CONSTPath) {
        $params = array(
            'type' => $_GET['type']
        );
        $result['answer']['chartype'] = common_getlist($dbConnect,
            'SELECT id, name FROM statchartype WHERE actiontype = :type ORDER BY id', $params);

        $result['answer']['persontype'] = common_getlist($dbConnect,
            'SELECT id, name FROM statpersontype WHERE actiontype = :type ORDER BY id', $params);

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
              `stataction` A LEFT JOIN statperson SP ON SP.action = A.id
              JOIN statpersontype SPT ON SP.persontype = SPT.id AND SPT.code = "runner"
              JOIN statchar SC ON SC.action = A.id
              JOIN statchartype SCT ON SC.chartype = SCT.id AND SCT.code = "run"
              JOIN statactiontype AT ON A.actiontype = AT.id
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
            FROM `stataction` A JOIN statperson SP ON SP.action = A.id
            JOIN statpersontype SPT ON SP.persontype = SPT.id AND SPT.code = "receiver"
            JOIN statchar SC ON SC.action = A.id
            JOIN statchartype SCT ON SC.chartype = SCT.id AND SCT.code = "pass"
            JOIN statactiontype AT ON A.actiontype = AT.id
            WHERE `match` = :match AND AT.code = "pass" AND SP.person
            GROUP BY person, team
        ) AS stat
        LEFT JOIN person P ON stat.person = P.id
        LEFT JOIN team T ON stat.team = T.id
        ORDER BY sumr DESC, num ASC', array('match' => $match));

        $result['answer']['qb'] = common_getlist($dbConnect, '
            SELECT stat.*, P.surname, P.name, T.logo FROM (
                            SELECT count(A.id) AS num, sum(value) AS sumr, team, SP.person,
                sum(case WHEN rec.person IS NULL THEN 0 ELSE 1 END) AS rec,
                sum(case WHEN inter.person IS NULL THEN 0 ELSE 1 END) AS inter,
                sum(case WHEN A.pointsget = 1 THEN 1 ELSE 0 END) AS td
                FROM `stataction` A
                LEFT JOIN statperson SP ON SP.action = A.id AND SP.persontype = 2
                LEFT JOIN statperson rec ON rec.action = A.id AND rec.persontype = 5
                LEFT JOIN statperson inter ON inter.action = A.id AND inter.persontype = 6
                LEFT JOIN statchar SC ON SC.action = A.id AND SC.chartype = 12
                WHERE `match` = :match AND actiontype = 2 AND SP.person
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
                  `stataction` A JOIN statperson SP ON SP.action = A.id AND SP.persontype = 1
                    JOIN statpersontype SPT ON SP.persontype = SPT.id AND SPT.code = "runner"
                    JOIN statchar SC ON SC.action = A.id
                    JOIN statchartype SCT ON SC.chartype = SCT.id AND SCT.code = "run"
                    JOIN statactiontype AT ON A.actiontype = AT.id
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
                FROM `stataction` A JOIN statperson SP ON SP.action = A.id
                JOIN statpersontype SPT ON SP.persontype = SPT.id AND SPT.code = "receiver"
                JOIN statchar SC ON SC.action = A.id
                JOIN statchartype SCT ON SC.chartype = SCT.id AND SCT.code = "pass"
                JOIN statactiontype AT ON A.actiontype = AT.id
                WHERE competition = :comp AND AT.code = "pass" AND SP.person
                GROUP BY person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('comp' => $comp));

        $result['answer']['qb'] = common_getlist($dbConnect, '
                SELECT stat.*, P.surname, P.name, T.logo FROM (
                                SELECT count(A.id) AS num, sum(value) AS sumr, team, SP.person,
                    sum(case WHEN rec.person IS NULL THEN 0 ELSE 1 END) AS rec,
                    sum(case WHEN inter.person IS NULL THEN 0 ELSE 1 END) AS inter,
                    sum(case WHEN A.pointsget = 1 THEN 1 ELSE 0 END) AS td
                    FROM `stataction` A
                    LEFT JOIN statperson SP ON SP.action = A.id AND SP.persontype = 2
                    LEFT JOIN statperson rec ON rec.action = A.id AND rec.persontype = 5
                    LEFT JOIN statperson inter ON inter.action = A.id AND inter.persontype = 6
                    LEFT JOIN statchar SC ON SC.action = A.id AND SC.chartype = 12
                    WHERE competition = :comp AND actiontype = 2 AND SP.person
                    GROUP BY person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC', array('comp' => $comp));

        return $result;
    }