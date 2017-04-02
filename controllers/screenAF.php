<?php
    function screenAF_listplayers($dbConnect, $CONSTPath, $match, $team, $tag = '') {
        $where = '';
        $params = array(
            'match' => $match,
            'team' => $team
        );
        if ($tag == 'qb') {
            $where = ' AND POS.abbr = "QB"';
        }
        return common_getlist($dbConnect, '
            SELECT
              person AS pid, MR.number, POS.abbr AS pos
            FROM
              matchroster MR
              LEFT JOIN roster R ON R.id = MR.roster
              LEFT JOIN position pos ON pos.id = R.position
            WHERE
                `match` = :match AND MR.team = :team' . $where . '
            ORDER BY pos'

        , $params);
    }