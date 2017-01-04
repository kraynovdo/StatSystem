<?php
    function navigation_list($dbConnect, $CONSTPath, $code = 'main',$par = NULL) {
        $queryArgs = array('code' => $code);
        $queryFilter = ' code = :code';
        if ($par) {
            $queryArgs['par'] = $par;
            $queryFilter .= ' AND parent = :par';
        }
        $result = common_getlist($dbConnect, '
            SELECT
              id, title, href, alias
            FROM
              navigation
            WHERE'. $queryFilter
            , $queryArgs);

        return $result;
    }
