<?php
function calendar_index($dbConnect, $CONSTPath, $team = null, $comp = null) {
    $filter = '';
    $join = '';
    $result = array();
    $params = array();
    if (!$comp) {
        $comp = $_GET['comp'];
    }
    if ($comp) {
        $filter .= ' AND M.competition = :competition';
        $join .= '
            LEFT JOIN `compteam` C1 ON C1.competition = :competition AND C1.team = T1.id
            LEFT JOIN `compteam` C2 ON C2.competition = :competition AND C2.team = T2.id
            LEFT JOIN `group` G ON G.id = M.group';
        $params['competition'] = $comp;

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        $navigation = competition_lafNavig();
        $navigation['pageId'] = 43;
        $result['navigation'] = $navigation;

    }
    if ($team) {
        $filter .= ' AND (M.team1 = :team OR M.team2 = :team)';
        $params['team'] = $team;
    }
    if ($_GET['group']) {
        $filter .= ' AND M.group = :group';
        $params['group'] = $_GET['group'];
    }
    $query = '
            SELECT
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, date, M.city, M.timeh, M.timem,
              T1.rus_name AS t1name, T1.logo AS t1logo, T1.city AS t1city,
              T2.rus_name AS t2name, T2.logo AS t2logo, T2.city AS t2city,
	            G.id as g, G.name as gname
            FROM
              `match` M
            LEFT JOIN team T1 ON T1.id = M.team1
            LEFT JOIN team T2 ON T2.id = M.team2 ' . $join . '
            WHERE TRUE
            '.$filter.'
            ORDER BY M.date, M.timeh, M.timem, M.id
        ';
    $queryresult = $dbConnect->prepare($query);
    $queryresult->execute($params);
    $dataset = $queryresult->fetchAll();
    $result['answer']['match'] = $dataset;
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/group.php');
    $group = group_index($dbConnect, $CONSTPath);
    $result['answer']['group'] = $group['answer'];
    return $result;
}