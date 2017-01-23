<?php
    function document_index($dbConnect, $CONSTPath) {
    	$res = array();
    	require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/start.php');
    	$res['navigation'] = start_navig();
        $res['answer'] = common_getlist($dbConnect, '
          SELECT id, title, link, date FROM document WHERE federation = :federation ORDER BY date DESC', array(
            'federation' => $_GET['federation']
        ));
        return $res;
    }
    function document_add($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3)  || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {
            $res = array();
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/federation.php');
            $res['navigation'] = federation_navig($dbConnect, $federation = null);
            return $res;
        }
        else {
            return 'ERROR-403';
        }
    }
    function document_create($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3)  || ($_SESSION['userFederations'][$_POST['federation']] == 1)) {

            $date = common_dateToSQL($_POST['date']);
            common_query($dbConnect, '
            INSERT INTO
              document
              (title, link, date, federation)
            VALUES
              (:title, :link, :date, :federation)
            ', array(
                'title' => trim($_POST['title']),
                'link' => common_loadFile('link', $CONSTPath, 'document/' . time() . '_' .common_translit($_FILES['link']['name'])),
                'date' => $date,
                'federation' => $_POST['federation']
            ));
            return array(
                'page' => '/?r=document&federation='.$_POST['federation']
            );
        } else {
            return 'ERROR-403';
        }

    }
    function document_delete($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3)  || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {
            $rec = common_getrecord($dbConnect, '
                SELECT link FROM document WHERE id = :doc LIMIT 1',
                array(
                    'doc' => $_GET['doc']
                )
            );
            if ($rec) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/upload/' . $rec['link']);
            }
            common_query($dbConnect, '
            DELETE FROM
              document
            WHERE
              id = :doc
            ', array(
                'doc' => $_GET['doc']
            ));
            return array(
                'page' => '/?r=document&federation='.$_GET['federation']
            );
        }
        else {
            return 'ERROR-403';
        }

    }
    function document_edit($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3)  || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {
            $res = array();
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/federation.php');
            $res['navigation'] = federation_navig($dbConnect, $federation = null);
            $rec = common_getrecord($dbConnect, '
                    SELECT title, date FROM document WHERE id = :doc LIMIT 1',
                array(
                    'doc' => $_GET['doc']
                )
            );
            $res['answer'] = $rec;
            return $res;
        }
        else {
            return 'ERROR-403';
        }

    }
    function document_update($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3)  || ($_SESSION['userFederations'][$_POST['federation']] == 1)) {
            $date = common_dateToSQL($_POST['date']);
            common_query($dbConnect, '
                UPDATE
                  document
                SET title = :title, date = :date
                WHERE id = :doc
                ', array(
                    'title' => trim($_POST['title']),
                    'doc' => $_POST['doc'],
                    'date' => $date
                )
            );
            return array(
                'page' => '/?r=document&federation='.$_POST['federation']
            );
        } else {
            return 'ERROR-403';
        }

    }