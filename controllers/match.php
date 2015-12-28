<?php
    function match_index($dbConnect, $CONSTPath) {
        $filter = '';
        $result = array();
        $params = array();
        if ($_GET['comp']) {
            $filter .= ' AND M.competition = :competition';
            $params['competition'] = $_GET['comp'];

            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
            $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);

        }
        $query = '
            SELECT
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, date,
              T1.rus_name AS t1name,
              T2.rus_name AS t2name
            FROM
              `match` M
            LEFT JOIN team T1 ON T1.id = M.team1
            LEFT JOIN team T2 ON T2.id = M.team2
            WHERE TRUE
            '.$filter.'
            ORDER BY M.date, M.id
        ';
        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute($params);
        $dataset = $queryresult->fetchAll();
        $result['answer'] = $dataset;

        return $result;
    }

    function match_add($dbConnect, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/team.php');
        $team = team_index($dbConnect, $CONSTPath);
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        return array(
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp']),
            'answer' => array(
                'team' => $team['answer']
            )
        );
    }
    function match_edit($dbConnect, $CONSTPath) {
        $matchMeta = match_add($dbConnect, $CONSTPath);
        $queryresult = $dbConnect->prepare('
            SELECT M.id, M.competition, M.team1, M.team2, M.date, M.score1, M.score2 FROM `match` M
            WHERE id = :match
        ');
        $queryresult->execute(array(
            'match' => $_GET['match']
        ));
        $match = $queryresult->fetchAll();
        $matchMeta['answer']['match'] = $match;
        return $matchMeta;
    }
    function match_create($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            $comp = $_POST['comp'];
            $queryresult = $dbConnect->prepare('
                INSERT INTO `match` (team1, team2, `date`, competition)
                VALUES (:team1, :team2, :date, :comp)
            ');
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/common.php');
            $queryresult->execute(array(
                'team1' => $_POST['team1'],
                'team2' => $_POST['team2'],
                'date' => common_dateToSQL($_POST['date']),
                'comp' => $comp
            ));
            return array(
                'page' => '/?r=match&comp='.$comp
            );
        }
        else {
            return 'ERROR-403';
        }
    }
    function match_update($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
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
                'page' => '/?r=match&comp='.$comp
            );
        }
        else {
            return 'ERROR-403';
        }
    }
    function match_delete($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            $match = $_GET['match'];
            $comp = $_GET['comp'];
            $queryresult = $dbConnect->prepare('
                DELETE FROM `match` WHERE id = :match
            ');
            $queryresult->execute(array(
                'match' => $match
            ));
            return array(
                'page' => '/?r=match&comp='.$comp
            );
        }
        else {
            return 'ERROR-403';
        }
    }
    function match_view($dbConnect, $CONSTPath) {
        $answer = array();
        $query = '
            SELECT
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, date,
              T1.rus_name AS t1name,
              T2.rus_name AS t2name
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
        $team1 = $answer['match']['team1'];
        $team2 = $answer['match']['team2'];
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/matchroster.php');
        $team1roster = matchroster_index($dbConnect, $CONSTPath, $team1);
        $team2roster = matchroster_index($dbConnect, $CONSTPath, $team2);

        $answer['team1roster'] = $team1roster['answer'];
        $answer['team2roster'] = $team2roster['answer'];

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

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/roster.php');
        $answer['face1'] = rosterface_list($dbConnect, $CONSTPath, $team1, $_GET['comp']);
        $answer['face2'] = rosterface_list($dbConnect, $CONSTPath, $team2, $_GET['comp']);


        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        return array(
            'answer' => $answer,
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
        );
    }

    function match_playbyplay($dbConnect, $CONSTPath) {
        $answer = array();
        $answer['match'] = common_getrecord($dbConnect, '
            SELECT
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, date,
              T1.rus_name AS t1name,
              T2.rus_name AS t2name
            FROM
              `match` M
            LEFT JOIN team T1 ON T1.id = M.team1
            LEFT JOIN team T2 ON T2.id = M.team2
            WHERE M.id = :m
        ', array(
            'm' => $_GET['match']
        ));
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statconfig.php');
        $answer['statconfig'] = statconfig_list($dbConnect, $CONSTPath);

        $team1 = $answer['match']['team1'];
        $team2 = $answer['match']['team2'];
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/matchroster.php');
        $team1roster = matchroster_index($dbConnect, $CONSTPath, $team1);
        $team2roster = matchroster_index($dbConnect, $CONSTPath, $team2);

        $answer['team1roster'] = $team1roster['answer'];
        $answer['team2roster'] = $team2roster['answer'];

        $answer['event'] = common_getlist($dbConnect, '
            SELECT * FROM (
                    SELECT
                        M.id, M.comment, PG.name AS pg, AT.name AS action, T.logo AS team, PT.name AS ch, CONCAT_WS(" ", P.surname, P.name) AS val
                    FROM
                        matchevents M LEFT JOIN stataction S ON S.id = M.stataction
                            LEFT JOIN pointsget PG ON PG.id = S.pointsget
                            LEFT JOIN statactiontype AT ON AT.id = S.actiontype
                            LEFT JOIN team T ON T.id = S.team
                            LEFT JOIN statperson SP ON SP.action = S.id
                            LEFT JOIN statpersontype PT ON PT.id = SP.persontype
                            LEFT JOIN person P ON P.id = SP.person
                    WHERE
                        M.`match` = :match
                    UNION
                    SELECT
                        M.id, M.comment, PG.name AS pg, AT.name AS action, T.logo AS team, CT.name AS ch, C.value AS val
                    FROM
                        matchevents M LEFT JOIN stataction S ON S.id = M.stataction
                            LEFT JOIN pointsget PG ON PG.id = S.pointsget
                            LEFT JOIN statactiontype AT ON AT.id = S.actiontype
                            LEFT JOIN team T ON T.id = S.team
                            LEFT JOIN statchar C ON C.action = S.id
                            LEFT JOIN statchartype CT ON CT.id = C.chartype
                    WHERE
                        M.`match` = :match
                    ) X ORDER BY X.id DESC
        ', array(
            'match' => $_GET['match']
        ));
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        return array(
            'answer' => $answer,
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
        );
    }

    function match_createEvent($dbConnect, $CONSTPath) {
        $point = $_POST['point'] ? $_POST['point'] : NULL;
        $team = NULL;
        $actionType = NULL;
        for ($i = 0; $i < count($_POST['teamSt']); $i++) {
            if ($_POST['teamSt'][$i]) {
                $team = $_POST['teamSt'][$i];
                break;
            }
        }
        if ($_POST['actionType']) {
            common_query($dbConnect,'
            INSERT INTO stataction
            (pointsget, actiontype, `match`, team, competition)
            VALUES (:pointsget, :actiontype, :match, :team, :competition)
            ', array(
                'pointsget' => $point,
                'actiontype' => $_POST['actionType'],
                'match' => $_POST['match'],
                'team' => $team,
                'competition' => $_POST['competition']
            ));
            $action = $dbConnect->lastInsertId('id');

            $char = $_POST['char'];
            if ($char) {
                foreach ($char as $key => $value) {
                    if (strlen($value)) {
                        common_query($dbConnect, '
                INSERT INTO statchar
                  (value, action, chartype)
                VALUES (:value, :action, :chartype)
                ', array(
                            'value' => $value,
                            'action' => $action,
                            'chartype' => $key
                        ));
                    }
                }
            }


            $person = $_POST['person'];
            if ($person) {
                foreach ($person as $key => $value) {
                    common_query($dbConnect, '
                INSERT INTO statperson
                  (persontype, action, person)
                VALUES (:persontype, :action, :person)
                ', array(
                        'person' => $value,
                        'action' => $action,
                        'persontype' => $key
                    ));
                }
            }

        }
        common_query($dbConnect,'
            INSERT INTO matchevents
            (comment, stataction, period, `match`)
            VALUES (:comment, :stataction, :period, :match)
            ', array(
            'comment' => $_POST['comment'],
            'stataction' => $action,
            'period' => 1,
            'match' => $_POST['match'],
        ));
        return array(
            'page' => '/?r=match/playbyplay&match=' . $_POST['match'] . '&comp=' . $_POST['competition']
        );

    }
/*
SELECT
	M.id, M.comment, PG.name, AT.name, T.name, PT.name AS ch, CONCAT_WS(' ', P.surname, P.name) AS val
FROM
	matchevents M LEFT JOIN stataction S ON S.id = M.stataction
        LEFT JOIN pointsget PG ON PG.id = S.pointsget
        LEFT JOIN statactiontype AT ON AT.id = S.actiontype
        LEFT JOIN team T ON T.id = S.team
        LEFT JOIN statperson SP ON SP.action = S.id
        LEFT JOIN statpersontype PT ON PT.id = SP.persontype
        LEFT JOIN person P ON p.id = SP.person
WHERE
	M.`match` = 75
ORDER BY M.id DESC, PT.id DESC



SELECT
	M.id, M.comment, PG.name, AT.name, T.name, CT.name AS ch, C.value AS val
FROM
	matchevents M LEFT JOIN stataction S ON S.id = M.stataction
        LEFT JOIN pointsget PG ON PG.id = S.pointsget
        LEFT JOIN statactiontype AT ON AT.id = S.actiontype
        LEFT JOIN team T ON T.id = S.team
        LEFT JOIN statchar C ON C.action = S.id
        LEFT JOIN statchartype CT ON CT.id = C.chartype
WHERE
	M.`match` = 75
ORDER BY M.id DESC, CT.id DESC



SELECT * FROM (
SELECT
	M.id, M.comment, PG.name AS pg, AT.name AS action, T.name AS team, PT.name AS ch, CONCAT_WS(' ', P.surname, P.name) AS val
FROM
	matchevents M LEFT JOIN stataction S ON S.id = M.stataction
        LEFT JOIN pointsget PG ON PG.id = S.pointsget
        LEFT JOIN statactiontype AT ON AT.id = S.actiontype
        LEFT JOIN team T ON T.id = S.team
        LEFT JOIN statperson SP ON SP.action = S.id
        LEFT JOIN statpersontype PT ON PT.id = SP.persontype
        LEFT JOIN person P ON p.id = SP.person
WHERE
	M.`match` = 75
UNION
SELECT
	M.id, M.comment, PG.name AS pg, AT.name AS action, T.name AS team, CT.name AS ch, C.value AS val
FROM
	matchevents M LEFT JOIN stataction S ON S.id = M.stataction
        LEFT JOIN pointsget PG ON PG.id = S.pointsget
        LEFT JOIN statactiontype AT ON AT.id = S.actiontype
        LEFT JOIN team T ON T.id = S.team
        LEFT JOIN statchar C ON C.action = S.id
        LEFT JOIN statchartype CT ON CT.id = C.chartype
WHERE
	M.`match` = 75
) X ORDER BY X.id DESC
 */
