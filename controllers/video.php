<?php
    function video_list ($dbConnect, $category=null) {
        $videolist = array();
        if ($category == 100) {
            $videolist = common_getlist($dbConnect, '
                SELECT
                   -1 AS id,
                   CONCAT(T1.rus_name, \' - \', T2.rus_name, \' \', M.timeh, \':\', M.timem, \' (мск.)\') AS title,
                   M.video AS content,
                   M.date,
                   M.id AS mid
                FROM
                    `match` M
                    LEFT JOIN team T1 ON T1.id = M.team1
                    LEFT JOIN team T2 ON T2.id = M.team2
                WHERE
                    M.video <> \'\' AND
                    M.competition = :comp
                ORDER BY M.date DESC

            ', array('comp' => $_GET['comp']));
        }
        else if ($category == 1 || $category == 2) {
            $videolist = common_getlist($dbConnect, '
                SELECT
                   V.id, V.title, V.content, V.date, -1 as mid
                FROM
                    video V
                WHERE
                    V.competition = :comp AND V.category = :category
                ORDER BY V.date DESC

            ', array('comp' => $_GET['comp'], 'category' => $category));
        }
        else {
            $videolist = common_getlist($dbConnect, '
                SELECT * FROM (
                        SELECT
                           V.id, V.title, V.content, V.date, -1 as mid
                        FROM
                            video V
                        WHERE
                            V.competition = :comp
                    UNION
                        SELECT
                           -1 AS id,
                           CONCAT(T1.rus_name, \' - \', T2.rus_name, \' \', M.timeh, \':\', M.timem, \' (мск.)\') AS title,
                           M.video AS content,
                           M.date,
                           M.id as mid
                        FROM
                            `match` M
                            LEFT JOIN team T1 ON T1.id = M.team1
                            LEFT JOIN team T2 ON T2.id = M.team2
                        WHERE
                            M.video <> \'\' AND
                            M.competition = :comp

                ) U ORDER BY U.date DESC

            ', array('comp' => $_GET['comp'], 'category' => $category));
        }
        return $videolist;
    }

    function video_livetoday($dbConnect, $CONSTPath) {
        $videolist = common_getlist($dbConnect, '
                SELECT
                   -1 AS id,
                   CONCAT(T1.rus_name, \' - \', T2.rus_name, \' \', M.timeh, \':\', M.timem, \' (мск.)\') AS title,
                   M.video AS content,
                   M.date,
                   M.id AS mid
                FROM
                    `match` M
                    LEFT JOIN team T1 ON T1.id = M.team1
                    LEFT JOIN team T2 ON T2.id = M.team2
                WHERE
                    M.video <> \'\' AND
                    M.competition = :comp AND
                    M.date = :date
                ORDER BY M.date DESC

            ', array('comp' => $_GET['comp'], 'date' => date('Y-m-d')));
        return $videolist;
    }

    function video_edit ($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            $result = array(
                'answer' => array()
            );
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/admin.php');

            $result['navigation'] = admin_navig();

            if ($_GET['video']) {
                $rec = common_getrecord($dbConnect, '
                    SELECT
                      id, title, content, date, ismain, category
                    FROM
                      video
                    WHERE
                      id = :id
                ', array('id' => $_GET['video']));
                $result['answer'] = $rec;
            }

            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function video_update ($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {

            $ismain = $_POST['ismain'] ?  1 : 0;
            if ($_POST['date']) {
                $date = common_dateToSQL($_POST['date']);
            }
            else {
                $date = date('Y-m-d');
            }
            if ($_POST['video']) {
                common_query ($dbConnect, '
                    UPDATE
                      video
                    SET
                      title = :title,
                      content = :content,
                      ismain = :ismain,
                      category = :category,
                      date = :date
                    WHERE
                      id = :id
                ', array(
                    'date' => $date,
                    'title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'ismain' => $ismain,
                    'category' => $_POST['category'],
                    'id' => $_POST['video']
                ));
            }
            else {
                common_query ($dbConnect, '
                    INSERT INTO
                      video
                      (title, content, date, ismain, category, competition)
                    VALUES
                      (:title, :content, :date, :ismain, :category, :competition)', array(
                        'date' => $date,
                        'title' => $_POST['title'],
                        'content' => $_POST['content'],
                        'ismain' => $ismain,
                        'category' => $_POST['category'],
                        'competition' => $_POST['comp']
                    ));
            }

            return array(
                'page' => '/?r=competition/video&comp='.$_POST['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function video_delete ($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            if ($_GET['video']) {
                common_query ($dbConnect, '
                        DELETE
                            FROM
                              video
                        WHERE
                          id = :id
                    ', array(
                    'id' => $_GET['video']
                ));
            }

            return array(
                'page' => '/?r=competition/video&comp='.$_GET['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function video_view ($dbConnect, $CONSTPath) {
        $result = array(
            'answer' => array()
        );
        if ($_GET['comp']) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
            $navigation = competition_lafNavig();
            $navigation['pageId'] = 52;
            $result['navigation'] = $navigation;

            if ($_GET['video'] == -1) {
                $rec = common_getrecord($dbConnect, '
                    SELECT
                       -1 AS id,
                       CONCAT(T1.rus_name, \' - \', T2.rus_name, \' \', M.timeh, \':\', M.timem, \' (мск.)\') AS title,
                       M.video AS content,
                       M.date,
                       M.id AS mid
                    FROM
                        `match` M
                        LEFT JOIN team T1 ON T1.id = M.team1
                        LEFT JOIN team T2 ON T2.id = M.team2
                    WHERE
                        M.id = :match
                ', array(
                    'match' => $_GET['match']
                ));
            }
            else {
                $rec = common_getrecord($dbConnect, '
                    SELECT
                       V.id, V.title, V.content, V.date, -1 as mid
                    FROM
                        video V
                    WHERE
                        V.id = :video
                ', array(
                    'video' => $_GET['video']
                ));
            }

            $result['answer'] = $rec;
            $result['answer']['player'] = common_getPlayer($rec['content'], 640, 360);
        }

        return $result;
    }

