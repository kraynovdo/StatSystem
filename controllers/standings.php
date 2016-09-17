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
    $matchRes[6] = array(
        't1name' => 'Патриоты',
        't1logo' => '6EB64AC4-BCED-475C-9C11-C7A7BC4468BA.png',
        't2name' => 'Рэйдерс 52',
        't2logo' => 'FC671875-8A98-4264-98D2-37991F0B8DE6.png'
    );
    $matchRes[7] = array(
        't1name' => 'Литвины',
        't1logo' => '9582B6D5-C04E-4FAC-AB4C-F05DB11C19F8.png',
        't2name' => 'Спартанцы',
        't2logo' => 'E90185C5-8F25-4100-AF50-CAEE15625960.png'
    );
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
	