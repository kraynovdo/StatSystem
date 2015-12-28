<?php
    function sport_index($dbConnect, $CONSTPath) {
        $result = array();
        $queryresult = $dbConnect->prepare('SELECT id, name FROM sport');
        $queryresult->execute(array());
        $dataset = $queryresult->fetchAll();
        $result['answer'] = $dataset;
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
        $result['navigation'] = admin_navig();
        return $result;
    }
    function sport_edit($dbConnect, $CONSTPath) {
        if (isset($_SESSION['userID'])) {
            $queryresult = $dbConnect->prepare('
                    SELECT
                      id, name
                    FROM
                      sport
                    WHERE
                      sport.id = :id
                    LIMIT 1');
            $queryresult->execute(array(
                'id' => $_GET['id']
            ));
            $data = $queryresult->fetchAll();
            if (count($data)) {
                $result['answer'] = $data[0];
            } else {
                $result['answer'] = array();
            }
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
            $result['navigation'] = admin_navig();
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }
    function sport_update($dbConnect) {
        if (isset($_SESSION['userID']) && $_SESSION['userType'] == 3) {
            $queryresult = $dbConnect->prepare('
                UPDATE
                  sport
                SET
                  name = :name
                WHERE
                  id = :id');
            $queryresult->execute(array(
                'id' => $_POST['id'],
                'name' => $_POST['name']
            ));
            return array(
                'page' => '/?r=sport'
            );
        }
        else {
            return 'ERROR-403';
        }
    }
    function sport_delete($dbConnect) {
        if ($_SESSION['userID'] || ($_SESSION['userType'] == 3)) {
            $queryresult = $dbConnect->prepare('
            DELETE FROM
              sport
            WHERE
              id = :id');

            $queryresult->execute(array(
                'id' => $_POST['id']
            ));
            return array(
                'page' => '/?r=sport'
            );
        }
        else {
            return 'ERROR-403';
        }
    }
    function sport_add($db, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
            return array('answer' => 1, 'navigation' => admin_navig());
        }
        else {
            return 'ERROR-403';
        }
    }
    function sport_create($dbConnect) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            $queryresult = $dbConnect->prepare('
            INSERT INTO
              sport
              (name)
            VALUES
              (:name)');

            $queryresult->execute(array(
                'name' => $_POST['name']
            ));
            return array(
                'page' => '/?r=sport'
            );
        }
        else {
            return 'ERROR-403';
        }
    }