<?php
    function statsAF_report($dbConnect, $type, $typeValue, $limit, $query) {
        $filter = array();
        $personFilterStr = '';
        if ($type == 'match') {
            $filter['match'] = $typeValue;
            $filterStr = 'AND `match` = :match';
        }
        else if ($type == 'person'){
            $filter['person'] = $typeValue['person'];
            $filter['comp'] = $typeValue['comp'];
            $filterStr = 'AND `competition` = :comp';
            $personFilterStr = ' AND stat.`person` = :person';
        } else {
            $filter['comp'] = $typeValue;
            $filterStr = 'AND `competition` = :comp';
        }

        $modifiedQuery = str_replace('PERSON-FILTER_PLACE', $personFilterStr, $query);
        $modifiedQuery = str_replace('FILTER_PLACE', $filterStr, $modifiedQuery);

        if ($limit) {
            $modifiedQuery = str_replace('LIMIT_PLACE', ' LIMIT 0, '.$limit, $modifiedQuery);
        }
        else {
            $modifiedQuery = str_replace('LIMIT_PLACE', ''.$limit, $modifiedQuery);
        }
        if ($type == 'person') {
            return common_getrecord($dbConnect, $modifiedQuery, $filter);
        }
        else {
            return common_getlist($dbConnect, $modifiedQuery, $filter);
        }
    }
    function statsAF_rushTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, '
            SELECT stat.*, ROUND(stat.sumr/stat.num,1) AS avg, P.surname, P.name, T.logo, P.avatar, P.id FROM (
                SELECT
                  count(A.id) AS num, sum(value) AS sumr,
                  team, person,
                  SUM(CASE WHEN (PG.id AND PG.code = "td") THEN 1 ELSE 0 END) AS td,
                  SUM(CASE WHEN (PG.id AND PG.code = "2pt") THEN 1 ELSE 0 END) AS 2pt
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
                ORDER BY sumr DESC, num ASC
                LIMIT_PLACE
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            WHERE true PERSON-FILTER_PLACE
            ');
    }
    function statsAF_retTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit,  '
            SELECT stat.*, P.surname, P.name, T.logo, P.avatar, P.id FROM (
                SELECT
                  count(A.id) AS num, sum(value) AS sumr, team, person,
                  SUM(CASE WHEN (PG.id AND PG.code = "td") THEN 1 ELSE 0 END) AS td,
                  SUM(CASE WHEN (PG.id AND PG.code = "2pt") THEN 1 ELSE 0 END) AS 2pt
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
                ORDER BY sumr DESC, num ASC
                LIMIT_PLACE
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            WHERE true PERSON-FILTER_PLACE
            ');
    }

    function statsAF_passTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, '
            SELECT stat.*, ROUND(stat.sumr/stat.num,1) AS avg, P.surname, P.name, T.logo, P.avatar, P.id FROM (
                SELECT count(A.id) AS num, sum(value) AS sumr, team, person,
                SUM(CASE WHEN (PG.id AND PG.code = "td") THEN 1 ELSE 0 END) AS td,
                SUM(CASE WHEN (PG.id AND PG.code = "2pt") THEN 1 ELSE 0 END) AS 2pt
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
                ORDER BY sumr DESC, num ASC
                LIMIT_PLACE
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            WHERE true PERSON-FILTER_PLACE
            ');
    }

    function statsAF_qbTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, '
            SELECT stat.*,
                (CASE WHEN stat.num >= 10 THEN
                ROUND(((8.4 * stat.sumr) + (330 * stat.td) + (100 * stat.rec) - (200 * stat.inter)) / stat.num, 1)
                ELSE NULL END) AS rate,
                P.surname, P.name, T.logo, P.avatar, P.id
            FROM (
                SELECT statInner.*, concat(statInner.rec, "/", statInner.num) AS percent FROM (
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
                ) AS statInner
            ) AS stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            WHERE true PERSON-FILTER_PLACE
            ORDER BY rate DESC, sumr DESC, P.surname DESC
            LIMIT_PLACE
            ');
    }

    function statsAF_intTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit,'
            SELECT stat.*, P.surname, P.name, T.logo, P.avatar, P.id FROM
                (SELECT
                    count(SP.id) AS cnt, person, A.team2 AS team
                FROM
                    statperson SP LEFT JOIN statpersontype SPT ON SPT.id = SP.persontype
                        LEFT JOIN stataction A ON A.id = SP.action
                WHERE
                    A.share AND SPT.code = "intercept" FILTER_PLACE
                GROUP BY
                    person
                ORDER BY
                    cnt DESC
                LIMIT_PLACE) stat
            LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            WHERE true PERSON-FILTER_PLACE
            ');
    }

    function statsAF_tacTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, 'SELECT
              TT.rus_abbr, stat.solo, stat.assist, stat.common, P.name, P.surname, TT.id AS team, TT.logo, P.avatar, P.id
            FROM
              (SELECT stat_inner.*, solo+assist AS common
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
                   GROUP BY person, team2

                   ) stat_inner
                   ORDER BY common DESC, solo DESC
                   LIMIT_PLACE
               ) stat

            LEFT JOIN
               team TT ON stat.team2 = TT.id
            LEFT JOIN
               person P ON P.id = stat.person
            WHERE true PERSON-FILTER_PLACE
               ');
    }

    function statsAF_sackTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, 'SELECT
              TT.logo, stat.solo, stat.assist,
              CASE WHEN assist % 2 = 0 THEN ROUND(stat.common) ELSE stat.common END AS common,
              P.name, P.surname, TT.id AS team, P.avatar, P.id
            FROM
              (SELECT stat_inner.*, solo+(assist*0.5) AS common
              FROM
                  (SELECT
                    person, team2, SUM(case WHEN tcount = 1 THEN 1 ELSE 0 END) AS solo,
                          SUM(case WHEN tcount = 1 THEN 0 ELSE 1 END) AS assist
                  FROM (

                      SELECT id, count(id) AS tcount
                      FROM (
                        SELECT
                              A.id,
                              (SELECT person FROM statperson sp1 LEFT JOIN statpersontype spt1 ON spt1.id = sp1.persontype WHERE spt1.code = "rpasser" AND sp1.action = A.id) AS passer,
                               (SELECT person FROM statperson sp2 LEFT JOIN statpersontype spt2 ON spt2.id = sp2.persontype WHERE spt2.code = "runner" AND sp2.action = A.id) AS runner
                          FROM
                                  stataction A LEFT JOIN statperson SP ON SP.action = A.id
                                  LEFT JOIN statpersontype SPT ON SP.persontype = SPT.id
                                  LEFT JOIN statactiontype AT ON AT.id = A.actiontype
                                  LEFT JOIN statchar SC ON SC.action = A.id
                                  LEFT JOIN statchartype SCT ON SCT.id = SC.chartype
                          WHERE
                                  A.share FILTER_PLACE AND AT.code = "rush" AND SPT.code = "tackle" AND SCT.code = "runyds" AND SC.value < 0
                          ) T
                      WHERE T.passer = T.runner
                      GROUP BY
                               id
                  ) T JOIN stataction A2 ON A2.id = T.id
                   JOIN statperson SP2 ON SP2.action = A2.id
                              JOIN statpersontype SPT2 ON SP2.persontype = SPT2.id
                   WHERE SPT2.code = "tackle"
                   GROUP BY person, team2
                   ) stat_inner
                   ORDER BY common DESC, solo DESC
                   LIMIT_PLACE
              ) stat
            LEFT JOIN
               team TT ON stat.team2 = TT.id
            LEFT JOIN
               person P ON P.id = stat.person
            WHERE true PERSON-FILTER_PLACE
               ');
    }

    function statsAF_fgTop($dbConnect, $type, $typeValue, $limit = null) {
        return statsAF_report($dbConnect, $type, $typeValue, $limit, 'SELECT stat.*, P.surname, P.name, T.logo, P.avatar, P.id FROM (
            SELECT
                person, team,
                    SUM(1) AS numr,
                    SUM(CASE 1 WHEN PG.code = "fg" THEN 1 ELSE 0 END) AS fg,
                    SUM(CASE 1 WHEN PG.code = "1pt" THEN 1 ELSE 0 END) AS pt
            FROM
                statperson SP LEFT JOIN statpersontype SPT ON SPT.id = SP.persontype
                    LEFT JOIN stataction A ON A.id = SP.action
                    LEFT JOIN pointsget PG ON PG.id = A.pointsget
            WHERE
                A.share FILTER_PLACE AND SPT.code = "fgkicker"
            GROUP BY
                person
            ORDER BY fg DESC, pt DESC
            LIMIT_PLACE
            ) AS stat LEFT JOIN person P ON stat.person = P.id
            LEFT JOIN team T ON stat.team = T.id
            WHERE true PERSON-FILTER_PLACE
            ');
    }

    function statsAF_top10Point($dbConnect, $CONSTPath, $comp) {
        return common_getlist($dbConnect, 'SELECT P.surname, P.name, P.avatar, point AS points, P.id AS person
            FROM
            (
              SELECT SUM(point) AS point, person FROM (
                  SELECT
                    SUM(point) AS point, person
                  FROM
                    stataction A
                  LEFT JOIN
                    pointsget PG ON A.pointsget = PG.id
                  LEFT JOIN
                    statperson SP ON SP.action = A.id
                  LEFT JOIN
                    statpersontype SPT ON SPT.id = SP.persontype
                  WHERE
                    A.share AND A.competition = :comp AND (PG.code = "td" OR (PG.code = "2pt")) AND SPT.code = "runner"
                  GROUP BY
                    person
                  UNION
                  SELECT
                    SUM(point), person
                  FROM
                    stataction A
                  LEFT JOIN
                    pointsget PG ON A.pointsget = PG.id
                  LEFT JOIN
                    statperson SP ON SP.action = A.id
                  LEFT JOIN
                    statpersontype SPT ON SPT.id = SP.persontype
                  WHERE
                    A.share AND A.competition = :comp AND (PG.code = "td" OR (PG.code = "2pt")) AND SPT.code = "receiver"
                  GROUP BY
                    person
                  UNION
                  SELECT
                    SUM(point), person
                  FROM
                    stataction A
                  LEFT JOIN
                    pointsget PG ON A.pointsget = PG.id
                  LEFT JOIN
                    statperson SP ON SP.action = A.id
                  LEFT JOIN
                    statpersontype SPT ON SPT.id = SP.persontype
                  WHERE
                    A.share AND A.competition = :comp AND (PG.code = "td" OR (PG.code = "2pt")) AND SPT.code = "returner"
                  GROUP BY
                    person
                  UNION
                  SELECT
                    SUM(point), person
                  FROM
                    stataction A
                  LEFT JOIN
                    pointsget PG ON A.pointsget = PG.id
                  LEFT JOIN
                    statperson SP ON SP.action = A.id
                  LEFT JOIN
                    statpersontype SPT ON SPT.id = SP.persontype
                  WHERE
                    A.share AND A.competition = :comp AND (PG.code = "fg" OR (PG.code = "1pt")) AND SPT.code = "fgkicker"
                  GROUP BY
                    person
              ) st1
              GROUP BY
                person
            ) stat LEFT JOIN person P ON P.id = stat.person
            ORDER BY point DESC, P.surname ASC
            LIMIT 0, 10', array('comp' => $comp));
    }

    function statsAF_top10PointFG($dbConnect, $CONSTPath, $comp) {
        return common_getlist($dbConnect, 'SELECT P.surname, P.name, P.avatar, point AS points, P.id AS person
            FROM (
            SELECT
                SUM(point) AS point, person
            FROM
                stataction A
            LEFT JOIN
                pointsget PG ON A.pointsget = PG.id
            LEFT JOIN
                statperson SP ON SP.action = A.id
            LEFT JOIN
                statpersontype SPT ON SPT.id = SP.persontype
            WHERE
                A.share AND A.competition = :comp AND (PG.code = "fg" OR (PG.code = "1pt")) AND SPT.code = "fgkicker"
            GROUP BY
                person
            ) stat LEFT JOIN person P ON P.id = stat.person
            ORDER BY point DESC, P.surname ASC
            LIMIT 0, 10', array('comp' => $comp));
    }