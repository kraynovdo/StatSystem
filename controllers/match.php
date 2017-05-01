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
            $team = team_complist($dbConnect, $CONSTPath, 1);
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

            $match = match_mainInfo($dbConnect, $CONSTPath);

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
                INSERT INTO `match` (team1, team2, `date`, competition, city, timeh, timem, `group`, curperiod)
                VALUES (:team1, :team2, :date, :comp, :city, :timeh, :timem, :group, 1)
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

            $group = $_POST['group'];
            if (!$group) {
                $group  = NULL;
            }
            $param = array(
                'team1' => $_POST['team1'],
                'team2' => $_POST['team2'],
                'date' => common_dateToSQL($_POST['date']),
                'match' => $match,
                'city' => $_POST['city'],
                'group' => $group
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
              M.group,
              T1.logo AS t1logo,
              T2.logo AS t2logo,
              M.curperiod,
              M.confirm
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

    function match_actionList ($dbConnect, $CONSTPath, $match, $limit='') {
        $limitStr = '';
        if ($limit) {
            $limitStr = 'LIMIT 0, 10';
        }
        return common_getlist($dbConnect, '
            SELECT
                M.id, M.comment, M.period, PG.name AS pg, PG.type as pgtype, AT.name AS action, T.logo AS team, AT.code,
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
                        M.`match` = :match ORDER BY M.id DESC ' . $limitStr .'
        ', array(
            'match' => $match
        ));
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

        $answer['event'] = match_actionList($dbConnect, $CONSTPath, $_GET['match']);
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        return array(
            'answer' => $answer,
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
        );
    }

    function yds($num) {
        if (!strlen($num)) {
            return '';
        }
        return common_wordForm($num, 'ярд', 'ярда', 'ярдов');
    }

    function tacklers($needed, $known) {
        $resArr = array();
        $arrNeeded = explode(",", $needed);
        $arrKnown = explode(",", $known);
        for ($i = 0; $i < count($arrKnown); $i++) {
            if ($arrKnown[$i] == 'tackle') {
                array_push($resArr, $arrNeeded[$i]);
            }
        }
        return implode(", ", $resArr);
    }

    function _stdAction($event, $char, $person, $tackleFlag) {
        $value = common_twins($event['scvalue'], $event['sccode'], $char);
        $value = $value . ' ' . yds($value);
        $man = common_twins($event['surname'], $event['spcode'], $person);
        if ($tackleFlag) {
            $tacklers = tacklers($event['surname'], $event['spcode']);
            if ($tacklers) {
                $man .= '. Захват - '.$tacklers;
            }
        }
        $actionStr = $event['action'] . ' ' . $value;
        return array(
            'man' => $man,
            'actionStr' => $actionStr
        );
    }

    function _rush($event) {
        return _stdAction($event, 'runyds', 'runner', 1);
    }

    function _return($event) {
        return _stdAction($event, 'retyds', 'returner', 1);
    }

    function _pass($event) {
        $value = common_twins($event['scvalue'], $event['sccode'], 'passyds');
        $value = $value . ' ' . yds($value);
        $man = common_twins($event['surname'], $event['spcode'], 'passer');
        $manRec = common_twins($event['surname'], $event['spcode'], 'receiver');
        $manInt = common_twins($event['surname'], $event['spcode'], 'intercept');
        $manKnock = common_twins($event['surname'], $event['spcode'], 'passknock');
        if (!$manRec) {
            if ($manInt) {
                $actionStr = 'Перехват';
                $man = $man . '. Перехватил - ' . $manInt;
            } else if ($manKnock){
                $actionStr = 'Сбитый пас';
                $man = $man . '. Cбил - ' . $manKnock;
            } else {
                $actionStr = 'Непринятый пас';
            }
        } else {
            $actionStr = 'Пас ' . $value;
            $man = $man . '. Принял - ' . $manRec;
            $tacklers = tacklers($event['surname'], $event['spcode']);
            if ($tacklers) {
                $man .= '. Захват - '.$tacklers;
            }
        }
        return array(
            'man' => $man,
            'actionStr' => $actionStr
        );
    }

    function _kickoff($event) {
        return _stdAction($event, 'korange', 'kokicker', 0);
    }

    function _punt($event) {
        return _stdAction($event, 'puntrange', 'punter', 0);
    }

    function _fumble($event) {
        $man = common_twins($event['surname'], $event['spcode'], 'fum');
        $manRec = common_twins($event['surname'], $event['spcode'], 'fumrec');
        if (!$manRec) {
            $actionStr = 'Фамбл. Без потери владения';
        } else {
            $actionStr = 'Фамбл. Потеря владения';
            $man = $man . '. Подобрал - ' . $manRec;
        }
        return array(
            'man' => $man,
            'actionStr' => $actionStr
        );
    }

    function _fgoal($event) {
        if ($event['pg']) {
            $value = common_twins($event['scvalue'], $event['sccode'], 'fgrange');
            $value = $value . ' ' . yds($value);
            $actionStr = $value;
        }
        else {
            $actionStr = 'Неудачный удар по воротам';
        }
        $man = common_twins($event['surname'], $event['spcode'], 'fgkicker');


        return array(
            'man' => $man,
            'actionStr' => $actionStr
        );
    }

    function match_playbyplayAF($dbConnect, $CONSTPath, $limit='') {
        $answer = array();
        $mainInfo = match_mainInfo($dbConnect, $CONSTPath);
        $answer['match'] = $mainInfo;

        $pointsTableSRC = common_getList($dbConnect, 'SELECT point,
            type, team, team2, period
            FROM stataction S
            LEFT JOIN pointsget P ON P.id = S.pointsget
            LEFT JOIN matchevent M ON S.matchevent = M.id
            WHERE S.`match` = :match
            AND P.id ORDER BY period', array(
            'match' => $_GET['match']
        ));

        $pointsTable = array(
            array(0, 0),
            array(0, 0),
            array(0, 0),
            array(0, 0)
        );

        for ($i = 0; $i < count($pointsTableSRC); $i++) {
            $per = $pointsTableSRC[$i]['period'];
            if (($per > 4)) {
                if (count($pointsTable) < 5) {
                    array_push($pointsTable, array(0, 0));
                }
            }

            if ($pointsTableSRC[$i]['type'] > 0) {
                if ($mainInfo['team1'] == $pointsTableSRC[$i]['team']) {
                    $pointsTable[$per-1][0] = $pointsTable[$per-1][0] + $pointsTableSRC[$i]['point'];
                }
                else {
                    $pointsTable[$per-1][1] = $pointsTable[$per-1][1] + $pointsTableSRC[$i]['point'];
                }
            }
            else {
                if ($mainInfo['team1'] == $pointsTableSRC[$i]['team2']) {
                    $pointsTable[$per-1][0] = $pointsTable[$per-1][0] + $pointsTableSRC[$i]['point'];
                }
                else {
                    $pointsTable[$per-1][1] = $pointsTable[$per-1][1] + $pointsTableSRC[$i]['point'];
                }
            }


        }

        $answer['pointsTable'] = $pointsTable;

        $event = match_actionList($dbConnect, $CONSTPath, $_GET['match'], $limit);
        $eventResult = array();


        for ($i = 0; $i < count($event); $i++) {
            $firstStr = '';
            $secStr = '';


            $pg = 0;
            if ($event[$i]['action']) {

                $res = array(
                    'man' => null,
                    'actionStr' => null
                );
                switch ($event[$i]['code']) {
                    case 'rush' : $res = _rush($event[$i]); break;
                    case 'pass' : $res = _pass($event[$i]); break;
                    case 'return' : $res = _return($event[$i]); break;
                    case 'kickoff': $res = _kickoff($event[$i]); break;
                    case 'punt': $res = _punt($event[$i]); break;
                    case 'fieldgoal': $res = _fgoal($event[$i]); break;
                    case 'fumble': $res = _fumble($event[$i]); break;
                }
                $man = $res['man'];
                $actionStr = $res['actionStr'];
                if ($event[$i]['pg']) {
                    $firstStr = $event[$i]['pg'];
                    $secStr = $actionStr . ' ' . $man;
                    $pg = $event[$i]['pgtype'];
                }
                else {
                    $firstStr = $actionStr;
                    $secStr = $man;
                }

            }
            array_push($eventResult, array(
                'firstStr' => $firstStr,
                'secStr' => $secStr,
                'team' => $event[$i]['team'],
                'comment' => $event[$i]['comment'],
                'period' => $event[$i]['period'],
                'pg' => $pg,
                'id' => $event[$i]['id']
            ));
        }

        $answer['event'] = $eventResult;
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        return array(
            'answer' => $answer,
            'navigation' => competition_NAVIG($dbConnect, $_GET['comp'])
        );
    }

    function match_playbyplayminiAF($dbConnect, $CONSTPath) {
        return match_playbyplayAF($dbConnect, $CONSTPath, 10);
    }

    function match_createEvent($dbConnect, $CONSTPath) {
        $point = $_POST['point'] ? $_POST['point'] : NULL;
        $team = NULL;
        $actionType = NULL;
        $team2 = NULL;
        if ($_POST['team2']) {
            $team2 = $_POST['team2'];
        }
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
            'period' => $_POST['period'],
            'match' => $_POST['match'],
        ));
        $matchevent = $dbConnect->lastInsertId('id');
        common_query($dbConnect, 'UPDATE `match` SET curperiod = :period WHERE id = :id', array(
            'period' => $_POST['period'],
            'id' => $_POST['match']
        ));
        if ($_POST['actionType']) {
            common_query($dbConnect,'
            INSERT INTO stataction
            (pointsget, actiontype, `match`, team, team2, competition, matchevent)
            VALUES (:pointsget, :actiontype, :match, :team, :team2, :competition, :matchevent)
            ', array(
                'pointsget' => $point,
                'actiontype' => $_POST['actionType'],
                'match' => $_POST['match'],
                'team' => $team,
                'team2' => $team2,
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
        if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 5)) {
            $id = $_GET['event'];
            $ret = $_GET['ret'] ? $_GET['ret'] : '';
            common_query($dbConnect, 'DELETE FROM matchevent WHERE id = :id', array('id' => $id));
            return array(
                'page' => '/?r=match/playbyplay' . $ret . '&match=' . $_GET['match'] . '&comp=' . $_GET['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
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

    function match_confirm($dbConnect) {
        $data = common_getrecord($dbConnect, '
                SELECT
                  confirm
                FROM
                  `match` AS M
                WHERE
                  M.id = :id', array(
            'id' => $_POST['match']
        ));
        if (count($data)) {
            $oldConfirm = $data['confirm'];
            $confirm = 1 - $oldConfirm;

            $match = $_POST['match'];
            common_query($dbConnect, '
                UPDATE
                  `match`
                SET confirm = :confirm WHERE id = :id', array(
                'id' => $match,
                'confirm' => $confirm
            ));
            return $confirm."";

        }
    }