<?php
    function userfederation_index($dbConnect, $CONSTPath, $federation = null, $person=null, $group=null) {
        $where = ' WHERE TRUE';
        $params = array();
        if (!$person) {
            $person = $_GET['person'];
        }
        if (!$federation) {
            $federation = $_GET['federation'];
        }

        if ($person) {
            $where .= ' AND person = :person';
            $params['person'] = $person;
        }
        if ($federation) {
            $where .= ' AND federation = :federation';
            $params['federation'] = $federation;
        }
        if ($group) {
            $where .= ' AND federationgroup = :group';
            $params['group'] = $group;
        }
        $result = array();
        $result['answer'] = common_getlist($dbConnect,
            'SELECT
                person, federation, P.avatar, P.name, P.surname, P.patronymic, P.phone, P.email, F.name AS fname, F.fullname, UF.type, UF.work, UF.id AS uf, UF.federationgroup as fgroup
             FROM
                userfederation UF LEFT JOIN person P ON P.id = UF.person
                LEFT JOIN federation F ON F.id = UF.federation' . $where . ' ORDER BY UF.federationgroup, UF.type',
        $params);

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/federation.php');
        $result['navigation'] = federation_navig($dbConnect);
        return $result;
    }
    function userfederation_add($dbConnect, $CONSTPath) {
        if ((($_SESSION['userType'] == 3)) || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/federation.php');
            $result['navigation'] = federation_navig($dbConnect);
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }
    function userfederation_create($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_POST['federation']] == 1)) {
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
                        'page' => '/?r=federation'
                    );
                }
            }

            $params = array(
                'person' => $did,
                'federation' => $_POST['federation'],
                'work' => '',
                'type' => $_POST['type'],
                'group' => $_POST['group']
            );

            if ($_POST['isEmployee']) {
                $params['work'] = trim($_POST['work']);
            }

            common_query($dbConnect,
                'INSERT INTO userfederation
             (person, federation, type, work, federationgroup)
             VALUES (:person, :federation, :type, :work, :group)'
                , $params
            );
            $page = '';
            switch ($_POST['group']) {
                case 2: $page = 'exec'; break;
                case 3: $page = 'team'; break;
                case 4: $page = 'ref'; break;
                case 5: $page = 'disc'; break;
                case 6: $page = 'rev'; break;
                default: $page = 'gen';
            }
            return array(
                'page' => '/?r=federation/' . $page . 'staff&federation=' . $_POST['federation']
            );
        }
        else {
            return 'ERROR-403';
        }
    };

    function userfederation_delete($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {
            common_query($dbConnect, '
                DELETE FROM userfederation
                WHERE id = :id',
                array(
                    'id' => $_GET['uf']
                )
            );
            $page = '';
            switch ($_GET['group']) {
                case 2: $page = 'exec'; break;
                case 3: $page = 'team'; break;
                case 4: $page = 'ref'; break;
                case 5: $page = 'disc'; break;
                case 6: $page = 'rev'; break;
                default: $page = 'gen';
            }
            return array(
                'page' => '/?r=federation/' . $page . 'staff&federation=' . $_GET['federation']
            );
            return array(
                'page' => '/?r=federation/view&federation=' . $_GET['federation']
            );
        }
        else {
            return 'ERROR-403';
        }
    }