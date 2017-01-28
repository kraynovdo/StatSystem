<?php
    //OK
    function action_listInMatch($dbConnect, $CONSTPath, $match = null) {
        if (!$match) {
            $match = $_GET['match'];
        }
        $res = common_getlist($dbConnect, '
            SELECT
              A.id, P.surname, P.name, P.patronymic, PG.name AS pgname, PG.point, A.team
            FROM
              action AS A LEFT JOIN person AS P ON P.id = A.person
              LEFT JOIN pointsget PG ON PG.id = A.pointsget
            WHERE `match` = :match
        ', array(
            'match' => $match
        ));
        return $res;
    }
    function action_insert($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_POST['comp']] == 1)) {
            if ($_POST['person'] == '0') {
                $_POST['person'] = NULL;
            }
            $queryresult = $dbConnect->prepare('
                INSERT INTO action (pointsget, team, person, `match`, competition)
                VALUES (:pointsget, :team, :person, :match, :comp)
            ');
            $queryresult->execute(array(
                'pointsget' => $_POST['pointsget'],
                'team' => $_POST['team'],
                'person' => $_POST['person'],
                'match' => $_POST['match'],
                'comp' => $_POST['comp']
            ));
            return array(
                'page' => '/?r=match/view&match='.$_POST['match'].'&comp='.$_POST['comp']
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
            return array(
                'page' => '/?r=match/view&match='.$_GET['match'].'&comp='.$_GET['comp']
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
              person.surname, person.name, person.patronymic, person.avatar, T.logo, person.id AS person, T.id as team
            FROM (
                SELECT
                    SUM(point) as points, person
                    FROM
                      action A LEFT JOIN pointsget P ON P.id = A.pointsget LEFT JOIN person Pers ON Pers.id = A.person
                    WHERE
                      A.competition = :comp
                    GROUP BY person ORDER BY points DESC, Pers.surname LIMIT 10
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

    function action_top10kickers($dbConnect, $CONSTPath) {
        $result = array();
        $queryresult = $dbConnect->prepare('
            SELECT
              PP.points,
              person.surname, person.name, person.patronymic, person.avatar, T.logo, person.id AS person, T.id as team
            FROM (
                SELECT
                    SUM(point) as points, person
                    FROM
                      action A LEFT JOIN pointsget P ON P.id = A.pointsget LEFT JOIN person Pers ON Pers.id = A.person
                    WHERE
                      A.competition = :comp AND (point = 1 OR point = 3)
                    GROUP BY person ORDER BY points DESC, Pers.surname LIMIT 10
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

    function action_personstats($dbConnect, $CONSTPath, $person=null) {
        if (!$person) {
            $person = $_GET['person'];
        }
        $stats = common_getlist($dbConnect, '
          SELECT
            P.*, C.name AS compname, S.yearB, S.yearE
          FROM (
                SELECT
                  COUNT(A.pointsget) AS count, PG.name AS pointname, A.competition
                FROM
                  action A
                    LEFT JOIN pointsget PG ON PG.id = A.pointsget
                WHERE person = :person
                GROUP BY A.pointsget, PG.name, A.competition
            ) AS P
            LEFT JOIN competition C ON C.id = P.competition
            LEFT JOIN season S ON S.id = C.season
          ORDER BY yearB, competition',
        array('person' => $person));
        return $stats;
    }