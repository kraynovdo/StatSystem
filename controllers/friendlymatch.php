<?php
function friendlymatch_index($dbConnect, $CONSTPath) {
    $list = common_getlist($dbConnect, '
        SELECT
            C.id AS comp, M.id, T1.rus_name AS t1name, T2.rus_name AS t2name, score1, score2, date, M.city, M.timem, M.timeh
        FROM
            competition C LEFT JOIN `match` M ON M.competition = C.id
            LEFT JOIN team T1 ON T1.id = M.team1
            LEFT JOIN team T2 ON T2.id = M.team2
        WHERE C.type = 1
        ORDER BY date
    ', array());
    require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/federation.php');
    $navig = federation_navig($dbConnect);
    return array(
        'answer' => $list,
        'navigation' => $navig
    );
}
function friendlymatch_view($dbConnect, $CONSTPath) {
    $answer = array();
    $query = '
            SELECT
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, date,
              T1.rus_name AS t1name,
              T2.rus_name AS t2name,
              T1.logo AS t1logo,
              T2.logo AS t2logo
            FROM
              `match` M
            LEFT JOIN team T1 ON T1.id = M.team1
            LEFT JOIN team T2 ON T2.id = M.team2
            WHERE M.id = :m
        ';
    $queryresult = $dbConnect->prepare($query);
    $queryresult->execute(array(
        'm' => $_GET['match']
    ));
    $dataset = $queryresult->fetchAll();
    $answer['match'] = $dataset[0];

    /*TODO отдельный метод*/
    $query = '
            SELECT
              id, name
            FROM
              pointsget
            WHERE sport = 1
        ';
    $queryresult = $dbConnect->prepare($query);
    $queryresult->execute();
    $answer['pointsget'] = $queryresult->fetchAll();

    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/action.php');
    $answer['action'] = action_listInMatch($dbConnect, $CONSTPath, $_GET['match']);



    require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
    return array(
        'answer' => $answer,
        'navigation' => array(
            'menu' => array(),
            'header' => 'Товарищеский матч'
        )
    );
}

function friendlymatch_edit($dbConnect, $CONSTPath) {
    if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']])) {
        $queryresult = $dbConnect->prepare('
            SELECT M.id, M.competition, M.team1, M.team2, M.date, M.score1, M.score2 FROM `match` M
            WHERE id = :match
        ');
        $queryresult->execute(array(
            'match' => $_GET['match']
        ));
        $match = $queryresult->fetchAll();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        $comp = competition_add($dbConnect, $CONSTPath);
        return array(
            'answer' => array(
                'team' => $comp['answer']['team'],
                'match' => $match
            ),
            'navigation' => array(
                'menu' => array(),
                'header' => 'Товарищеский матч'
            )
        );
    }
    else {
        return 'ERROR-403';
    }
}

function friendlymatch_update($dbConnect, $CONSTPath) {

    if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_POST['comp']])) {
        $comp = $_POST['comp'];
        $match = $_POST['match'];
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/common.php');

        $score = '';
        $param = array(
            'team1' => $_POST['team1'],
            'team2' => $_POST['team2'],
            'date' => common_dateToSQL($_POST['date']),
            'match' => $match
        );


        if (strlen($_POST['score1'].'')) {
            $param['score1'] = $_POST['score1'];
        }
        else {
            $param['score1'] = NULL;
        }
        if (strlen($_POST['score2'].'')) {
            $param['score2'] = $_POST['score2'];
        }
        else {
            $param['score2'] = NULL;
        }

        $queryresult = $dbConnect->prepare('
                    UPDATE `match` SET team1 = :team1, team2 = :team2, `date` = :date, score1 = :score1, score2 = :score2 WHERE id = :match
                ');

        $queryresult->execute($param);
        return array(
            'page' => '/?r=friendlymatch'
        );
    }
    else {
        return 'ERROR-403';
    }
}