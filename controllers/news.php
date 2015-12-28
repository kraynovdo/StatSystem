<?php
    //OK
    function news_index($dbConnect, $CONSTPath) {
        $filter = '';
        $result = array();
        $queryparams = array();
        if ($_GET['comp']) {
            $filter .= ' WHERE new.competition = :comp ';
            $queryparams['comp'] = $_GET['comp'];
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
            $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
        }
        if ($_GET['team']) {
            $filter .= ' WHERE new.team = :team ';
            $queryparams['team'] = $_GET['team'];
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
            $result['navigation'] = team_NAVIG($dbConnect, $_GET['team']);
        }
        if ($_GET['federation']) {
            $filter .= ' WHERE new.federation = :federation ';
            $queryparams['federation'] = $_GET['federation'];
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/federation.php');
            $result['navigation'] = federation_navig($dbConnect, $_GET['federation']);
        }
        $query = '
            SELECT
              new.id, M.title, M.preview, M.content, M.date, material
            FROM
              new LEFT JOIN material AS M ON M.id = new.material' . $filter . '
            ORDER BY date DESC';

        $result['answer'] = common_getlist($dbConnect, $query, $queryparams);
        return $result;

    }


