<?
//OK
    function usercomp_list($dbConnect, $CONSTPath, $comp=null, $person=null) {
        $where = ' WHERE C.type IS NULL';
        $params = array();
        if (!$person) {
            $person = $_GET['person'];
        }
        if (!$comp) {
            $comp = $_GET['comp'];
        }
        if ($person) {
            $where .= ' AND person = :person';
            $params['person'] = $person;
        }
        if ($comp) {
            $where .= ' AND competition = :comp';
            $params['comp'] = $comp;
        }

        $dataset = common_getlist($dbConnect, '
            SELECT
                UR.id, C.name, C.id as comp, S.yearB, S.yearE, C.link, P.name AS pname, P.surname, P.patronymic, UR.work, P.phone, P.email, P.avatar
            FROM
                usercomp UR
                LEFT JOIN competition C ON C.id = UR.competition
                LEFT JOIN season S ON S.id = C.season
                LEFT JOIN person P ON P.id = UR.person'.
                $where. ' ORDER BY S.yearB DESC', $params);

        return $dataset;
    }

    function usercomp_add($dbConnect, $CONSTPath) {
        if ((($_SESSION['userType'] == 3)) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/admin.php');
            $result['navigation'] = admin_navig($dbConnect);
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function usercomp_create($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_POST['comp']] == 1)) {
            if ($_POST['d_id']) {
                $did = $_POST['d_id'];
                common_query($dbConnect, 'UPDATE person SET phone = :phone WHERE id = :id', array(
                    'id' => $did,
                    'phone' => $_POST['d_phone']
                ));
            } else {
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/person.php');
                $pIns = person_insert($dbConnect, $CONSTPath, array(
                    'surname' => $_POST['d_fio'],
                    'name' => $_POST['d_name'],
                    'patronymic' => $_POST['d_patr'],
                    'birthdate' => $_POST['d_date'],
                    'phone' => $_POST['d_phone'],
                    'email' => null,
                    'vk_link' => null,
                    'skype' => null,
                    'geo_country' => null,
                    'avatar' => common_loadFile('avatar', $CONSTPath),
                    'weight' => null,
                    'growth' => null
                ));
                if ($pIns['success']) {
                    $did = $pIns['success'];
                }
                if ($pIns['error']) {
                    $_SESSION['error'] = $pIns['error'];
                    return array(
                        'page' => '/?r=competition/about&comp='.$_POST['comp']
                    );
                }
            }

            $params = array(
                'person' => $did,
                'competition' => $_POST['comp'],
                'work' => trim($_POST['work']),
            );

            common_query($dbConnect,
                'INSERT INTO usercomp
                 (person, competition, type, work, `group`)
                 VALUES (:person, :competition, 1, :work, 1)'
                , $params
            );
            return array(
                'page' => '/?r='.$_POST['ret'].'&comp='.$_POST['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function usercomp_delete($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            common_query($dbConnect, '
                    DELETE FROM usercomp
                    WHERE id = :id',
                array(
                    'id' => $_GET['uc']
                )
            );
            return array(
                'page' => '/?r='.$_GET['ret'].'&comp='.$_GET['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }