<?php
    function statconfig_list($dbConnect, $CONSTPath) {
        return common_getlist($dbConnect, 'SELECT id, name FROM statactiontype ORDER BY name');
    }

    function statconfig_index($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
            $result = array(
                'navigation' => admin_navig()
            );
            $result['answer'] = statconfig_list($dbConnect, $CONSTPath);
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function statconfig_add($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
            $result = array(
                'navigation' => admin_navig()
            );
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function statconfig_create($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            common_query($dbConnect,
                'INSERT INTO statactiontype
                  (name) VALUES (:name)'
                , array(
                    'name' => $_POST['name']
                )
            );
            $id = $dbConnect->lastInsertId('id');
            common_query($dbConnect,
                'INSERT INTO statpersontype
                  (name, actiontype) VALUES (:name, :type)'
                , array(
                    'name' => 'Исполнитель',
                    'type' => $id
                )
            );
            return array(
                'page' => '/?r=statconfig/edit&type='.$id
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function statconfig_delete($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            common_query($dbConnect,
                'DELETE FROM statactiontype WHERE id = :type'
                , array(
                    'type' => $_GET['type']
                )
            );
            return array(
                'page' => '/?r=statconfig'
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function statconfig_update($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            common_query($dbConnect,
                'UPDATE statactiontype
                      SET name = :name
                 WHERE id = :id'
                , array(
                    'name' => $_POST['name'],
                    'id' => $_POST['type']
                )
            );
            $_SESSION['message'] = 'Изменения сохранены';
            return array(
                'page' => '/?r=statconfig/edit&type='.$_POST['type']
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function statconfig_edit($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
            $result = array(
                'navigation' => admin_navig(),
                'answer' => array()
            );
            $params = array(
                'type' => $_GET['type']
            );
            $result['answer']['actiontype'] = common_getrecord($dbConnect,
                'SELECT id, name FROM statactiontype WHERE id = :type', $params);

            $result['answer']['chartype'] = common_getlist($dbConnect,
                'SELECT id, name FROM statchartype WHERE actiontype = :type ORDER BY id', $params);

            $result['answer']['persontype'] = common_getlist($dbConnect,
                'SELECT id, name FROM statpersontype WHERE actiontype = :type ORDER BY id', $params);

            $result['answer']['point'] = common_getlist($dbConnect,
                'SELECT
                    S.id, S.pointsget, P.name
                 FROM
                    statpoint S LEFT JOIN pointsget P ON P.id = S.pointsget
                 WHERE actiontype = :type ORDER BY id', $params);

            $result['answer']['pointsget'] = common_getlist($dbConnect,
                'SELECT id, name FROM pointsget WHERE sport = 1', $params);
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    };

    function statconfig_createChar($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            common_query($dbConnect,
                'INSERT INTO statchartype
                      (name, actiontype) VALUES (:name, :type)'
                , array(
                    'name' => $_POST['name'],
                    'type' => $_POST['type']
                )
            );
            return array(
                'page' => '/?r=statconfig/edit&type='.$_POST['type']
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function statconfig_deleteChar($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            common_query($dbConnect,
                'DELETE FROM statchartype WHERE id = :char'
                , array(
                    'char' => $_GET['char']
                )
            );
            return array(
                'page' => '/?r=statconfig/edit&type='.$_GET['type']
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function statconfig_createPerson($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            common_query($dbConnect,
                'INSERT INTO statpersontype
                          (name, actiontype) VALUES (:name, :type)'
                , array(
                    'name' => $_POST['name'],
                    'type' => $_POST['type']
                )
            );
            return array(
                'page' => '/?r=statconfig/edit&type='.$_POST['type']
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function statconfig_deletePerson($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            common_query($dbConnect,
                'DELETE FROM statpersontype WHERE id = :person'
                , array(
                    'person' => $_GET['person']
                )
            );
            return array(
                'page' => '/?r=statconfig/edit&type='.$_GET['type']
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function statconfig_createPoint($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            common_query($dbConnect,
                'INSERT INTO statpoint
                              (pointsget, actiontype) VALUES (:pointsget, :type)'
                , array(
                    'pointsget' => $_POST['pointsget'],
                    'type' => $_POST['type']
                )
            );
            return array(
                'page' => '/?r=statconfig/edit&type='.$_POST['type']
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function statconfig_deletePoint($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            common_query($dbConnect,
                'DELETE FROM statpoint WHERE id = :point'
                , array(
                    'point' => $_GET['point']
                )
            );
            return array(
                'page' => '/?r=statconfig/edit&type='.$_GET['type']
            );
        }
        else {
            return 'ERROR-403';
        }
    };