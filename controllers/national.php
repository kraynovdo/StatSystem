<?
function national_view($dbConnect, $CONSTPath) {
    $result = array();
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
    $result['navigation'] = start_NAVIG();

    return $result;
}