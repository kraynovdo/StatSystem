<?php
    //OK
    function matchroster_comp($dbConnect, $match) {
        $query = '
            SELECT
              competition
            FROM
              `match` M
            WHERE M.id = :m
        ';
        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute(array(
            'm' => $match
        ));
        $dataset = $queryresult->fetchAll();
        return array(
            'answer' => $dataset[0]['competition']
        );
    }

    function matchroster_team($dbConnect, $matchroster) {
        $query = '
                SELECT
                  team
                FROM
                  matchroster M
                WHERE M.id = :m
            ';
        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute(array(
            'm' => $matchroster
        ));
        $dataset = $queryresult->fetchAll();
        return array(
            'answer' => $dataset[0]['team']
        );
    }

    function matchroster_autofill($dbConnect, $CONSTPATH) {
        $team = $_GET['team'];
        $comp = matchroster_comp($dbConnect, $_GET['match']);
        if (($_SESSION['userType'] == 4) || ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team]) || ($_SESSION['userComp'][$comp['answer']] == 1)) {



            $query = 'DELETE FROM matchroster WHERE team = :team and `match` = :match';
            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'match' => $_GET['match'],
                'team' => $team
            ));

            $query = 'INSERT INTO matchroster (`match`, team, roster, number)
        SELECT :match, team, id, number FROM roster WHERE team = :team and competition = :comp and confirm = 1';
            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'match' => $_GET['match'],
                'team' => $team,
                'comp' => $comp['answer']
            ));


            $ret = 'match/view';
            if ($_GET['ret'] == 'matchcenter') {
                $ret = $_GET['ret'];;
            }

            return (array(
                'page' => '/?r=matchroster/refcheck&team=' . $team . '&ret=' . $ret . '&comp='.$comp['answer'].'&match='.$_GET['match']
            ));
        }
        else {
            return 'ERROR-403';
        }

    }

    function matchroster_index($dbConnect, $CONSTPATH, $team = null) {
        $query = '
            SELECT
              M.id, M.roster, M.number, P.surname, P.name, P.patronymic, P.id AS personID, POS.abbr, P.avatar
            FROM
              matchroster M LEFT JOIN roster R ON R.id = M.roster
               LEFT JOIN person P ON P.id = R.person
               LEFT JOIN position POS ON POS.id = R.position
            WHERE M.team = :team and M.`match` = :match
            ORDER BY M.number
        ';
        if (!$team) $team = $_GET['team'];
        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute(array(
            'team' => $team,
            'match' => $_GET['match']
        ));
        $dataset = $queryresult->fetchAll();
        return array(
            'answer' => $dataset
        );
    }

    function matchroster_delete($dbConnect, $CONSTPATH) {
        $team = matchroster_team($dbConnect, $_POST['matchroster']);
        $comp = matchroster_comp($dbConnect, $_POST['match']);
        if (($_SESSION['userType'] == 4) || ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team['answer']]) || ($_SESSION['userComp'][$_GET['comp']] == 1) || ($_SESSION['userComp'][$comp['answer']])) {
            $query = '
                DELETE FROM matchroster WHERE id = :match
            ';
            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'match' => $_POST['matchroster']
            ));
            return array(
                'answer' => true
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function matchroster_update($dbConnect, $CONSTPATH) {
        $team = matchroster_team($dbConnect, $_POST['matchroster']);
        $comp = matchroster_comp($dbConnect, $_POST['match']);
        if (($_SESSION['userType'] == 4) || ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team['answer']])  || ($_SESSION['userComp'][$comp['answer']]) ) {
            $query = '
                    UPDATE matchroster SET number = :number WHERE id = :mr
                ';
            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'mr' => $_POST['matchroster'],
                'number' => $_POST['number']
            ));
            return array(
                'answer' => true
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function matchroster_full($dbConnect, $CONSTPATH) {
        $team = $_GET['team'];
        $comp = matchroster_comp($dbConnect, $_GET['match']);
        $comp = $comp['answer'];
        if (($_SESSION['userType'] == 4) || ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team]) || ($_SESSION['userComp'][$comp])) {

            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPATH  . '/controllers/roster.php');
            $answer = roster_list($dbConnect, $CONSTPATH, ' ORDER BY surname, name ', $team, $comp, TRUE);
            return $answer;
        }
        else {
            return 'ERROR-403';
        }
    }

    function matchroster_insert($dbConnect, $CONSTPATH) {
        $team = $_POST['team'];
        $comp = matchroster_comp($dbConnect, $_POST['match']);
        $comp = $comp['answer'];
        if (($_SESSION['userType'] == 4) || ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team]) || ($_SESSION['userComp'][$comp])) {
            $query = '
            INSERT INTO matchroster
              (`match`, team, roster, number)
            VALUES
              (:match, :team, :roster, :number)
        ';
            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'team' => $team,
                'roster' => $_POST['roster'],
                'number' => $_POST['number'],
                'match' => $_POST['match']
            ));
            $answer = $queryresult->fetchAll();
            return $answer;
        }
        else {
            return 'ERROR-403';
        }
    }

    function matchroster_print($dbConnect, $CONSTPath) {
            $team = $_GET['team'];
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
            $teamData = team_info($dbConnect, $CONSTPath);
            $match = $_GET['match'];
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/match.php');
            $matchData = match_mainInfo($dbConnect, $CONSTPath);
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
            $compInfo = competition_info ($dbConnect, $CONSTPath, $_GET['comp']);
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/roster.php');
            return array(
                'answer' => array(
                    'face' => rosterface_list($dbConnect, $CONSTPath, $_GET['team'], $_GET['comp']),
                    'roster' => matchroster_index($dbConnect, $CONSTPath, $team),
                    'team' => $teamData['answer']['team'],
                    'match'=> array(
                    	'match' => $matchData
                    ),
                    'compinfo'=>$compInfo
                )

            );
        }

    function matchroster_refcheck($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4)) {
            $FULLACCESS = true;
        }
        else {
            if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']]) || ($_SESSION['userComp'][$_GET['comp']] == 1) ) {
                $TACCESS = true;
            }
        }
        if ($FULLACCESS || $TACCESS) {
            $team = $_GET['team'];
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
            $teamData = team_info($dbConnect, $CONSTPath);
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/match.php');
            $matchData = match_mainInfo($dbConnect, $CONSTPath);
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
            return array(
                'answer' => array(

                    'roster' => matchroster_index($dbConnect, $CONSTPath, $team),
                    'team' => $teamData['answer']['team'],
                    'match' => $matchData
                ),
                'navigation' => admin_navig()
            );
        }
        else {
            return 'ERROR-403';
        }
    }