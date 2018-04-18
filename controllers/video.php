<?php
    function video_list ($dbConnect, $category=null) {
        $videolist = array();
        if ($category == 100) {
            $videolist = common_getlist($dbConnect, '
                SELECT
                   -1 AS id,
                   CONCAT(T1.rus_name, \' - \', T2.rus_name, \' \', M.timeh, \':\', M.timem, \' (мск.)\') AS title,
                   M.video AS content,
                   M.date
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
                   V.id, V.title, V.content, V.date
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
                           V.id, V.title, V.content, V.date
                        FROM
                            video V
                        WHERE
                            V.competition = :comp
                    UNION
                        SELECT
                           -1 AS id,
                           CONCAT(T1.rus_name, \' - \', T2.rus_name, \' \', M.timeh, \':\', M.timem, \' (мск.)\') AS title,
                           M.video AS content,
                           M.date
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

            //return $result;
        }
        else {
            return 'ERROR-403';
        }
    }