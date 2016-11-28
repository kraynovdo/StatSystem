<?php
function roster_list($dbConnect, $CONSTPath, $order = '', $team = NULL, $comp = NULL, $confirm = null, $ids = '') {
    if (!$team) {
        $team = $_GET['team'];
    }
    if (!$comp) {
        $comp = $_GET['comp'];
    }

    $params = array(
        'team' => $team,
        'comp' => $comp
    );

    $confirmFilter = '';
    if ($confirm) {
        $confirmFilter = ' AND confirm = 1';
    }
    $idsFilter = '';
    if ($ids && preg_match ("/^[,0-9]+$/i", $ids)) {
        $idsFilter = ' AND R.id IN ('.$ids.')';
    }

    return common_getlist($dbConnect, '
                SELECT
                  R.id, P.id as person, P.surname, P.name, P.patronymic, P.birthdate, R.number, R.confirm, POS.abbr AS pos, P.growth, P.weight, P.phone, GC.id AS geo_country, GC.name AS geo_countryTitle, P.avatar
                FROM
                  roster AS R LEFT JOIN person AS P ON P.id = R.person
                  LEFT JOIN position POS ON POS.id = R.position LEFT JOIN geo_country GC ON GC.id = P.geo_country
                WHERE
                  team = :team AND competition = :comp ' . $confirmFilter . $idsFilter . '
                ' . $order . '
                  ',
        $params);
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
                  R.id, P.id AS person, P.surname, P.name, P.patronymic, P.birthdate, F.name as facetype, P.phone, GC.id AS geo_country, GC.name AS geo_countryTitle, P.avatar
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
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
    $comps = team_comps($dbConnect, $_GET['team']);
    if ($_GET['comp']) {
        $compId = $_GET['comp'];
    }
    else {
        $compId = $comps[0]['id'];
    }

    $roster = roster_list($dbConnect, $CONSTPath, ' ORDER BY surname, name ', $_GET['team'], $compId, TRUE);
    $face = rosterface_list($dbConnect, $CONSTPath, $_GET['team'], $compId);
    $result = array(
        'answer' => array(
            'face' => $face,
            'roster' => $roster,
            'comps' => $comps,
            'compId' => $compId
        )
    );
    $result['navigation'] = team_NAVIG($dbConnect, $_GET['team'], count($comps));
    $result['navigation']['mobile_view'] = 1;

    return $result;
}
function roster_bind($dbConnect, $roster, $type='roster') {
    $res = array (
        'team' => '',
        'comp' => ''
    );
    switch ($type) {
        case 'roster': $tablename = 'roster'; break;
        case 'rosterface': $tablename = 'rosterface'; break;
        default: return $res;
    }
    $data = common_getrecord($dbConnect, '
                SELECT
                  R.team, R.competition
                FROM
                  ' .$tablename . ' AS R
                WHERE
                  R.id = :id',
        array(
            'id' => $roster
        ));
    $res['team'] = $data['team'];
    $res['comp'] = $data['competition'];
    return $res;
}
function roster_fill($dbConnect, $CONSTPath, $ids = null) {
    if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1) ||  ($_SESSION['userTeams'][$_GET['team']])) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/team.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/position.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/facetype.php');
        $team = team_info($dbConnect, $CONSTPath);
        $position = position_index($dbConnect, $CONSTPath);
        $facetype = facetype_index($dbConnect, $CONSTPath);
        $roster = roster_list($dbConnect, $CONSTPath, ' ORDER BY surname, name ', $_GET['team'], $_GET['comp'], null, $ids);
        $face = rosterface_list($dbConnect, $CONSTPath, $_GET['team'], $_GET['comp']);


        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
        $compInfo = competition_info ($dbConnect, $CONSTPath, $_GET['comp']);
        $compsPast = team_comps($dbConnect, $_GET['team']);

        return array(
            'navigation' => array(
                'menu' => array(),
                'header' => 'Заявка на '.$compInfo['name']. ' ' . $compInfo['yearB'],
                'mobile_view' => 1
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
    $ids = $_GET['ids'];
    return roster_fill($dbConnect, $CONSTPath, $ids);
}
function roster_printCards($dbConnect, $CONSTPath) {
    return roster_fill($dbConnect, $CONSTPath);
}
function roster_request($dbConnect, $CONSTPath) {
    $team = $_GET['team'];
    $comp = $_GET['comp'];
    if ($_SESSION['userTeams'][$team]) {
        common_sendmail('afc.rebels.yar@gmail.com', 'Заявка на Чемпионат России 2015', 'Команда оставила заявку на Чемпионат Росиии 2015. Пройдите по ссылке, чтобы подтвердить заявку <a href="http://amfoot.ru/?r=roster/fill&team='. $team . '&comp=' . $comp .'">http://amfoot.ru/?r=roster/fill&team='. $team . '&comp=' . $comp .'</a>');
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
    $bind = roster_bind($dbConnect, $_POST['roster']);
    if (($_SESSION['userType'] == 3) || (($_SESSION['userComp'][$bind['comp']] == 1))) {
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
    $person = roster_personCreateCommon($dbConnect, $CONSTPath);
    if ($person) {
        $facetype = $_POST['facetype'];

        $queryresult = $dbConnect->prepare('
            INSERT INTO
              rosterface
              (team, facetype, person, competition)
            VALUES
              (:team, :facetype, :person, :competition)');
        $queryresult->execute(array(
            'team' => $_POST['team'],
            'facetype' => $facetype,
            'person' => $person,
            'competition' => $_POST['comp']
        ));
    }

    else {
        $_SESSION['error'] = 'Произошла ошибка добавления лица';
    }
    return array(
        'page' => '/?r=roster/fill&team='.$_POST['team'].'&comp='.$_POST['comp']
    );
}

function roster_personCreateCommon($dbConnect, $CONSTPath) {
    $person = null;
    $team = $_POST['team'];
    $comp = $_POST['comp'];
    if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$comp] == 1) || ($_SESSION['userTeams'][$team])) {
        $person = null;
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/person.php');
        if (!$_POST['person']) {
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
        } else {
            $person = $_POST['person'];

            $avatar = person_getNewAvatar($dbConnect, $CONSTPath, $person, 'avatar');
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
                'person' => $person,
                'avatar' => $avatar,
                'phone' => $_POST['phone']
            ));
        }

    }
    return $person;

}

function roster_create($dbConnect, $CONSTPath) {
    $person = roster_personCreateCommon($dbConnect, $CONSTPath);
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
            'team' => $_POST['team'],
            'position' => $position,
            'person' => $person,
            'competition' => $_POST['comp'],
            'number' => $number
        ));
    }

    else {
        $_SESSION['error'] = 'Произошла ошибка добавления игрока';
    }
    return array(
        'page' => '/?r=roster/fill&team='.$_POST['team'].'&comp='.$_POST['comp']
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
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$comp] == 1) || ($_SESSION['userTeams'][$team])) {
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
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$comp] == 1) || ($_SESSION['userTeams'][$team])) {
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
    if (($_SESSION['userType'] == 3)  || ($_SESSION['userComp'][$bind['comp']] == 1) || ($_SESSION['userTeams'][$bind['team']])) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/position.php');
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
                'menu' => array(),
                'mobile_view' => 1
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
function roster_editFace ($dbConnect, $CONSTPath) {
    $bind = roster_bind($dbConnect, $_GET['face'], 'rosterface');
    if (($_SESSION['userType'] == 3)  || ($_SESSION['userComp'][$bind['comp']] == 1) || ($_SESSION['userTeams'][$bind['team']])) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/facetype.php');
        $facetype = facetype_index($dbConnect, $CONSTPath);
        $queryresult = $dbConnect->prepare('
            SELECT
              P.surname, P.name, P.patronymic, P.birthdate, R.facetype, P.phone, GC.id AS geo_country, GC.name AS geo_countryTitle, P.avatar, P.id AS personid
            FROM
              rosterface AS R LEFT JOIN person AS P ON P.id = R.person LEFT JOIN geo_country GC ON GC.id = P.geo_country
            WHERE
              R.id = :id
        ');
        $queryresult->execute(array(
            'id' => $_GET['face']
        ));
        $data = $queryresult->fetchAll();
        return array(
            'navigation' => array(
                'menu' => array(),
                'mobile_view' => 1
            ),
            'answer' => array(
                'facetype' => $facetype['answer'],
                'face' => $data[0],
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
    if (($_SESSION['userType'] == 3)  || ($_SESSION['userComp'][$bind['comp']] == 1) || ($_SESSION['userTeams'][$bind['team']])) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
        $avatar = person_getNewAvatar($dbConnect, $CONSTPath, $person, 'avatar');
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
function roster_updateFace ($dbConnect, $CONSTPath) {
    $face = $_POST['face'];
    $person = $_POST['person'];
    $bind = roster_bind($dbConnect, $_POST['face'], 'rosterface');
    if (($_SESSION['userType'] == 3)  || ($_SESSION['userComp'][$bind['comp']] == 1) || ($_SESSION['userTeams'][$bind['team']])) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
        $avatar = person_getNewAvatar($dbConnect, $CONSTPath, $person, 'avatar');
        $queryresult = $dbConnect->prepare('
                UPDATE
                  person
                SET
                  geo_country = :geo_country, avatar = :avatar, phone = :phone
                WHERE id = :person
                  ');
        $queryresult->execute(array(
            'geo_country' => $_POST['geo_country'],
            'person'=> $person,
            'avatar' => $avatar,
            'phone' => $_POST['phone']
        ));
        $queryresult = $dbConnect->prepare('
                UPDATE
                  rosterface
                SET
                  facetype = :facetype
                WHERE id = :face
                  ');
        $queryresult->execute(array(
            'facetype' => $_POST['facetype'],
            'face'=> $face
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
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$team])  || ($_SESSION['userComp'][$_POST['compRet']] == 1)) {
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

function roster_complist($dbConnect, $CONSTPath) {
	require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/team.php');
    $roster = team_complist($dbConnect, $CONSTPath);
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
    $result = array(
        'navigation' => competition_NAVIG($dbConnect, $_GET['comp']),
        'answer' => array(
            'roster' => $roster['answer']
        )
    );
    $result['navigation']['mobile_view'] = 1;
    return $result;
}
