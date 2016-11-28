<?php
    function team_navig($dbConnect, $id, $withRoster = false) {
    	$compFilter = '';
    	if ($_GET['comp']) {
    		$compFilter = '&comp='.$_GET['comp'];
    	}
        $queryresult = $dbConnect->prepare('
                SELECT
                  C.name, C.rus_name, C.theme, C.city, C.logo
                FROM
                  team AS C
                WHERE
                  C.id = :id
                LIMIT 1');
        $queryresult->execute(array(
            'id' => $id
        ));
        $data = $queryresult->fetchAll();
        $navig = array(
            'header' => $data[0]['rus_name'],
            'theme' => $data[0]['theme'],
            'menu' => array(
                'О команде' => '/?r=team/view&team='.$id.$compFilter,
                'Новости' => '/?r=news&team='.$id.$compFilter
            ),
            'title' => $data[0]['rus_name'] . ' ' . $data[0]['city'] . ' клуб американского футбола',
            'description' => 'Сайт ' . $data[0]['rus_name'] . ' клуб американского футбола. Здесь вы можете найти свежие новости, информацию о матчах, статистику',
            'keywords' => array($data[0]['rus_name'] . ' ' . $data[0]['city'] , $data[0]['rus_name'], $data[0]['name']),
            'logo' => $data[0]['logo']
        );
        if (!$withRoster) {
            $comps = team_comps($dbConnect, $id);
            if (count($comps)) {
                $withRoster = true;
            }
        }
        if ($withRoster) {
		    $navig['menu']['Состав'] = '/?r=roster&team='.$id.$compFilter;
            if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']])) {
                $navig['menu']['Заявки'] = '/?r=team/request&team='.$id.$compFilter;
            }
        }
        return $navig;
    }
    function team_complist($dbConnect, $CONSTPath) {
        $result = array();
        $query = '
            SELECT
            T.id, T.rus_name, T.city, T.logo, C.group, G.name AS groupname, C.id AS ctid
            FROM compteam C LEFT JOIN team T ON T.id = C.team LEFT JOIN `group` G ON G.id = C.group
            WHERE C.competition = :competition
            ORDER BY C.group, T.rus_name
        ';
        $params = array(
            'competition' => $_GET['comp']
        );
        $result['answer'] = common_getlist($dbConnect, $query, $params);
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
        $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
        return $result;
    }
    function team_index($dbConnect, $CONSTPath) {

        $result = array();
        if ($_GET['federation']) {
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/federation.php');
            $result['navigation'] = federation_navig($dbConnect, $_GET['federation']);
        }
        $query = '
          SELECT
            team.id, team.name, rus_name, city, age.id AS age_id, age.name as age
          FROM
            team LEFT JOIN age ON age.id = team.age
          ORDER BY
            rus_name';
        $params = array();

        $result['answer'] = common_getlist($dbConnect, $query, $params);

        return $result;
    }

    function team_info($dbConnect, $CONSTPath) {
        $result['answer'] = array();
        $queryresult = $dbConnect->prepare('
        SELECT
          team.id, S.name as sport, team.city, logo, vect_logo, team.name, rus_name, abbr, rus_abbr, team.geo_region, team.geo_country, GC.name AS geo_countryTitle,GR.name AS geo_regionTitle, team.email, team.vk_link, team.inst_link, team.twitter_link, ogrn_doc, sex, A.name AS age, O.name AS org_form
        FROM
          team LEFT JOIN sport AS S ON S.id = team.sport
          LEFT JOIN age AS A ON A.id = team.age
          LEFT JOIN org_form AS O ON O.id = team.org_form
          LEFT JOIN geo_country AS GC ON GC.id = team.geo_country
          LEFT JOIN geo_region AS GR ON GR.id = team.geo_region
        WHERE
          team.id = :id
        LIMIT 1');
        $queryresult->execute(array(
            'id' => $_GET['team']
        ));
        $data = $queryresult->fetchAll();
        if (count($data)) {
            $result['answer']['team'] = $data[0];
        }
        $result['navigation'] = team_navig($dbConnect, $_GET['team']);

        return $result;
    }

    function team_view($dbConnect, $CONSTPath) {
        $result = team_info($dbConnect, $CONSTPath);
        $comps = team_comps($dbConnect, $_GET['team']);
        if ($_GET['comp']) {
            $compId = $_GET['comp'];
        }
        else {
            $compId = $comps[0]['id'];
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/match.php');

        $match = match_index($dbConnect, $CONSTPath, $_GET['team'], $compId);
        $result['answer']['match'] = $match['answer'];
        $result['answer']['comps'] = $comps;
        $result['answer']['compId'] = $compId;
        return $result;
    }
    function team_edit($dbConnect, $ConstPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']])) {
            $teamView = team_info($dbConnect, $ConstPath);
            return array(
                'answer' => array(
                    'team' => $teamView['answer']
                ),
                'navigation' => $teamView['navigation']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function team_comps($dbConnect, $team) {
        if (!$team) {
            $team = $_GET['team'];
        }
        $queryresult = $dbConnect->prepare('
                SELECT
                  C.id, C.name, S.yearB, C.link
                FROM
                  compteam CT LEFT JOIN competition C ON C.id = CT.competition
                  LEFT JOIN season S ON S.id = C.season
                WHERE
                  CT.team = :id
                ORDER BY C.id DESC');
        $queryresult->execute(array(
            'id' => $team
        ));
        return $queryresult->fetchAll();
    }

    function team_news ($dbConnect) {
        if (isset($_SESSION['userID'])) {
            $queryresult = $dbConnect->prepare('
                SELECT
                  new.id, M.title, M.content, M.date, material
                FROM
                  new LEFT JOIN material AS M ON M.id = new.material
                WHERE team = :id
                  ORDER BY date DESC');
            $queryresult->execute(array(
                'id' => $_GET['id']
            ));
            $result['answer'] = $queryresult->fetchAll();
            $result['navigation'] = team_navig($dbConnect, $_GET['team']);
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function team_update($dbConnect, $CONSTPath) {
        $id = $_POST['team'];
        if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$id])) {
            $queryresult = $dbConnect->prepare('
              SELECT
                logo
              FROM
                team AS P
              WHERE id = :id');
            $queryresult->execute(array(
                'id' => $id
            ));
            $data = $queryresult->fetchAll();
            if (count($data)) {
                $oldLogo = $data[0]['logo'];
            }

            $logo = common_loadFile('logo', $CONSTPath);
            if ($logo) {
                if ($oldLogo) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/upload/' . $oldLogo);
                }
            }
            else {
                $logo = $oldLogo;
            }

            $queryresult = $dbConnect->prepare('
            UPDATE
              team
            SET
              rus_name = :rus_name,
              rus_abbr = :rus_abbr,
              logo = :logo,
              geo_country = :geo_country,
              geo_region = :geo_region,
              city = :city,
              email = :email,
              vk_link = :vk_link,
              inst_link = :inst_link,
              twitter_link = :twitter_link
            WHERE
              id = :id');

            $queryresult->execute(array(
                'id' => $id,
                'rus_name' => $_POST['rus_name'],
                'rus_abbr' => $_POST['rus_abbr'],
                'geo_country' => $_POST['geo_country'],
                'geo_region' => $_POST['geo_region'],
                'city' => $_POST['city'],
                'email' => $_POST['email'],
                'vk_link' => $_POST['vk_link'],
                'inst_link' => $_POST['inst_link'],
                'twitter_link' => $_POST['twitter_link'],
                'logo' => $logo
            ));
            $_SESSION['message'] = 'Данные команды изменены';
            return array(
                'page' => '/?r=team/view&team=' . $id
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function team_request($dbConnect) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']])) {
            $result['answer'] = array();

            $comps = team_comps($dbConnect, $_GET['team']);
            $result['answer']['comps'] = $comps;

            $result['navigation'] = team_navig($dbConnect, $_GET['team']);

            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }