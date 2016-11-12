<?php
    //OK
    function userteam_list($dbConnect, $CONSTPath, $team=null, $person=null) {
        $result = array();
        $where = ' WHERE TRUE';
        $params = array();
        if (!$person) {
            $person = $_GET['person'];
        }
        if (!$team) {
            $team = $_GET['team'];
        }
        if ($person) {
            $where .= ' AND person = :person';
            $params['person'] = $person;
        }
        if ($team) {
            $where .= ' AND team = :team';
            $params['team'] = $team;
        }

        $queryresult = $dbConnect->prepare('
            SELECT UR.id, T.rus_name, T.id as team
            FROM userteam UR LEFT JOIN team T ON T.id = UR.team'. $where);
        $queryresult->execute($params);
        $dataset = $queryresult->fetchAll();

        return $dataset;
    }
    function userteam_index($dbConnect, $CONSTPath, $team=null, $person=null) {
        $result['answer'] = userteam_list($dbConnect, $CONSTPath, $team, $person);
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
        $result['navigation'] = person_navig();
        $result['navigation']['mobile_view'] = 1;
        return $result;
    }

    function userteam_add($dbConnect, $CONSTPath){
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            $result = array();
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
            $comp = $_GET['comp'];
            $_GET['comp'] = '';
            $teamres = team_index($dbConnect, $CONSTPath);
            $_GET['comp'] = $comp;
            $result['answer'] = $teamres['answer'];
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
            $result['navigation'] = admin_navig();
            $result['navigation']['mobile_view'] = 1;
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function userteam_create($dbConnect) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            $queryresult = $dbConnect->prepare('
                INSERT INTO
                  userteam
                  (person, team)
                VALUES
                  (:person, :team)');

            $queryresult->execute(array(
                'person' => $_POST['person'],
                'team' => $_POST['team']
            ));
            return array(
                'page' => '/?r=userteam&person='.$_POST['person']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function userteam_delete($dbConnect) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            $queryresult = $dbConnect->prepare('
                    DELETE FROM
                      userteam
                    WHERE id = :ur');

            $queryresult->execute(array(
                'ur' => $_GET['ur']
            ));
            return array(
                'page' => '/?r=userteam&person='.$_GET['person']
            );
        }
        else {
            return 'ERROR-403';
        }
    }