<?php
//OK
function age_index($dbConnect, $CONSTPath) {
    $result = array();
    $result['answer'] = common_getlist($dbConnect, 'SELECT id, name FROM age ORDER BY num');
    return $result;
}