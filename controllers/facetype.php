<?php
    //OK
    function facetype_index($dbConnect, $CONSTPath) {
        $face = common_getlist($dbConnect, '
                SELECT
                  id, name
                FROM
                  facetype
                ORDER BY name');
        return array(
            'answer' => $face
        );
    }