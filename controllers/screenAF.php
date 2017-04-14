<?php
    function screenAF_listplayers($dbConnect, $CONSTPath, $match, $team) {
        $result = array(
            'off' => array(),
            'qb' => array(),
            'def' => array(),
        );
        $params = array(
            'match' => $match,
            'team' => $team
        );

        $fulllist = common_getlist($dbConnect, '
            SELECT
              person AS pid, MR.number, pos.abbr AS pos, offdef
            FROM
              matchroster MR
              LEFT JOIN roster R ON R.id = MR.roster
              LEFT JOIN position pos ON pos.id = R.position
            WHERE
                `match` = :match AND MR.team = :team
            ORDER BY `order`, number'

        , $params);

        for ($i = 0; $i < count($fulllist); $i++) {
            if ($fulllist[$i]['pos'] == 'QB') {
                array_push($result['qb'], $fulllist[$i]);
            } else if ($fulllist[$i]['offdef'] == 1) {
                array_push($result['off'], $fulllist[$i]);
            } else {
                array_push($result['def'], $fulllist[$i]);
            }
        }
        return $result;
    }