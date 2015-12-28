<?php
function roster_list($dbConnect, $CONSTPath, $order = '', $team = NULL, $comp = NULL, $confirm = null) {
    if (!$team) {
        $team = $_GET['team'];
    }
    if (!$comp) {
        $comp = $_GET['comp'];
    }
    $confirmFilter = '';
    if ($confirm) {
        $confirmFilter = ' AND confirm = 1';
    }
    return common_getlist($dbConnect, '
                SELECT
                  R.id, P.id as person, P.surname, P.name, P.patronymic, P.birthdate, R.number, R.confirm, POS.abbr AS pos, P.growth, P.weight, P.phone, GC.id AS geo_country, GC.name AS geo_countryTitle, P.avatar
                FROM
                  roster AS R LEFT JOIN person AS P ON P.id = R.person
                  LEFT JOIN position POS ON POS.id = R.position LEFT JOIN geo_country GC ON GC.id = P.geo_country
                WHERE
                  team = :team AND competition = :comp ' . $confirmFilter . '
                ' . $order . '
                  ',
        array(
            'team' => $team,
            'comp' => $comp
    ));
}
function rosterface_list($dbConnect, $CONSTPath, $team = NULL, $comp = NULL) {
    if (!$team) {
        $team = $_GET['team'];
    }
    if (!$comp) {
        $comp = $_GET['comp'];
    }
    return common_getlist($dbConnect, '
                SELECT
                  R.id, P.id AS person, P.surname, P.name, P.patronymic, P.birthdate, F.name as facetype, P.phone, GC.id AS geo_country, GC.name AS geo_countryTitle
                FROM
                  rosterface AS R LEFT JOIN person AS P ON P.id = R.person
                  LEFT JOIN facetype F ON F.id = R.facetype LEFT JOIN geo_country GC ON GC.id = P.geo_country
                WHERE
                  team = :team AND competition = :comp
                ORDER BY facetype
                  ',
        array(
            'team' => $team,
            'comp' => $comp
        ));
}
function roster_index($dbConnect, $CONSTPath) {
    $roster = roster_list($dbConnect, $CONSTPath, ' ORDER BY surname, name ', $_GET['team'], $_GET['comp'], TRUE);
    $face = rosterface_list($dbConnect, $CONSTPath, $_GET['team'], $_GET['comp']);
    require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');

    return array(
        'navigation' => team_NAVIG($dbConnect, $_GET['team']),
        'answer' => array(
            'face' => $face,
            'roster' => $roster
        )
    );
}
function roster_bind($dbConnect, $roster) {
    $data = common_getrecord($dbConnect, '
                SELECT
                  R.team, R.competition
                FROM
                  roster AS R
                WHERE
                  R.id = :id',
        array(
            'id' => $roster
        ));

    return array(
        'team' => $data['team'],
        'comp' => $data['competition']
    );
}
function roster_fill($dbConnect, $CONSTPath) {
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']])) {
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/position.php');
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/facetype.php');
        $team = team_view($dbConnect);
        $position = position_index($dbConnect, $CONSTPath);
        $facetype = facetype_index($dbConnect, $CONSTPath);
        $roster = roster_list($dbConnect, $CONSTPath, ' ORDER BY surname, name ', $_GET['team'], $_GET['comp']);
        $face = rosterface_list($dbConnect, $CONSTPath, $_GET['team'], $_GET['comp']);


        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
        $compInfo = competition_info ($dbConnect, $CONSTPath, $_GET['comp']);
        $compsPast = team_comps($dbConnect, $_GET['team']);

        return array(
            'navigation' => array(
                'menu' => array(),
                'header' => 'Заявка на '.$compInfo['name']. ' ' . $compInfo['yearB']
            ),
            'answer' => array(
                'team' => $team['answer']['team']['name'],
                'teamCity' => $team['answer']['team']['city'],
                'teamRec' => $team['answer']['team'],
                'position' => $position['answer'],
                'face' => $face,
                'facetype' => $facetype['answer'],
                'roster' => $roster,
                'compinfo' => $compInfo,
                'compsPast' => $compsPast
            )
        );
    }
    else {
        return 'ERROR-403';
    }
}
function roster_print($dbConnect, $CONSTPath) {
    return roster_fill($dbConnect, $CONSTPath);
}
function roster_printCards($dbConnect, $CONSTPath) {
    return roster_fill($dbConnect, $CONSTPath);
}
function roster_request($dbConnect, $CONSTPath) {
    $team = $_GET['team'];
    $comp = $_GET['comp'];
    if ($_SESSION['userTeams'][$team]) {
        common_sendmail('afc.rebels.yar@gmail.com', 'Заявка на Чемпионат России 2015', 'Команда оставила заявку на Чемпионат Росиии 2015. Пройдите по ссылке, чтобы подтвердить заявку <a href="http://amfoot.net/?r=roster/fill&team='. $team . '&comp=' . $comp .'">http://amfoot.net/?r=roster/fill&team='. $team . '&comp=' . $comp .'</a>');
        $_SESSION['message'] = 'Заявка успешно создана';
    }
    else {
        $_SESSION['error'] = 'Ошибка создания заявки';
    }
    return array(
        'page' => '/?r=team/view&team='.$team
    );
}
function roster_confirm($dbConnect, $CONSTPath) {
    if ($_SESSION['userType'] == 3) {
        $queryresult = $dbConnect->prepare('
                SELECT
                  R.id, R.team, R.competition, R.confirm
                FROM
                  roster AS R
                WHERE
                  R.id = :id');
        $queryresult->execute(array(
            'id' => $_POST['roster']
        ));
        $data = $queryresult->fetchAll();
        if (count($data)) {
            $oldConfirm = $data[0]['confirm'];
            $confirm = 1 - $oldConfirm;

            $roster = $_POST['roster'];
            $queryresult = $dbConnect->prepare('
                UPDATE
                  roster
                SET confirm = :confirm WHERE id = :id');
            $queryresult->execute(array(
                'id' => $roster,
                'confirm' => $confirm
            ));
            return $confirm;

        }

    }
};
function roster_createFace($dbConnect, $CONSTPath) {
    $team = $_POST['team'];
    $comp = $_POST['comp'];
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team])) {
        $person = null;
        $geo_country = $_POST['geo_country'];
        $geo_countryTitle = $_POST['geo_countryTitle'];
        if (!$_POST['person']) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
            $pIns = person_insert($dbConnect, $CONSTPath, array(
                'surname' => $_POST['surname'],
                'name' => $_POST['name'],
                'patronymic' => $_POST['patronymic'],
                'birthdate' => $_POST['birthdate'],
                'phone' => $_POST['phone'],
                'email' => '',
                'vk_link' => '',
                'skype' => '',
                'geo_country' => $_POST['geo_country'],
                'geo_countryTitle' => $_POST['geo_countryTitle'],
                'city' => '',
                'region' => null,
                'avatar' => common_loadFile('avatar', $CONSTPath),
                'weight' => $_POST['weight'],
                'growth' => $_POST['growth']
            ));
            if ($pIns['success']) {
                $person = $pIns['success'];
            }
            if ($pIns['error']) {
                $_SESSION['error'] = $pIns['error'];
            }
        }
        else {
            $person = $_POST['person'];

            $queryresult = $dbConnect->prepare('
              SELECT
                avatar
              FROM
                person AS P
              WHERE id = :id');
            $queryresult->execute(array(
                'id' => $person
            ));
            $data = $queryresult->fetchAll();
            if (count($data)) {
                $oldAvatar = $data[0]['avatar'];
            }

            $avatar = common_loadFile('avatar', $CONSTPath);
            if ($avatar) {
                if ($oldAvatar) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/upload/' . $oldAvatar);
                }
            }
            else {
                $avatar = $oldAvatar;
            }
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/geolocation.php');
            $queryresult = $dbConnect->prepare('
                UPDATE
                  person
                SET
                  geo_country = :geo_country, avatar = :avatar
                WHERE id = :person
                  ');
            $queryresult->execute(array(
                'geo_country' => $geo_country,
                'person'=> $person,
                'avatar' => $avatar
            ));
        }
        if ($person) {
            $facetype = $_POST['facetype'];

            $queryresult = $dbConnect->prepare('
                INSERT INTO
                  rosterface
                  (team, facetype, person, competition)
                VALUES
                  (:team, :facetype, :person, :competition)');
            $queryresult->execute(array(
                'team' => $team,
                'facetype' => $facetype,
                'person' => $person,
                'competition' => $comp
            ));
        }


    }
    else {
        $_SESSION['error'] = 'Произошла ошибка добавления игрока';
    }
    return array(
        'page' => '/?r=roster/fill&team='.$team.'&comp='.$comp
    );
}
function roster_create($dbConnect, $CONSTPath) {
    $team = $_POST['team'];
    $comp = $_POST['comp'];
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team])) {
        $person = null;
        $growth = $_POST['growth'];
        $weight = $_POST['weight'];
        $geo_country = $_POST['geo_country'];
        $geo_countryTitle = $_POST['geo_countryTitle'];
        if (!$_POST['person']) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
            $pIns = person_insert($dbConnect, $CONSTPath, array(
                'surname' => $_POST['surname'],
                'name' => $_POST['name'],
                'patronymic' => $_POST['patronymic'],
                'birthdate' => $_POST['birthdate'],
                'phone' => $_POST['phone'],
                'email' => '',
                'vk_link' => '',
                'skype' => '',
                'geo_country' => $_POST['geo_country'],
                'geo_countryTitle' => $_POST['geo_countryTitle'],
                'city' => '',
                'region' => null,
                'avatar' => common_loadFile('avatar', $CONSTPath),
                'weight' => $_POST['weight'],
                'growth' => $_POST['growth']
            ));
            if ($pIns['success']) {
                $person = $pIns['success'];
            }
            if ($pIns['error']) {
                $_SESSION['error'] = $pIns['error'];
            }
        }
        else {
            $person = $_POST['person'];

            $queryresult = $dbConnect->prepare('
              SELECT
                avatar
              FROM
                person AS P
              WHERE id = :id');
            $queryresult->execute(array(
                'id' => $person
            ));
            $data = $queryresult->fetchAll();
            if (count($data)) {
                $oldAvatar = $data[0]['avatar'];
            }

            $avatar = common_loadFile('avatar', $CONSTPath);
            if ($avatar) {
                if ($oldAvatar) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/upload/' . $oldAvatar);
                }
            }
            else {
                $avatar = $oldAvatar;
            }
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/geolocation.php');
            $queryresult = $dbConnect->prepare('
                UPDATE
                  person
                SET
                  growth = :growth, weight = :weight, geo_country = :geo_country, avatar = :avatar, phone = :phone
                WHERE id = :person
                  ');
            $queryresult->execute(array(
                'growth' => $growth,
                'weight' => $weight,
                'geo_country' => $geo_country,
                'person'=> $person,
                'avatar' => $avatar,
                'phone' => $_POST['phone']
            ));
        }
        if ($person) {
            $position = $_POST['pos'];
            $number = $_POST['number'];

            $queryresult = $dbConnect->prepare('
                INSERT INTO
                  roster
                  (team, position, person, competition, number)
                VALUES
                  (:team, :position, :person, :competition, :number)');
            $queryresult->execute(array(
                'team' => $team,
                'position' => $position,
                'person' => $person,
                'competition' => $comp,
                'number' => $number
            ));
        }


    }
    else {
        $_SESSION['error'] = 'Произошла ошибка добавления игрока';
    }
    return array(
        'page' => '/?r=roster/fill&team='.$team.'&comp='.$comp
    );
};
function roster_delete($dbConnect, $CONSTPath) {
    $queryresult = $dbConnect->prepare('
                SELECT
                  R.id, R.team, R.competition, R.confirm
                FROM
                  roster AS R
                WHERE
                  R.id = :id');
    $queryresult->execute(array(
        'id' => $_GET['roster']
    ));
    $data = $queryresult->fetchAll();
    if (count($data) && $data[0]['confirm'] == 0) {
        $team = $data[0]['team'];
        $comp = $data[0]['competition'];
        if ((($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team]))) {
            $queryresult = $dbConnect->prepare('
                DELETE

                FROM
                  roster
                WHERE
                  id = :id');
            $queryresult->execute(array(
                'id' => $_GET['roster']
            ));
            return array(
                'page' => '/?r=roster/fill&team='.$team.'&comp='.$comp
            );
        }
        else {
            $_SESSION['error'] = 'Произошла ошибка удаления игрока';
        }
    }
    else {
        $_SESSION['error'] = 'Произошла ошибка удаления игрока';
    }
    return array(
        'page' => '/index.php'
    );
}
function roster_deleteFace($dbConnect, $CONSTPath) {
    $queryresult = $dbConnect->prepare('
                SELECT
                  R.team, R.competition
                FROM
                  rosterface AS R
                WHERE
                  R.id = :id');
    $queryresult->execute(array(
        'id' => $_GET['face']
    ));
    $data = $queryresult->fetchAll();
    if (count($data)) {
        $team = $data[0]['team'];
        $comp = $data[0]['competition'];
        if ((($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team]))) {
            $queryresult = $dbConnect->prepare('
                DELETE

                FROM
                  rosterface
                WHERE
                  id = :id');
            $queryresult->execute(array(
                'id' => $_GET['face']
            ));
            return array(
                'page' => '/?r=roster/fill&team='.$team.'&comp='.$comp
            );
        }
        else {
            $_SESSION['error'] = 'Произошла ошибка удаления официального лица';
        }
    }
    else {
        $_SESSION['error'] = 'Произошла ошибка удаления официального лица';
    }
    return array(
        'page' => '/index.php'
    );
}

function roster_edit ($dbConnect, $CONSTPath) {
    $bind = roster_bind($dbConnect, $_GET['roster']);
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$bind['team']])) {
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/position.php');
        $position = position_index($dbConnect, $CONSTPath);
        $queryresult = $dbConnect->prepare('
            SELECT
              P.surname, P.name, P.patronymic, P.birthdate, R.number, R.position, P.growth, P.weight, P.phone, GC.id AS geo_country, GC.name AS geo_countryTitle, P.avatar, P.id AS personid
            FROM
              roster AS R LEFT JOIN person AS P ON P.id = R.person LEFT JOIN geo_country GC ON GC.id = P.geo_country
            WHERE
              R.id = :id
        ');
        $queryresult->execute(array(
            'id' => $_GET['roster']
        ));
        $data = $queryresult->fetchAll();
        return array(
            'navigation' => array(
                'menu' => array()
            ),
            'answer' => array(
                'position' => $position['answer'],
                'roster' => $data[0],
                'bind' => $bind
            )
        );
    }
    else {
        return 'ERROR-403';
    }
}
function roster_update ($dbConnect, $CONSTPath) {
    $roster = $_POST['roster'];
    $person = $_POST['person'];
    $bind = roster_bind($dbConnect, $roster);
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$bind['team']])) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/common.php');
        $queryresult = $dbConnect->prepare('
              SELECT
                avatar
              FROM
                person AS P
              WHERE id = :id');
        $queryresult->execute(array(
            'id' => $person
        ));
        $data = $queryresult->fetchAll();
        if (count($data)) {
            $oldAvatar = $data[0]['avatar'];
        }

        $avatar = common_loadFile('avatar', $CONSTPath);
        if ($avatar) {
            if ($oldAvatar) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/upload/' . $oldAvatar);
            }
        }
        else {
            $avatar = $oldAvatar;
        }
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/geolocation.php');
        $queryresult = $dbConnect->prepare('
                UPDATE
                  person
                SET
                  growth = :growth, weight = :weight, geo_country = :geo_country, avatar = :avatar, phone = :phone
                WHERE id = :person
                  ');
        $queryresult->execute(array(
            'growth' => $_POST['growth'],
            'weight' => $_POST['weight'],
            'geo_country' => $_POST['geo_country'],
            'person'=> $person,
            'avatar' => $avatar,
            'phone' => $_POST['phone']
        ));
        $queryresult = $dbConnect->prepare('
                UPDATE
                  roster
                SET
                  position = :position, number = :number
                WHERE id = :roster
                  ');
        $queryresult->execute(array(
            'position' => $_POST['pos'],
            'number' => $_POST['number'],
            'roster'=> $roster
        ));
        return array(
            'page' => '/?r=roster/fill&team='.$bind['team'].'&comp='.$bind['comp']
        );
    }
    else {
        return 'ERROR-403';
    }
}

function roster_autofill($dbConnect, $CONSTPath) {
    $team = $_POST['team'];
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team])) {
        $comp = $_POST['comp'];
        $compRet = $_POST['compRet'];
        $query = 'INSERT INTO roster (competition, team, position, person, number)
        SELECT :compRet, :team, position, person, number FROM roster WHERE team = :team and competition = :comp';
        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute(array(
            'team' => $team,
            'comp' => $comp,
            'compRet'=>$compRet
        ));

        $query = 'INSERT INTO rosterface (competition, team, person, facetype)
        SELECT :compRet, :team, person, facetype FROM rosterface WHERE team = :team and competition = :comp';
        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute(array(
            'team' => $team,
            'comp' => $comp,
            'compRet'=>$compRet
        ));


        return (array(
            'page' => '/?r=roster/fill&comp='.$compRet.'&team='.$team
        ));
    }
    else {
        return 'ERROR-403';
    }
}