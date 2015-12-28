<?php
    //OK
    function competition_NAVIG($dbConnect, $id) {
        $queryresult = $dbConnect->prepare('
                SELECT
                  C.id, C.name AS name, S.yearB AS yearB, S.yearE AS yearE, logo, theme
                FROM
                  competition AS C LEFT JOIN season AS S ON S.id = C.season
                WHERE
                  C.id = :id
                LIMIT 1');
        $queryresult->execute(array(
            'id' => $id
        ));
        $data = $queryresult->fetchAll();
        if ($data[0]['yearB'] == $data[0]['yearE'] || !$data[0]['yearE']) {
            $year = $data[0]['yearB'];
        }
        else {
            $year = $data[0]['yearB'] . '/' . $year = $data[0]['yearE'];
        }
        return array(
            'header' => $data[0]['name'] . ' ' . $year,
            'menu' => array(
                'О турнире' => '/?r=competition/view&comp=' . $id,
                'Новости' => '/?r=news/index&comp=' . $id,
                'Команды' => '/?r=team/complist&comp=' . $id,
                'Судьи' => '/?r=refereecomp&comp=' . $id,
                /*'Таблица' => '/?r=competition/standings&id='.$id,*/
                'Календарь игр' => '/?r=match&comp=' . $id
            ),
            'title' => $data[0]['name'] . ' по американскому футболу',
            'description' => 'Официальный сайт ' . $data[0]['name'] . ' по американскому футболу. Здесь вы можете найти свежие новости, информацию о матчах и командах',
            'keywords' => array($data[0]['name'] . ' ' . $year, $data[0]['name']),
            'logo' => $data[0]['logo'],
            'theme' => $data[0]['theme']
        );
    }


    function competition_index($dbConnect, $CONSTPath) {
        $result = array();
        $filter = '';
        $params = array();
        if ($_GET['federation']) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/federation.php');
            $result['navigation'] = federation_navig($dbConnect);
            $filter .= ' AND competition.federation = :federation';
            $params['federation'] = $_GET['federation'];
        }
        $dataset = common_getlist($dbConnect, '
            SELECT
              competition.link, competition.id, competition.name, S.yearB, S.yearE
            FROM
              competition LEFT JOIN season AS S ON S.id = competition.season
            WHERE
               TRUE'.$filter.'
            ORDER BY competition.name', $params);
        $result['answer'] = $dataset;

        return $result;
    }


    function competition_view ($dbConnect, $CONSTPath)
    {
        $result = array(
            'answer' => array()
        );
        $today = strftime('%Y-%m-%d');

        $query = '
            SELECT
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, T1.city, date,
              T1.rus_name AS t1name,
              T2.rus_name AS t2name
            FROM
              `match` M
            LEFT JOIN team T1 ON T1.id = M.team1
            LEFT JOIN team T2 ON T2.id = M.team2
            WHERE M.competition = :comp AND date <= :date
            ORDER BY M.date DESC, M.id DESC
            LIMIT 5
        ';

        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute(array(
            'comp' => $_GET['comp'],
            'date' => $today
        ));
        $dataset = $queryresult->fetchAll();
        if (count($dataset) < 5) {
            $query = '
            SELECT * FROM (
                SELECT
                  M.id, M.competition, M.team1, M.team2, M.score1, M.score2, T1.city, date,
                  T1.rus_name AS t1name,
                  T2.rus_name AS t2name
                FROM
                  `match` M
                LEFT JOIN team T1 ON T1.id = M.team1
                LEFT JOIN team T2 ON T2.id = M.team2
                WHERE M.competition = :comp
                ORDER BY M.date ASC, M.id ASC
                LIMIT 5
            ) MM
            ORDER BY date DESC, id DESC
          ';

            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'comp' => $_GET['comp']
            ));
            $dataset = $queryresult->fetchAll();
        }



        $result['answer']['results'] = $dataset;

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/action.php');
        $top10 = action_top10($dbConnect, $CONSTPath);
        $result['answer']['top10'] = $top10['answer'];
	    $top10kick = action_top10kickers($dbConnect, $CONSTPath);
        $result['answer']['top10kick'] = $top10kick['answer'];


        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/translation.php');
        $result['answer']['trans'] = translation_mainpage($dbConnect, $CONSTPath);

        $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);

        return $result;

    }

    function competition_info ($dbConnect, $CONSTPath, $comp) {
        if (!$comp) {
            $comp = $_GET['comp'];
        }
        $queryresult = $dbConnect->prepare('
                SELECT
                  C.name, S.yearB, S.yearE
                FROM
                  competition C LEFT JOIN season S ON S.id = C.season
                WHERE C.id = :comp
                LIMIT 1
                  ');
        $queryresult->execute(array(
            'comp' => $comp
        ));
        $compInfo = $queryresult->fetchAll();
        return $compInfo[0];
    }