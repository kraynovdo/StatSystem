<?php
    //OK
    function news_index($dbConnect, $CONSTPath, $ismain = false) {
        $filter = '';
        $result = array();
        $queryparams = array();
        if ($_GET['comp']) {
            $filter .= ' WHERE new.competition = :comp ';
            $queryparams['comp'] = $_GET['comp'];
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
            $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
        }
        if ($_GET['team']) {
            $filter .= ' WHERE new.team = :team ';
            $queryparams['team'] = $_GET['team'];
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
            $result['navigation'] = team_NAVIG($dbConnect, $_GET['team']);
        }
        if ($_GET['federation']) {
            $filter .= ' WHERE new.federation = :federation ';
            $queryparams['federation'] = $_GET['federation'];
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/federation.php');
            $result['navigation'] = federation_navig($dbConnect, $_GET['federation']);
        }
        if ($ismain) {
            $filter .= ' AND M.ismain = 1';
        }
        $query = '
            SELECT
              new.id, M.title, M.preview, M.content, M.date, material, image
            FROM
              new LEFT JOIN material AS M ON M.id = new.material' . $filter . '
            ORDER BY date DESC';

        $result['answer'] = common_getlist($dbConnect, $query, $queryparams);
        return $result;

    }


