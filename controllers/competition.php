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
        $res = array(
            'header' => $data[0]['name'] . ' ' . $year,
            'menu' => array(
                'О турнире' => '/?r=competition/view&comp=' . $id,
                'Новости' => '/?r=news/index&comp=' . $id,
                'Команды' => '/?r=team/complist&comp=' . $id,
                'Судьи' => '/?r=refereecomp&comp=' . $id,
                /*'Таблица' => '/?r=competition/standings&id='.$id,*/
                'Календарь' => '/?r=match&comp=' . $id
            ),
            'title' => $data[0]['name'],
            'description' => $data[0]['name'] . ' официальный сайт. Здесь вы можете найти свежие новости, информацию о матчах и командах',
            'keywords' => array($data[0]['name'] . ' ' . $year, $data[0]['name']),
            'logo' => $data[0]['logo'],
            'theme' => $data[0]['theme']
        );
        if (($_SESSION['userType'] == 3) || ($id == 41)) {
            $res['menu']['Статистика'] = '/?r=stats/compAF&comp=' . $id;
        }
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            $res['menu']['* Группы'] = '/?r=group&comp=' . $id;
            $res['menu']['* Заявки'] = '/?r=roster/complist&comp=' . $id;
        }
        return $res;
    }


    function competition_index($dbConnect, $CONSTPath) {
        $result = array();
        $filter = '';
        $params = array();
        if ($_GET['federation']) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/federation.php');
            $result['navigation'] = federation_navig($dbConnect);
            if ($_GET['federation'] != 11) {
                $filter .= ' AND competition.federation = :federation';
                $params['federation'] = $_GET['federation'];
            }
        }
        $dataset = common_getlist($dbConnect, '
            SELECT
              competition.link, competition.id, competition.name, S.yearB, S.yearE, competition.type, M.id AS mtch, F.id AS fid, F.name AS fname
            FROM
              competition LEFT JOIN season AS S ON S.id = competition.season
              LEFT JOIN `match` M ON type = 1 AND M.competition = competition.id
              LEFT JOIN federation F ON competition.federation = F.id
            WHERE
               TRUE'.$filter.'
            ORDER BY S.yearB DESC, competition.federation DESC, competition.name', $params);
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
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, M.city, M.timeh, M.timem, date,
              T1.rus_name AS t1name, T1.rus_abbr AS t1abbr,
              T2.rus_name AS t2name, T2.rus_abbr AS t2abbr
            FROM
              `match` M
            LEFT JOIN team T1 ON T1.id = M.team1
            LEFT JOIN team T2 ON T2.id = M.team2
            WHERE M.competition = :comp AND date <= :date
            ORDER BY M.date DESC, M.timeh DESC, M.timem DESC, M.id DESC
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
                  M.id, M.competition, M.team1, M.team2, M.score1, M.score2, M.city, M.timeh, M.timem, date,
                  T1.rus_name AS t1name, T1.rus_abbr AS t1abbr,
                  T2.rus_name AS t2name, T2.rus_abbr AS t2abbr
                FROM
                  `match` M
                LEFT JOIN team T1 ON T1.id = M.team1
                LEFT JOIN team T2 ON T2.id = M.team2
                WHERE M.competition = :comp
                ORDER BY M.date ASC, M.timeh ASC, M.timem ASC, M.id ASC
                LIMIT 5
            ) MM
            ORDER BY date DESC, timeh DESC, timem DESC, id DESC
          ';

            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'comp' => $_GET['comp']
            ));
            $dataset = $queryresult->fetchAll();
        }


        $result['answer']['results'] = $dataset;

        $compRec = common_getrecord($dbConnect, 'SELECT sport FROM competition WHERE id = :comp', array('comp' => $_GET['comp']));

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/action.php');
        $top10 = action_top10($dbConnect, $CONSTPath);
        $result['answer']['top10'] = $top10['answer'];

        if ($compRec['sport'] == 1) {
            $top10kick = action_top10kickers($dbConnect, $CONSTPath);
            $result['answer']['top10kick'] = $top10kick['answer'];
        }

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
                  C.name, S.yearB, S.yearE, C.reqdate
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

    function competition_add($dbConnect, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/team.php');
        $team = team_index($dbConnect, $CONSTPath);
        return array(
            'answer' => array(
                'team' => $team['answer']
            )
        );
    }

    function competition_create($dbConnect, $CONSTPath) {
        $arr = explode('.', $_POST['date']);
        $date = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        $year = $arr[2];
        $season = common_getrecord($dbConnect, 'SELECT id FROM season WHERE yearB = :year', array('year' => $year));
        if ($season) {
            $seasonId = $season['id'];
        }
        else {
            $seasonId = 1;
        }

        common_query($dbConnect,
            'INSERT INTO competition
             (name, sport, age, season, federation, type)
             VALUES ("Товарищеский матч", 1, 21, :season, 11, 1)'
            , array(
                'season' => $seasonId
            )
        );
        $comp = $dbConnect->lastInsertId('id');
        $_SESSION['userComp'][$comp] = 1;
        common_query($dbConnect,
            'INSERT INTO `match` (team1, team2, `date`, competition)
            VALUES (:team1, :team2, :date, :comp)'
            , array(
                'team1' => $_POST['team1'],
                'team2' => $_POST['team2'],
                'date' => $date,
                'comp' => $comp

            )
        );
        $match = $dbConnect->lastInsertId('id');
        common_query($dbConnect,
            'INSERT INTO `usercomp` (person, competition)
            VALUES (:person, :competition)'
            , array(
                'person' => $_SESSION['userPerson'],
                'competition' => $comp

            )
        );
        return array(
            'page' => '/?r=friendlymatch'
        );
    }