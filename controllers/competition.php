<?php
    //OK
    function competition_NAVIG($dbConnect, $id) {
        $queryresult = $dbConnect->prepare('
                SELECT
                  C.id, C.name AS name, S.yearB AS yearB, S.yearE AS yearE, logo, theme, stats_type
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
        if ($data[0]['stats_type'] == 3) {
            $res['menu']['Статистика'] = '/?r=stats/compAF&comp=' . $id;
        }
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            $res['menu']['* Управление'] = '/?r=competition/admin&comp=' . $id;
        }
        return $res;
    }


    function competition_index($dbConnect, $CONSTPath) {
        $result = array();
        $filter = ' AND competition.id != 77';
        $params = array();
        if ($_GET['federation']) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
            $result['navigation'] = start_NAVIG();
            $result['navigation']['pageId'] = 36;

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
            ORDER BY S.yearB DESC, F.type, competition.federation DESC, competition.name', $params);
        $result['answer'] = $dataset;
        return $result;
    }


    function competition_view ($dbConnect, $CONSTPath)
    {
        $result = array(
            'answer' => array()
        );

        $result['answer']['results'] = competition_actualMatches($dbConnect);

        $compRec = common_getrecord($dbConnect, 'SELECT sport, stats_type FROM competition WHERE id = :comp', array('comp' => $_GET['comp']));

        $fromCache = true;
        if (function_exists('memcache_connect')) {
            $mc = memcache_connect('localhost', 11211);
            $stats = memcache_get($mc, 'stats_top_' . $_GET['comp']);
        }
        else {
            $stats = array();
        }

        if (!$stats || !count($stats)) {
            $fromCache = false;
            if ($compRec['stats_type'] == 1) {
                $stats['top10'] = array();
            }
            if ($compRec['stats_type'] == 2) {
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/action.php');
                $top10 = action_top10($dbConnect, $CONSTPath);
                $stats['top10'] = $top10['answer'];
            }
            if ($compRec['stats_type'] == 3) {
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/statsAF.php');
                $top10 = statsAF_top10Point($dbConnect, $CONSTPath, $_GET['comp']);
                $stats['top10'] = $top10;
            }
            if ($compRec['sport'] == 1) {
                if ($compRec['stats_type'] == 1) {
                    $stats['top10kick'] = array();
                }
                if ($compRec['stats_type'] == 2) {
                    $top10kick = action_top10kickers($dbConnect, $CONSTPath);
                    $stats['top10kick'] = $top10kick['answer'];
                }
                if ($compRec['stats_type'] == 3) {
                    $top10 = statsAF_top10PointFG($dbConnect, $CONSTPath, $_GET['comp']);
                    $stats['top10kick'] = $top10;
                }

            }
        }

        $result['answer']['top10'] = $stats['top10'];
        $result['answer']['top10kick'] = $stats['top10kick'];
        if (function_exists('memcache_set') && !$fromCache) {
            memcache_set($mc, 'stats_top_'.$_GET['comp'], $stats, 0, 300);
        }



        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/video.php');
        $result['answer']['trans'] = video_livetoday($dbConnect, $CONSTPath);

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

    function competition_admin($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            $result = array();
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
            $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
            $result['answer'] = common_getlist($dbConnect, 'SELECT id, name FROM `group` WHERE competition = :comp', array('comp' => $_GET['comp']));
            return $result;
        }
        else {
            return 'ERROR-403';
        }
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

    function competition_lafNavig () {
        $navig_arr = array(
            'code' => 'laf',
            'theme' => 'laf',
            'header' => 'Лига Американского Футбола',
            'subheader' => 'Открытый чемпионат России',
            'title' => 'Открытый Чемпионат России по Американскому Футболу',
            'description' => 'Открытый чемпионат России по Американскому футболу: Официальный сайт. Здесь вы можете найти свежие новости, информацию о командах и статистику',
            'keywords' => array('Лига Американского Футбола', 'ЛАФ', 'Чемпионат России по американскому футболу', 'Россия', 'Американский футбол')
        );
        return $navig_arr;
    }

    function competition_actualMatches ($dbConnect) {
        //точка перехода не текущий день, а за 5 дней до матча
        $today = $today = date("Y-m-d", time()+60*60*24*5);

        $query = '
            SELECT
              M.id, M.competition, M.team1, M.team2, M.score1, M.score2, M.city, M.timeh, M.timem, date,
              T1.rus_name AS t1name, T1.rus_abbr AS t1abbr,
              T2.rus_name AS t2name, T2.rus_abbr AS t2abbr,
              T1.logo AS t1logo,
              T2.logo AS t2logo
            FROM
              `match` M
            LEFT JOIN team T1 ON T1.id = M.team1
            LEFT JOIN team T2 ON T2.id = M.team2
            WHERE M.competition = :comp AND date <= :date
            ORDER BY M.date DESC, M.timeh DESC, M.timem DESC, M.id DESC
            LIMIT 5
        ';
        $dataset = common_getlist($dbConnect, $query, array(
            'comp' => $_GET['comp'],
            'date' => $today
        ));

        if (count($dataset) < 5) {
            $query = '
                SELECT * FROM (
                    SELECT
                      M.id, M.competition, M.team1, M.team2, M.score1, M.score2, M.city, M.timeh, M.timem, date,
                      T1.rus_name AS t1name, T1.rus_abbr AS t1abbr,
                      T2.rus_name AS t2name, T2.rus_abbr AS t2abbr,
                      T1.logo AS t1logo,
                      T2.logo AS t2logo
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
            $dataset = common_getlist($dbConnect, $query, array(
                'comp' => $_GET['comp']
            ));
        }
        return $dataset;
    }

    function competition_start ($dbConnect, $CONSTPath) {
        $result = array(
            'answer' => array()
        );

        $teamlist = competition_teamList($dbConnect, $CONSTPath, 1);
        $result['answer']['teamlist'] = $teamlist;

        $result['answer']['results'] = competition_actualMatches($dbConnect);

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/stats.php');
        $statsComp = stats_compAF($dbConnect, $CONSTPath, 1);
        $result['answer']['stats'] = $statsComp['answer'];


        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/news.php');
        $newsPage = news_index($dbConnect, $CONSTPath, 4, true);
        $result['answer']['news'] = $newsPage['answer'];

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/video.php');
        $result['answer']['livevideo'] = video_livetoday($dbConnect, $CONSTPath);
        $result['answer']['videofeed'] = video_main($dbConnect, $CONSTPath);

        $result['navigation'] = competition_lafNavig();
        return $result;
    }

    function competition_about ($dbConnect, $CONSTPath) {
        $result = array();

        $org_rec = common_getrecord($dbConnect, '
            SELECT
                organization
            FROM
                competition
            WHERE
                  id = :comp
        ', array('comp' => $_GET['comp']));

        $org_id = $org_rec['organization'];

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/organization.php');
        $result['org'] = organization_info($dbConnect, $org_id);

        $navigation = competition_lafNavig();
        $navigation['pageId'] = 46;
        return array (
            'navigation' => $navigation,
            'answer' => $result
        );
    }


    function competition_staff ($dbConnect, $CONSTPath) {
        $result = array();

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/usercomp.php');
        $result['usercomp'] = usercomp_list($dbConnect, $CONSTPath, $_GET['comp']);

        $navigation = competition_lafNavig();
        $navigation['pageId'] = 55;
        return array (
            'navigation' => $navigation,
            'answer' => $result
        );
    }

    function competition_contacts ($dbConnect, $CONSTPath) {
        $about = competition_about($dbConnect, $CONSTPath);
        $about['navigation']['pageId'] = 56;
        return $about;
    }

    function competition_teamList($dbConnect, $confirm=1) {
        $confQuery = '';
        if ($confirm) {
            $confQuery = ' AND C.confirm = 1 ';
        }
        $query = '
            SELECT
                T.id,
                T.rus_name,
                T.city,
                T.city_adj,
                T.logo,
                C.group,
                G.name AS groupname,
                C.id AS ctid,
                C.confirm,
                (
                    SELECT CONCAT(P.surname, \' \', P.name)
                    FROM rosterface RF
                    LEFT JOIN person P ON P.id = RF.person
                    WHERE RF.team = T.id AND RF.competition = :competition AND facetype = 5
                    LIMIT 1
                ) AS cfio
            FROM
                compteam C
                LEFT JOIN team T ON T.id = C.team
                LEFT JOIN `group` G ON G.id = C.group
            WHERE
                C.competition = :competition'. $confQuery .'
            ORDER BY
                C.group, T.rus_name
        ';
        $params = array(
            'competition' => $_GET['comp']
        );
        return common_getlist($dbConnect, $query, $params);
    }

    function competition_team ($dbConnect, $CONSTPath) {
        $navigation = competition_lafNavig();
        $navigation['pageId'] = 47;
        return array (
            'navigation' => $navigation,
            'answer' => competition_teamList($dbConnect, $confirm=1)
        );
    }

    function competition_referee ($dbConnect, $CONSTPath) {
        $result = array(
            'answer' => array()
        );
        $navigation = competition_lafNavig();
        $navigation['pageId'] = 48;
        $result['navigation'] = $navigation;

        if ($_GET['comp']) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/refereecomp.php');
            $result['answer']['referee'] = refereecomp_list($dbConnect, $_GET['comp']);

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/referee.php');
            $result['answer']['all'] = referee_list($dbConnect, $CONSTPath);
        }
        return $result;
    }

    function competition_news ($dbConnect, $CONSTPath) {
        $result = array(
            'answer' => array()
        );
        $navigation = competition_lafNavig();
        $navigation['pageId'] = 51;
        $result['navigation'] = $navigation;

        if ($_GET['comp']) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/news.php');

            $newsPage = news_index($dbConnect, $CONSTPath);
            $result['answer']['news'] = $newsPage['answer'];
        }
        return $result;
    }

    function competition_stats ($dbConnect, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/stats.php');
        $stats_old = stats_compAF($dbConnect, $CONSTPath);

        $navigation = competition_lafNavig();
        $navigation['pageId'] = 45;
        $stats_old['navigation'] = $navigation;

        return $stats_old;
    }

    function competition_video ($dbConnect, $CONSTPath) {
        $result = array(
            'answer' => array()
        );
        $navigation = competition_lafNavig();
        $navigation['pageId'] = 52;
        $result['navigation'] = $navigation;

        if ($_GET['comp']) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/video.php');

            $result['answer']['video'] = video_list($dbConnect, $_GET['cat']);
        }

        return $result;
    }