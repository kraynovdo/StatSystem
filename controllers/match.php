<?php
    function match_index($dbConnect, $CONSTPath, $team = null, $comp = null) {
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
            $result['navigation'] = competition_NAVIG($dbConnect, $comp);

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
              T1.rus_name AS t1name, T1.logo AS t1logo,
              T2.rus_name AS t2name, T2.logo AS t2logo,
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

    function match_add($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/team.php');
            $team = team_complist($dbConnect, $CONSTPath);
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/group.php');
            $group = group_index($dbConnect, $CONSTPath);
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
            $result = array(
                'navigation' => competition_NAVIG($dbConnect, $_GET['comp']),
                'answer' => array(
                    'team' => $team['answer'],
                    'group' => $group['answer']
                )
            );
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function match_edit($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            $matchMeta = match_add($dbConnect, $CONSTPath);
            $queryresult = $dbConnect->prepare('
                SELECT M.id, M.competition, M.team1, M.team2, M.date, M.score1, M.score2, M.city, M.timeh, M.timem, M.group FROM `match` M
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
                INSERT INTO `match` (team1, team2, `date`, competition, city, timeh, timem, `group`)
                VALUES (:team1, :team2, :date, :comp, :city, :timeh, :timem, :group)
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
            $group = $_POST['group'];
            if (!$group) {
                $group  = NULL;
            }
            $queryresult->execute(array(
                'team1' => $_POST['team1'],
                'team2' => $_POST['team2'],
                'date' => common_dateToSQL($_POST['date']),
                'comp' => $comp,
                'city' => $_POST['city'],
                'timeh' => $timeh,
                'timem' => $timem,
                'group' => $group
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
                'city' => $_POST['city'],
                'group' => $_POST['group']
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
                    city = :city, timeh = :timeh, timem = :timem, `group` = :group
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
        $result = array(
            'answer' => $answer,
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
        );
        return $result;
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
            SELECT
                M.id, M.comment, PG.name AS pg, AT.name AS action, T.logo AS team, AT.code,
                SP_INFO.surname, SP_INFO.code AS spcode, SP_INFO.spname AS spname,
                SC_INFO.code AS sccode, SC_INFO.scname AS scname, SC_INFO.value AS scvalue
            FROM
        	    matchevent M LEFT JOIN stataction S ON M.id = S.matchevent
                            LEFT JOIN pointsget PG ON PG.id = S.pointsget
                            LEFT JOIN statactiontype AT ON AT.id = S.actiontype
                            LEFT JOIN team T ON T.id = S.team
                            LEFT JOIN (
                            	SELECT
                                	GROUP_CONCAT(CONCAT_WS(" ", P.name, P.surname)) AS surname,
                                        GROUP_CONCAT(SPT.code) AS code,
                                        GROUP_CONCAT(SPT.name) AS spname,
                                        SP.action
                            	FROM
                                	statperson SP
                                LEFT JOIN
                                	person P ON P.id = SP.person
                                LEFT JOIN
                                	statpersontype SPT ON SPT.id = SP.persontype
                                        GROUP BY SP.action

                            ) AS SP_INFO ON SP_INFO.action = S.id
                            LEFT JOIN (
                            	SELECT
                                        GROUP_CONCAT(SCT.code) AS code,
                                        GROUP_CONCAT(SCT.name) AS scname,
                                        GROUP_CONCAT(SC.value) AS value,
                                        SC.action
                            	FROM
                                	statchar SC

                                LEFT JOIN
                                	statchartype SCT ON SCT.id = SC.chartype
                                        GROUP BY SC.action

                            ) AS SC_INFO ON SC_INFO.action = S.id



                    WHERE
                        M.`match` = :match ORDER BY M.id DESC
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
        common_query($dbConnect,'
            INSERT INTO matchevent
            (comment, period, `match`)
            VALUES (:comment, :period, :match)
            ', array(
            'comment' => $_POST['comment'],
            'period' => 1,
            'match' => $_POST['match'],
        ));
        $matchevent = $dbConnect->lastInsertId('id');
        if ($_POST['actionType']) {
            common_query($dbConnect,'
            INSERT INTO stataction
            (pointsget, actiontype, `match`, team, competition, matchevent)
            VALUES (:pointsget, :actiontype, :match, :team, :competition, :matchevent)
            ', array(
                'pointsget' => $point,
                'actiontype' => $_POST['actionType'],
                'match' => $_POST['match'],
                'team' => $team,
                'competition' => $_POST['competition'],
                'matchevent' => $matchevent
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

        return array(
            'page' => '/?r=match/playbyplay&match=' . $_POST['match'] . '&comp=' . $_POST['competition']
        );

    }

    function match_deleteEvent($dbConnect) {
        $id = $_GET['event'];
        common_query($dbConnect, 'DELETE FROM matchevent WHERE id = :id', array('id' => $id));
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
