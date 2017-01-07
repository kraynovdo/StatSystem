<?php
    function navigation_list($dbConnect, $CONSTPath, $code = 'main') {
        $queryArgs = array('code' => $code);
        $queryFilter = ' code = :code';
        $result = common_getlist($dbConnect, '
            SELECT
              id, title, href, alias, parent
            FROM
              navigation
            WHERE'. $queryFilter
            , $queryArgs);

        return $result;
    }

    function navigation_goDown() {

    }