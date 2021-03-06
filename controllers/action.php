<?php
    //OK
    function action_listInMatch($dbConnect, $CONSTPath, $match = null) {
        if (!$match) {
            $match = $_GET['match'];
        }
        $res = common_getlist($dbConnect, '
            SELECT
              A.id, P.surname, P.name, P.patronymic, PG.name AS pgname, PG.point, A.team, A.period, PG.rus_code AS abbr
            FROM
              action AS A LEFT JOIN person AS P ON P.id = A.person
              LEFT JOIN pointsget PG ON PG.id = A.pointsget
            WHERE `match` = :match
            ORDER BY period, id
        ', array(
            'match' => $match
        ));
        return $res;
    }

    function action_edit ($dbConnect, $CONSTPath) {
        $result = array ();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
        $result['navigation'] = admin_navig();



        $result['answer'] = array();

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/match.php');
        $result['answer']['maininfo'] = match_mainInfo($dbConnect, $CONSTPath);

        $result['answer']['action'] = action_listInMatch($dbConnect, $CONSTPath, $_GET['match']);

        $query = '
            SELECT
              id, name
            FROM
              pointsget
            WHERE sport = 1
        ';
        $result['answer']['pointsget'] = common_getlist($dbConnect, $query, array());

        return $result;
    }

    function action_insert($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_POST['comp']] == 1)) {
            if ($_POST['person'] == '0') {
                $_POST['person'] = NULL;
            }
            $queryresult = $dbConnect->prepare('
                INSERT INTO action (pointsget, team, person, `match`, competition, period)
                VALUES (:pointsget, :team, :person, :match, :comp, :period)
            ');
            $queryresult->execute(array(
                'pointsget' => $_POST['pointsget'],
                'team' => $_POST['team'],
                'person' => $_POST['person'],
                'match' => $_POST['match'],
                'comp' => $_POST['comp'],
                'period' => $_POST['period']
            ));
            $ret = 'match/view';
            if ($_POST['ret']) {
                $ret = 'action/edit&ret=matchcenter';
            }
            return array(
                'page' => '/?r=' . $ret . '&match='.$_POST['match'].'&comp='.$_POST['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function action_delete($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            $queryresult = $dbConnect->prepare('
                    DELETE FROM action WHERE id = :id
            ');
            $queryresult->execute(array(
                'id' => $_GET['action']
            ));
            $ret = 'match/view';
            if ($_GET['ret']) {
                $ret = 'action/edit&ret=matchcenter';
            }
            return array(
                'page' => '/?r=' . $ret . '&match='.$_GET['match'].'&comp='.$_GET['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function action_top10($dbConnect, $CONSTPath) {
        $result = array();
        $queryresult = $dbConnect->prepare('
            SELECT
              PP.points,
              person.surname, person.name, person.avatar, person.id AS person, T.logo
            FROM (
                SELECT
                    SUM(point) as points, person, team
                    FROM
                      action A LEFT JOIN pointsget P ON P.id = A.pointsget LEFT JOIN person Pers ON Pers.id = A.person
                    WHERE
                      A.competition = :comp AND A.person
                    GROUP BY person, team ORDER BY points DESC, Pers.surname LIMIT 10
                ) PP
            LEFT JOIN person on PP.person = person.id
            LEFT JOIN team T ON T.id = PP.team
			ORDER BY points DESC, surname
        ');
        $queryresult->execute(array(
            'comp' => $_GET['comp']
        ));
        $result['answer'] = $queryresult->fetchAll();
        return $result;
    }

    function action_top10kickers($dbConnect, $CONSTPath) {
        $result = array();
        $queryresult = $dbConnect->prepare('
            SELECT
              PP.points,
              person.surname, person.name, person.patronymic, person.avatar, T.logo, person.id AS person, T.id as team
            FROM (
                SELECT
                    SUM(point) as points, person, team
                    FROM
                      action A LEFT JOIN pointsget P ON P.id = A.pointsget LEFT JOIN person Pers ON Pers.id = A.person
                    WHERE
                      A.competition = :comp AND (point = 1 OR point = 3)
                    GROUP BY person, team ORDER BY points DESC, Pers.surname LIMIT 10
                ) PP
            LEFT JOIN person on PP.person = person.id
			LEFT JOIN roster R on R.person = person.id AND R.competition = :comp
			LEFT JOIN team T ON T.id = R.team
			WHERE person.id
			ORDER BY points DESC, surname
        ');
        $queryresult->execute(array(
            'comp' => $_GET['comp']
        ));
        $result['answer'] = $queryresult->fetchAll();
        return $result;
    }

    function action_personstats($dbConnect, $CONSTPath, $person=null, $comp) {
        if (!$person) {
            $person = $_GET['person'];
        }
        $stats = common_getlist($dbConnect, '

                SELECT
                  COUNT(A.pointsget) AS value, PG.name AS name
                FROM
                  action A
                    LEFT JOIN pointsget PG ON PG.id = A.pointsget
                WHERE person = :person AND competition = :comp
                GROUP BY A.pointsget, PG.name
            ',
        array('person' => $person, 'comp' => $comp));
        return $stats;
    }

    function action_teamstats($dbConnect, $CONSTPath, $team=null, $comp) {
        if (!$team) {
            $team = $_GET['team'];
        }
        $stats = common_getlist($dbConnect, '

        SELECT stat.*, P.surname, P.name FROM (
            SELECT
                      COUNT(A.pointsget) AS value, PG.name AS pgname, PG.id AS pgid, person
                    FROM
                      action A
                        LEFT JOIN pointsget PG ON PG.id = A.pointsget
                    WHERE team = :team AND competition = :comp
                    GROUP BY A.pointsget, PG.name, person
    				ORDER BY PG.id, value DESC
            ) stat LEFT JOIN person P ON P.id = stat.person
        ', array('team' => $team, 'comp' => $comp));;
        return $stats;
    }