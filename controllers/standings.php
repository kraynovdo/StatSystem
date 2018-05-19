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
	
    $matchRes[8] = standings_getInfo($matchAnswer, 278);
    $result['answer'] = $matchRes;


    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
    $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
    return $result;
}

function calc_similar($dbConnect, $similar) {

}

function standings_table($dbConnect, $CONSTPath) {
    $result = array();
    $main_table = common_getlist($dbConnect, '
        SELECT
          T.id, T.rus_name, T.logo, CT.`group`,
          (SELECT count(id) FROM `match` M WHERE team1 = T.id AND M.competition = :comp AND M.group AND M.score1) AS cHome,
          (SELECT count(id) FROM `match` M WHERE team2 = T.id AND M.competition = :comp AND M.group AND M.score1) AS cAway,
          (SELECT count(id) FROM `match` M WHERE team1 = T.id AND score1 > score2 AND M.competition = :comp AND M.group AND M.score1) AS vHome,
          (SELECT count(id) FROM `match` M WHERE team2 = T.id AND score2 > score1 AND M.competition = :comp AND M.group AND M.score1) AS vAway,
          (SELECT (vHome + vAway) / (cHome + cAway) * 100) AS percSource,
          (SELECT COALESCE(percSource, 0)) AS perc,
          (SELECT sum(score1) FROM `match` M WHERE team1 = T.id AND M.competition = :comp AND M.group AND M.score1) AS sHome,
          (SELECT sum(score2) FROM `match` M WHERE team2 = T.id AND M.competition = :comp AND M.group AND M.score1) AS sAway,
          (SELECT sum(score2) FROM `match` M WHERE team1 = T.id AND M.competition = :comp AND M.group AND M.score1) AS slHome,
          (SELECT sum(score1) FROM `match` M WHERE team2 = T.id AND M.competition = :comp AND M.group AND M.score1) AS slAway
        FROM
          compTeam CT LEFT JOIN team T ON T.id = CT.team
        WHERE
          CT.competition = :comp
        ORDER BY `group`, perc DESC
    ', array(
        'comp' => $_GET['comp']
    ));


    $similars = array();
    $divisions = array();
    if (count($main_table)) {


        $prev_perc = $main_table[0]['perc'];
        $prev_group = $main_table[0]['group'];

        $cur_similar = array();
        array_push($cur_similar, $main_table[0]['id']);

        for ($i = 1; $i < count ($main_table); $i++) {
            if ($prev_group != $main_table[$i]['group']) {
                $prev_group = $main_table[$i]['group'];
                if (count ($cur_similar) > 1) {
                    array_push($similars, $cur_similar);
                }
                $cur_similar = array();
                array_push($cur_similar, $main_table[$i]['id']);
            }
            if ($prev_perc != $main_table[$i]['perc']) {
                $prev_perc = $main_table[$i]['perc'];
                if (count ($cur_similar) > 1) {
                    array_push($similars, $cur_similar);
                }
                $cur_similar = array();
                array_push($cur_similar, $main_table[$i]['id']);
            }
            else {
                array_push($cur_similar, $main_table[$i]['id']);
            }

        }
        if (count ($cur_similar) > 1) {
            array_push($similars, $cur_similar);
        }
    }
    print_r($similars);


    $result['answer']['matches'] = $main_table;

    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
    $navigation = competition_lafNavig();
    $navigation['pageId'] = 43;
    $result['navigation'] = $navigation;
    return $result;
}

?>
	