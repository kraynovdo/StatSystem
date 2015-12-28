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