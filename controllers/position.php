<?php
function position_index($dbConnect, $CONSTPath) {
    $result = array();
    $queryresult = $dbConnect->prepare('SELECT P.id, P.name, P.rus_name, P.abbr FROM position AS P ORDER BY P.abbr');
    $queryresult->execute();
    $dataset = $queryresult->fetchAll();
    $result['answer'] = $dataset;
    require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
    $result['navigation'] = admin_navig();

    return $result;
}
function position_edit($dbConnect, $CONSTPath) {
    if (isset($_SESSION['userID']) && $_SESSION['userType'] == 3) {
        $queryresult = $dbConnect->prepare('
                    SELECT
                      id, name, rus_name, abbr
                    FROM
                      position
                    WHERE
                      position.id = :id
                    LIMIT 1');
        $queryresult->execute(array(
            'id' => $_GET['id']
        ));
        $data = $queryresult->fetchAll();
        if (count($data)) {
            $result['answer'] = array();
            $result['answer']['position'] = $data[0];
        } else {
            $result['answer'] = array();
        }
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
        $result['navigation'] = admin_navig();
        return $result;
    }
    else {
        return 'ERROR-403';
    }
}
function position_update($dbConnect, $CONSTPath) {
    if (isset($_SESSION['userID']) && $_SESSION['userType'] == 3) {
        $queryresult = $dbConnect->prepare('
                UPDATE
                  position
                SET
                  name = :name,
                  rus_name = :rus_name,
                  abbr = :abbr
                WHERE
                  id = :id');
        $queryresult->execute(array(
            'id' => $_POST['id'],
            'name' => $_POST['name'],
'rus_name' => $_POST['rus_name'],
            'abbr' => $_POST['abbr']
        ));
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
        return array(
            'navigation' => admin_navig(),
            'page' => '/?r=position'
        );
    }
    else {
        return 'ERROR-403';
    }
}
function position_delete($dbConnect) {
    if ($_SESSION['userID'] || ($_SESSION['userType'] == 3)) {
        $queryresult = $dbConnect->prepare('
            DELETE FROM
              position
            WHERE
              id = :id');

        $queryresult->execute(array(
            'id' => $_POST['id']
        ));
        return array(
            'page' => '/?r=position'
        );
    }
    else {
        return 'ERROR-403';
    }
}
function position_add($dbConnect, $CONSTPath) {
    if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
        return array (
            'navigation' => admin_navig()
        );
    }
    else {
        return 'ERROR-403';
    }
}
function position_create($dbConnect) {
    if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
        $queryresult = $dbConnect->prepare('
            INSERT INTO
              position
              (name, rus_name, abbr)
            VALUES
              (:name, :rus_name, :abbr)');

        $queryresult->execute(array(
            'name' => $_POST['name'],
'rus_name' => $_POST['rus_name'],
            'abbr' => $_POST['abbr']
        ));
        return array(
            'page' => '/?r=position'
        );
    }
    else {
        return 'ERROR-403';
    }
}