<?php
    //OK
    function material_user($dbConnect, $id) {
        $queryresult = $dbConnect->prepare('
                SELECT
                  user
                FROM
                  material AS M
                WHERE
                  M.id = :id
                LIMIT 1');
        $queryresult->execute(array(
            'id' => $id
        ));
        $data = $queryresult->fetchAll();
        return $data['user'];
    }
    function material_view($dbConnect, $CONSTPath) {
        /*if (isset($_SESSION['userID'])) {*/
            $queryresult = $dbConnect->prepare('
                SELECT
                  M.id, M.title, M.preview, M.content, M.date, user, M.ismain, M.image
                FROM
                  material AS M
                WHERE
                  M.id = :id
                LIMIT 1');
            $queryresult->execute(array(
                'id' => $_GET['mater']
            ));
            $data = $queryresult->fetchAll();
            if (count($data)) {
                $result['answer'] = $data[0];
            } else {
                $result['answer'] = array();
            }

            if ($_GET['comp']) {
                require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
                $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
            }
            if ($_GET['team']) {
                require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
                $result['navigation'] = team_NAVIG($dbConnect, $_GET['team']);
            }

            if ($_GET['federation']) {
                require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/federation.php');
                $result['navigation'] = federation_navig($dbConnect, $_GET['federation']);
            }
            return $result;
        /*}
        else {
            return 'ERROR-403';
        }*/
    }

    function material_edit($dbConnect, $CONSTPath) {
        $user = material_user($dbConnect, $_GET['mater']);
        $access = $_SESSION['userType'] == 3;
        if ($_GET['comp']) {
            $access = $_SESSION['userType'] == 3;
        }
        if ($_GET['team']) {
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']]);
        }
        if ($_GET['federation']) {
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']]);
        }
        if ($access) {
            return material_view($dbConnect, $CONSTPath);
        }
        else {
            return 'ERROR-403';
        }
    }

    function material_delete($dbConnect) {
        $user = material_user($dbConnect, $_POST['id']);
        $access = $_SESSION['userType'] == 3;
        if ($_POST['comp']) {
            $access = $_SESSION['userType'] == 3;
        }
        if ($_POST['team']) {
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_POST['team']]);
        }
        if ($_POST['federation']) {
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_POST['federation']]);
        }
        if ($access) {
            $queryresult = $dbConnect->prepare('
            DELETE FROM
              material
            WHERE
              id = :id');

            $queryresult->execute(array(
                'id' => $_POST['mater']
            ));

            $filter = '';
            if($_POST['comp']) {
                $filter .= '&comp='.$_POST['comp'];
            }
            if($_POST['team']) {
                $filter .= '&team='.$_POST['team'];
            }
            if($_POST['federation']) {
                $filter .= '&federation='.$_POST['federation'];
            }

            return array(
                'page' => '/?r=news'.$filter
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function material_update($dbConnect, $CONSTPath) {

        $user = material_user($dbConnect, $_POST['id']);

        $access = $_SESSION['userType'] == 3;
        if ($_POST['comp']) {
            $access = $_SESSION['userType'] == 3;
        }
        if ($_POST['team']) {
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_POST['team']]);
        }
        if ($_POST['federation']) {
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userFederation'][$_POST['federation']]);
        }
        if ($access) {
            $queryresult = $dbConnect->prepare('
              SELECT
                image
              FROM
                material AS M
              WHERE id = :id');
            $queryresult->execute(array(
                'id' => $_POST['mater']
            ));
            $data = $queryresult->fetchAll();
            if (count($data)) {
                $oldImage = $data[0]['image'];
            }

            $image = common_loadFile('image', $CONSTPath, NULL, 940);
            if ($image) {
                if ($oldImage) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/upload/' . $oldImage);
                }
            }
            else {
                $image = $oldImage;
            }

            $queryresult = $dbConnect->prepare('
            UPDATE
              material
            SET
              title = :title,
              preview = :preview,
              content = :content,
              ismain = :ismain,
              image = :image
            WHERE
              id = :id');

            $ismain = $_POST['ismain'] ?  1 : 0;
            $queryresult->execute(array(
                'id' => $_POST['mater'],
                'title' => $_POST['title'],
                'preview' => $_POST['preview'],
                'content' => $_POST['content'],
                'ismain' => $ismain,
                'image' => $image
            ));
            $filter = '';
            if($_POST['comp']) {
                $filter .= '&comp='.$_POST['comp'];
            }
            if($_POST['team']) {
                $filter .= '&team='.$_POST['team'];
            }
            if($_POST['federation']) {
                $filter .= '&federation='.$_POST['federation'];
            }
            if ($_POST['federation'] && $_POST['federation'] == 11) {
                $ret = array(
                    'page' => '/?r=start/index'
                );
            }
            else {
                $ret = array(
                    'page' => '/?r=news'.$filter
                );
            }

            return $ret;
        }
        else {
            return 'ERROR-403';
        }
    };

    function material_add($dbConnect, $CONSTPath) {
        $result = array(
            'answer' => 1
        );
        $access = $_SESSION['userType'] == 3;
        if ($_GET['comp']) {
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
            $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
            $access = $_SESSION['userType'] == 3;
        }
        if ($_GET['team']) {
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
            $result['navigation'] = team_NAVIG($dbConnect, $_GET['team']);
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']]);
        }
        if ($_GET['federation']) {
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/federation.php');
            $result['navigation'] = federation_navig($dbConnect, $_GET['federation']);
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']]);
        }
        if ($access) {
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }
    function material_create($dbConnect, $CONSTPath) {
        $filter = '';
        $access = $_SESSION['userType'] == 3;
        if($_POST['comp']) {
            $filter .= '&comp='.$_POST['comp'];
            $access = $_SESSION['userType'] == 3;
        }
        if($_POST['team']) {
            $filter .= '&team='.$_POST['team'];
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_POST['team']]);
        }
        if($_POST['federation']) {
            $filter .= '&federation='.$_POST['federation'];
            $access = ($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_POST['federation']]);
        }
        if ($access) {
            $user = $_SESSION['userID'];
            $date = date('Y-m-d');
            $queryresult = $dbConnect->prepare('
            INSERT INTO
              material
            (title, content, preview, user, date, ismain, image)
            VALUES
              (:title, :content, :preview, :user, :date, :ismain, :image)');

            $ismain = $_POST['ismain'] ?  1 : 0;
            $image = common_loadFile('image', $CONSTPath, NULL, 940);
            $queryresult->execute(array(
                'user' => $user,
                'date' => $date,
                'title' => $_POST['title'],
                'preview' => $_POST['preview'],
                'content' => $_POST['content'],
                'ismain' => $ismain,
                'image' => $image
            ));
            $mater_id = $dbConnect->lastInsertId('id');

            $arguments = array(
                'material' => $mater_id
            );
            $query = 'INSERT INTO new (material';
                if ($_POST['comp']) {
                    $query .= ' , competition';
                    $arguments['competition'] = $_POST['comp'];
                }
                if ($_POST['team']) {
                    $query .= ' , team';
                    $arguments['team'] = $_POST['team'];
                }
                if ($_POST['federation']) {
                    $query .= ' , federation';
                    $arguments['federation'] = $_POST['federation'];
                }
                if ($_POST['person']) {
                    $query .= ' , person';
                    $arguments['person'] = $_POST['person'];
                }
            $query .= ') VALUES ( :material';
                if ($_POST['comp']) {
                    $query .= ' , :competition';
                }
                if ($_POST['team']) {
                    $query .= ' , :team';
                }
                if ($_POST['federation']) {
                    $query .= ' , :federation';
                }
                if ($_POST['person']) {
                    $query .= ' , :person';
                }
            $query .= ')';

            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute($arguments);


            if ($_POST['federation'] && $_POST['federation'] == 11) {
                $ret = array(
                    'page' => '/?r=start/index'
                );
            }
            else {
                $ret = array(
                    'page' => '/?r='.$_POST['ret'].$filter
                );
            }

            return $ret;
        }
        else {
            return 'ERROR-403';
        }

    };