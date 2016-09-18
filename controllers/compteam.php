<?php
    function compteam_add($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            $result = array();
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
            $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/group.php');
            $group = group_index($dbConnect, $CONSTPath);
            $result['answer']['group'] = $group['answer'];

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/team.php');
            $group = team_index($dbConnect, $CONSTPath);
            $result['answer']['team'] = $group['answer'];
            $result['navigation']['mobile_view'] = 1;

            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function compteam_create($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            $group = null;
            if ($_POST['group']) {
                $group = $_POST['group'];
            }
            $queryresult = $dbConnect->prepare('
                INSERT INTO
                  `compteam`
                  (team, competition, `group`)
                VALUES
                  (:team, :comp, :group)');

            $queryresult->execute(array(
                'team' => $_POST['team'],
                'comp' => $_POST['comp'],
                'group' => $group
            ));
            return array(
                'page' => '/?r=team/complist&comp='.$_POST['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function compteam_delete($dbConnect, $CONSTPath) {

        if ($_SESSION['userType'] == 3) {
            $queryresult = $dbConnect->prepare('
                    DELETE FROM
                      `compteam`
                    WHERE id = :id');

            $queryresult->execute(array(
                'id' => $_GET['id']
            ));
            return array(
                'page' => '/?r=team/complist&comp='.$_GET['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }