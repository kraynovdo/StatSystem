<?

function standings_getInfo($matchAnswer, $id)
{
    $res = array();
    for ($i = 0; $i < count($matchAnswer); $i++) {
        if ($id == $matchAnswer[$i]['id']) {
            $res = $matchAnswer[$i];
        }
    }
    return $res;
}

function standings_index($dbConnect, $CONSTPath)
{
    $result = array(
        'answer' => array()
    );
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');
    $match = match_index($dbConnect, $CONSTPath);
    $matchAnswer = $match['answer'];

    $matchRes = array();
    for ($i = 0; $i < 9; $i++) {
        $matchRes[$i] = array();
    }
    $matchRes[0] = standings_getInfo($matchAnswer, 228);
    $matchRes[1] = standings_getInfo($matchAnswer, 229);
    $matchRes[2] = standings_getInfo($matchAnswer, 230);
    $matchRes[3] = standings_getInfo($matchAnswer, 227);

    $matchRes[4] = standings_getInfo($matchAnswer, 233);
    $matchRes[5] = standings_getInfo($matchAnswer, 232);
	
    $matchRes[6] = standings_getInfo($matchAnswer, 275);
    $matchRes[7] = standings_getInfo($matchAnswer, 253);
	
    $matchRes[8] = array(
        't1name' => 'Победитель 7',
        't2name' => 'Победитель 8'
    );
    $result['answer'] = $matchRes;


    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
    $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
    return $result;
}

?>
	