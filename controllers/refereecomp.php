<?php
    function refereecomp_index($dbConnect, $CONSTPath) {
        $result = array(
            'answer' => array()
        );
        if ($_GET['comp']) {
            $result['answer']['referee'] = common_getlist($dbConnect, '
                SELECT
                    P.id, P.surname, P.name, P.patronymic, P.birthdate, P.avatar, R.id AS refid, RC.id AS rc, GC.name AS country
                FROM
                    refereecomp AS RC LEFT JOIN referee R ON R.id = RC.referee
                    LEFT JOIN person AS P ON P.id = R.person
                    LEFT JOIN geo_country GC ON P.geo_country = GC.id
                WHERE
                    RC.competition = :competition
                ORDER BY P.surname
            ', array(
                'competition' => $_GET['comp']
            ));
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/referee.php');
            $result['answer']['all'] = referee_list($dbConnect, $CONSTPath);
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
            $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
            $result['navigation']['mobile_view'] = 1;
        }
        return $result;
    }

    function refereecomp_create($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_POST['competition']] == 1)) {
            $type = 1;
            if ($_POST['main']) {
                $type = 2;
            }
            common_query($dbConnect, '
                INSERT INTO refereecomp
                (referee, competition, type)
                VALUES (:referee, :competition, :type)
            ', array(
                'referee' => $_POST['referee'],
                'competition' => $_POST['competition'],
                'type' => $type
            ));
            return array(
                'page' => '/?r=refereecomp&comp='.$_POST['competition']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function refereecomp_delete($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            common_query($dbConnect, '
                    DELETE FROM refereecomp
                    WHERE id = :rc
                ', array(
                'rc' => $_GET['rc']
            ));
            return array(
                'page' => '/?r=refereecomp&comp='.$_GET['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }