<?php
    function match_index($dbConnect, $CONSTPath, $team = null, $comp = null) {
        $filter = '';
        $result = array();
        $params = array();
        if (!$comp) {
            $comp = $_GET['comp'];
        }
        if ($comp) {
            $filter .= ' AND M.competition = :competition';
            $params['competition'] = $comp;

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
            $result['navigation'] = competition_NAVIG($dbConnect, $comp);

        }
        if ($team) {
            $filter .= ' AND (M.team1 = :team OR M.team2 = :team)';
            $params['team'] = $team;
        }
        $query = '
            SELECT
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, date,
              T1.rus_name AS t1name, T1.logo AS t1logo,
              T2.rus_name AS t2name, T2.logo AS t2logo,
	      G1.id as g1, G2.id as g2, G1.name as g1name, G2.name as g2name
            FROM
              `match` M
            LEFT JOIN team T1 ON T1.id = M.team1
            LEFT JOIN team T2 ON T2.id = M.team2
            LEFT JOIN `compteam` C1 ON C1.competition = :competition AND C1.team = T1.id
            LEFT JOIN `compteam` C2 ON C2.competition = :competition AND C2.team = T2.id
            LEFT JOIN `group` G1 ON G1.id = C1.group
            LEFT JOIN `group` G2 ON G2.id = C2.group
            WHERE TRUE
            '.$filter.'
            ORDER BY M.date, M.timeh, M.timem, M.id
        ';
        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute($params);
        $dataset = $queryresult->fetchAll();
        $result['answer'] = $dataset;

        return $result;
    }

    function match_add($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/team.php');
            $team = team_complist($dbConnect, $CONSTPath);
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
            return array(
                'navigation' => competition_NAVIG($dbConnect, $_GET['comp']),
                'answer' => array(
                    'team' => $team['answer']
                )
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function match_edit($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            $matchMeta = match_add($dbConnect, $CONSTPath);
            $queryresult = $dbConnect->prepare('
                SELECT M.id, M.competition, M.team1, M.team2, M.date, M.score1, M.score2, M.city, M.timeh, M.timem FROM `match` M
                WHERE id = :match
            ');
            $queryresult->execute(array(
                'match' => $_GET['match']
            ));
            $match = $queryresult->fetchAll();
            $matchMeta['answer']['match'] = $match;
            return $matchMeta;
        }
        else {
            return 'ERROR-403';
        }
    }
    function match_create($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_POST['comp']] == 1)) {
            $comp = $_POST['comp'];
            $queryresult = $dbConnect->prepare('
                INSERT INTO `match` (team1, team2, `date`, competition, city, timeh, timem)
                VALUES (:team1, :team2, :date, :comp, :city, :timeh, :timem)
            ');
            if (!$_POST['timeh']) {
                $timeh = NULL;
            }
            else {
                $timeh = $_POST['timeh'];
                if (strlen($timeh) == 1) {
                    $timeh = '0'.$timeh;
                }
            }
            if (!$_POST['timem']) {
                $timem = NULL;
            }
            else {
                $timem = $_POST['timem'];
            }
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/common.php');
            $queryresult->execute(array(
                'team1' => $_POST['team1'],
                'team2' => $_POST['team2'],
                'date' => common_dateToSQL($_POST['date']),
                'comp' => $comp,
                'city' => $_POST['city'],
                'timeh' => $timeh,
                'timem' => $timem
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
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_POST['comp']] == 1)) {
            $comp = $_POST['comp'];
            $match = $_POST['match'];
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/common.php');

            $score = '';
            $param = array(
                'team1' => $_POST['team1'],
                'team2' => $_POST['team2'],
                'date' => common_dateToSQL($_POST['date']),
                'match' => $match,
                'city' => $_POST['city']
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

            if (!$_POST['timeh']) {
                $param['timeh'] = NULL;
            }
            else {
                $param['timeh'] = $_POST['timeh'];
                if (strlen($param['timeh']) == 1) {
                    $param['timeh'] = '0'.$param['timeh'];
                }
            }
            if (!$_POST['timem']) {
                $param['timem'] = NULL;
            }
            else {
                $param['timem'] = $_POST['timem'];
            }

            $queryresult = $dbConnect->prepare('
                    UPDATE `match` SET team1 = :team1, team2 = :team2, `date` = :date, score1 = :score1, score2 = :score2,
                    city = :city, timeh = :timeh, timem = :timem
                    WHERE id = :match
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
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
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
    function match_mainInfo($dbConnect, $CONSTPath) {
        $query = '
            SELECT
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, date, M.video, M.city, M.timeh, M.timem,
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
        return $dataset[0];
    }
    function match_view($dbConnect, $CONSTPath) {
        $answer = array();

        $answer['match'] = match_mainInfo($dbConnect, $CONSTPath);
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
        $answer['match'] = match_mainInfo($dbConnect, $CONSTPath);
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

    function match_deleteEvent($dbConnect) {
        $id = $_GET['event'];
        $evRec = common_getrecord($dbConnect, 'SELECT stataction FROM matchevents WHERE id = :id', array('id' => $id));
        if ($evRec) {
            common_query($dbConnect, 'DELETE FROM stataction WHERE id = :id', array('id' => $evRec['stataction']));
        }
        common_query($dbConnect, 'DELETE FROM matchevents WHERE id = :id', array('id' => $id));
        return array(
            'page' => '/?r=match/playbyplay&match=' . $_GET['match'] . '&comp=' . $_GET['comp']
        );
    }

    function match_videoupdate($dbConnect) {
        common_query($dbConnect,'
            UPDATE `match`
            SET video = :video WHERE id = :match
            ', array(
            'video' => $_POST['video'],
            'match' => $_POST['match']
        ));
        return array(
            'page' => '/?r=match/view&match=' . $_POST['match'] . '&comp=' . $_POST['competition']
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