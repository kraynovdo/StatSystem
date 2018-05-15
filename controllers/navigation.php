<?php
    function navigation_list($dbConnect, $CONSTPath, $code = 'main') {
        $queryArgs = array('code' => $code);
        $queryFilter = ' code = :code';
        $result = common_getlist($dbConnect, '
            SELECT
              id, title, href, parent
            FROM
              navigation
            WHERE visible AND'. $queryFilter . '
            ORDER BY ord, id
            '
            , $queryArgs);

        return $result;
    }

    function navigation_goDown() {

    }