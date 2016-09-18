<?php
    function group_index($dbConnect, $CONSTPath) {
        $result = array();
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
        $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
        $result['answer'] = common_getlist($dbConnect, 'SELECT id, name FROM `group` WHERE competition = :comp', array('comp' => $_GET['comp']));
        $result['navigation']['mobile_view'] = 1;
        return $result;
    }

    function group_add($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            $result = array();
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
            $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
            $result['navigation']['mobile_view'] = 1;
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function group_create($dbConnect, $CONSTPath) {

        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_POST['comp']] == 1)) {
            $queryresult = $dbConnect->prepare('
            INSERT INTO
              `group`
              (name, competition)
            VALUES
              (:name, :comp)');

            $queryresult->execute(array(
                'name' => $_POST['name'],
                'comp' => $_POST['comp']
            ));
            return array(
                'page' => '/?r=group&comp='.$_POST['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function group_delete($dbConnect, $CONSTPath) {

        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            $queryresult = $dbConnect->prepare('
                DELETE FROM
                  `group`
                WHERE id = :id');

            $queryresult->execute(array(
                'id' => $_GET['id']
            ));
            return array(
                'page' => '/?r=group&comp='.$_GET['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }