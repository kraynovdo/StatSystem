<?php
    function statsAF_report($dbConnect, $type, $typeValue, $limit, $query) {
        $filter = array();
        if ($type == 'match') {
            $filter['match'] = $typeValue;
            $filterStr = 'AND `match` = :match';
        }
        else {
            $filter['comp'] = $typeValue;
            $filterStr = 'AND `competition` = :comp';
        }
        $modifiedQuery = str_replace('FILTER_PLACE', $filterStr, $query);
        return common_getlist($dbConnect, $modifiedQuery, $filter);
    }
    function statsAF_rushTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, '
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
                  A.share FILTER_PLACE AND AT.code = "rush"
                GROUP BY
                person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC');
    }
    function statsAF_retTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, '
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
                  A.share FILTER_PLACE AND AT.code = "return"
                GROUP BY
                person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC');
    }

    function statsAF_passTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, '
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
                WHERE A.share FILTER_PLACE AND AT.code = "pass" AND SP_INFO.person
                GROUP BY person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC');
    }

    function statsAF_qbTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, '
            SELECT stat.*, concat(stat.rec, "/", stat.num) AS percent, P.surname, P.name, T.logo FROM (
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
                WHERE A.share FILTER_PLACE AND AT.code = "pass" AND SP_INFO.person
                GROUP BY person, team
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY sumr DESC, num ASC');
    }

    function statsAF_intTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, 'SELECT stat.*, P.surname, P.name, T.logo FROM
                (SELECT
                    count(SP.id) AS cnt, person, A.team2 AS team
                FROM
                    statperson SP LEFT JOIN statpersontype SPT ON SPT.id = SP.persontype
                        LEFT JOIN stataction A ON A.id = SP.action
                WHERE
                    A.share AND SPT.code = "intercept" FILTER_PLACE
                GROUP BY
                    person) stat
                LEFT JOIN person P ON stat.person = P.id
                            LEFT JOIN team T ON stat.team = T.id
                ORDER BY
                    cnt DESC, P.surname ASC');
    }

    function statsAF_tacTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, 'SELECT
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
                          A.share FILTER_PLACE AND SPT.code = "tackle"
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
               solo DESC, assist DESC');
    }

    function statsAF_fgTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, 'SELECT stat.*, P.surname, P.name, T.logo FROM (
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
                A.share FILTER_PLACE AND SPT.code = "fgkicker"
            GROUP BY
                person
            ) AS stat LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            ORDER BY fg DESC, pt DESC, surname ASC');
    }