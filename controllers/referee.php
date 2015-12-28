<?php
function referee_list($dbConnect, $CONSTPath) {
    return common_getlist($dbConnect, '
          SELECT
            exp, expplay, P.id, P.surname, P.name, P.patronymic, referee.id AS refid
          FROM
            referee LEFT JOIN person AS P ON P.id = referee.person
          ORDER BY P.surname
        ', array());

}
function referee_index($dbConnect, $CONSTPath) {
    $result = array();
    $result['answer'] = referee_list($dbConnect, $CONSTPath);
    require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/admin.php');
    $result['navigation'] = admin_navig();
    return $result;
}