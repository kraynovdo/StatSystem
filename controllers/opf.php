<?php
    //OK
    function opf_index($dbConnect, $CONSTPath) {
        $result = array();
        $result['answer'] = common_getlist($dbConnect, 'SELECT id, name FROM org_form');
        return $result;
    }