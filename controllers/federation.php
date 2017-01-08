<?php
    function federation_navig($dbConnect, $federation=null) {
        if (!$federation) $federation = $_GET['federation'];
        $fedInfo = common_getrecord($dbConnect, '
            SELECT
                name, fullname, logo
            FROM
                federation
            WHERE
                id = :feder
        ', array(
            'feder' => $federation
        ));
        if ( mb_strlen($fedInfo['fullname']) > 100) {
            $header = $fedInfo['name'];
        }
        else {
            $header = $fedInfo['fullname'];
        }
        $navig = array(
            'menu' => array(
                'Новости' => '/?r=news&federation='. $federation,
                'Соревнования' => '/?r=competition/index&federation='. $federation,
                'Команды' => '/?r=team&federation='. $federation,
                'Документы' => '/?r=document&federation='. $federation,
                'Контакты' => '/?r=federation/view&federation='. $federation,
                'Товарищеские матчи' => '/?r=friendlymatch&federation='. $federation
            ),
            'header' => $header,
            'title' => $fedInfo['fullname'],
            'description' => 'Официальный сайт '. $fedInfo['fullname'] . '. Здесь вы можете найти свежие новости, информацию о соревнованиях и командах',
            'keywords' => array($fedInfo['fullname'], $fedInfo['name'])
            //'logo' => $fedInfo['logo']
        );
        if ($federation == 11) {
        	$navig['theme'] = 'fafr';
        }
        return $navig;
    }

    function federation_regions($dbConnect, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
        $result['navigation'] = start_NAVIG();
        $result['answer'] = common_getlist($dbConnect, '
          SELECT
              id, name, fullname, logo,
              (select count(*) FROM team T WHERE T.geo_region = federation.geo_region AND sex = 1 AND age = 21) AS m,
              (select count(*) FROM team T WHERE T.geo_region = federation.geo_region AND sex = 2) AS w,
              (select count(*) FROM team T WHERE T.geo_region = federation.geo_region AND age != 21) AS u
          FROM federation WHERE type = 4 AND geo_country = 1
        ');
        return $result;
    }

    function federation_index($dbConnect, $CONSTPath) {
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
            $result = array(
                'navigation' => admin_navig()
            );
            $result['answer'] = common_getlist($dbConnect, 'SELECT id, name, type FROM federation ORDER BY type');
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function federation_add($dbConnect, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
        $result = array(
            'navigation' => admin_navig()
        );
        $result['answer'] = array ();
        return $result;
    }

    function federation_check($dbConnect, $CONSTPath, $type = null, $code = null) {
        $place = '';
        if (!$type) {
            $type = $_GET['type'];
        }
        if (($type == 1 || $type == 3)) {
            return array(
                'answer' => 0
            );
        }
        else if ($type == 2) {
            $place = 'geo_country';
        } else if ($type == 4) {
            $place = 'geo_region';
        }
        if (!$code) {
            $code = $_GET['code'];
        }
        $fed = common_getlist($dbConnect, '
                SELECT
                  1
                FROM
                  federation
                WHERE
                  type = :type AND ' . $place . ' = :code
            ', array(
                'type' => $type,
                'code' => $code
            )
        );
        return array(
            'answer' => (count($fed) > 0)
        );
    }

    function federation_read($dbConnect, $CONSTPath, $fedId = null) {
        if (!$fedId) {
            $fedId = $_GET['federation'];
        }
        $federation = common_getrecord($dbConnect, '
            SELECT
                F.name, F.fullname, F.logo, F.type, F.geo_country, GC.name AS country, F.geo_region, GR.name AS region, F.geo_city, GCi.name AS city, F.street, F.house, F.corpse, F.flat, F.email, F.vk_link, F.inst_link, F.twitter
            FROM
                federation F
            LEFT JOIN geo_country GC ON F.geo_country = GC.id
            LEFT JOIN geo_region GR ON F.geo_region = GR.id
            LEFT JOIN geo_city GCi ON F.geo_city = GCi.id
            WHERE
              F.id = :federation
            LIMIT 1
          ',
           array(
               'federation' => $fedId
           )
        );
        return $federation;
    }

    function federation_view($dbConnect, $CONSTPath) {
        $result['answer'] = array();
        $federation = federation_read($dbConnect, $CONSTPath);
        $result['answer']['federation'] = $federation;
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
        $result['navigation'] = admin_navig($dbConnect);

        $countries = array();
        $regions = array();
        if (($federation['type'] == '1') || ($federation['type'] == '2')) {
            $countries = common_getlist($dbConnect,
                'SELECT
                    GC.id, GC.name
                 FROM
                    federcountry F LEFT JOIN geo_country GC ON F.geo_country = GC.id
                 WHERE F.federation = :federation',
            array(
                'federation' => $_GET['federation']
            ));
        }
        else {
            $regions = common_getlist($dbConnect,
                'SELECT
                    GR.id, GR.name
                 FROM
                    federregion F LEFT JOIN geo_region GR ON F.geo_region = GR.id
                 WHERE F.federation = :federation',
            array(
                'federation' => $_GET['federation']
            ));
        }
        $result['answer']['countries'] = $countries;
        $result['answer']['regions'] = $regions;

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/userfederation.php');
        $userfed = userfederation_index($dbConnect, $CONSTPath, $_GET['federation']);
        $result['answer']['userfederation'] = $userfed['answer'];

        return $result;
    }

    function federation_edit($dbConnect, $CONSTPath){
        if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {
            $result['answer'] = array();
            $federation = federation_read($dbConnect, $CONSTPath);
            $result['answer']['federation'] = $federation;
            $result['navigation'] = federation_navig($dbConnect);
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function federation_update($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_POST['federation']] == 1)) {
            $federation = federation_read($dbConnect, $CONSTPath, $_POST['federation']);
            $oldLogo = $federation['logo'];
            $logo = common_loadFile('logo', $CONSTPath);
            if ($logo) {
                if ($oldLogo) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/upload/' . $oldLogo);
                }
            }
            else {
                $logo = $oldLogo;
            }
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/geolocation.php');
            geolocation_addCity($dbConnect, $_POST['geo_city'], $_POST['geo_cityTitle']);
            common_query($dbConnect, '
                UPDATE federation
                SET
                  name = :name,
                  fullname = :fullname,
                  email = :email,
                  logo = :logo,
                  vk_link = :vk_link,
                  inst_link = :inst_link,
                  twitter = :twitter,
                  geo_country = :geo_country,
                  geo_region = :geo_region,
                  geo_city = :geo_city,
                  street = :street,
                  house = :house,
                  corpse = :corpse,
                  flat = :flat
                WHERE id = :federation
            ', array(
                'name' => trim($_POST['name']),
                'fullname' => trim($_POST['fullname']),
                'email' => trim($_POST['email']),
                'logo' => $logo,
                'vk_link' => trim($_POST['vk_link']),
                'inst_link' => trim($_POST['inst_link']),
                'twitter' => trim($_POST['twitter']),
                'federation' => $_POST['federation'],
                'geo_country' => $_POST['geo_country'],
                'geo_region' => $_POST['geo_region'],
                'geo_city' => $_POST['geo_city'],
                'street' => $_POST['street'],
                'house' => $_POST['house'],
                'corpse' => $_POST['corpse'],
                'flat' => $_POST['flat']
            ));
            return array(
                'page' => '/?r=federation/view&federation='.$_POST['federation']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function federation_create($dbConnect, $CONSTPath) {
        $logo = common_loadFile('logo', $CONSTPath);
        if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {
            //Люди
            if ($_POST['d_id']) {
                $did = $_POST['d_id'];
                common_query($dbConnect, 'UPDATE person SET phone = :phone WHERE id = :id', array(
                    'id' => $did,
                    'phone' => $_POST['d_phone']
                ));
            }
            else {
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
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
                    'city' => null,
                    'region' => null,
                    'avatar' => null,
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
            if ($_POST['a_id']) {
                $aid = $_POST['a_id'];
                common_query($dbConnect, 'UPDATE person SET phone = :phone WHERE id = :id', array(
                    'id' => $aid,
                    'phone' => $_POST['a_phone']
                ));
            }
            else {
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
                $pIns = person_insert($dbConnect, $CONSTPath, array(
                    'surname' => $_POST['a_fio'],
                    'name' => $_POST['a_name'],
                    'patronymic' => $_POST['a_patr'],
                    'birthdate' => $_POST['a_date'],
                    'phone' => $_POST['a_phone'],
                    'email' => null,
                    'vk_link' => null,
                    'skype' => null,
                    'geo_country' => null,
                    'city' => null,
                    'region' => null,
                    'avatar' => null,
                    'weight' => null,
                    'growth' => null
                ));
                if ($pIns['success']) {
                    $aid = $pIns['success'];
                }
                if ($pIns['error']) {
                    $_SESSION['error'] = $pIns['error'];
                    return array(
                        'page' => '/?r=federation'
                    );
                }
            }

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/geolocation.php');
            geolocation_addCity($dbConnect, $_POST['geo_city'], $_POST['geo_cityTitle']);
            common_query($dbConnect,
                'INSERT INTO federation
             (name, fullname, logo, type, geo_country, geo_region, geo_city, street, house, corpse, flat, email)
             VALUES (:name, :fullname, :logo, :type, :geo_country, :geo_region, :geo_city, :street, :house, :corpse, :flat, :email)'
                , array(
                    'name' => $_POST['name'],
                    'fullname' => $_POST['fullname'],
                    'logo' => $logo,
                    'type' => $_POST['type'],
                    'geo_country' => $_POST['geo_country'],
                    'geo_region' => $_POST['geo_region'],
                    'geo_city' => $_POST['geo_city'],
                    'street' => $_POST['street'],
                    'house' => $_POST['house'],
                    'corpse' => $_POST['corpse'],
                    'flat' => $_POST['flat'],
                    'email' => $_POST['email']
                )
            );
            $federation = $dbConnect->lastInsertId('id');
            /*Должности*/
            common_query($dbConnect,
                'INSERT INTO userfederation
             (person, federation, type, work)
             VALUES (:person, :federation, 1, "Руководитель")'
                , array(
                    'person' => $did,
                    'federation' => $federation
                )
            );
            common_query($dbConnect,
                'INSERT INTO userfederation
             (person, federation, type)
             VALUES (:person, :federation, 1)'
                , array(
                    'person' => $aid,
                    'federation' => $federation
                )
            );
            /**/
            $countries = $_POST['geo_countryP'];
            if (count($countries) && $_POST['type'] <= 2) {
                for ($i = 0; $i < count($countries); $i++) {
                    if ($_POST['geo_countryP'][$i]) {
                        common_query($dbConnect,
                            'INSERT INTO federcountry
                          (federation, geo_country)
                          VALUES (:federation, :geo_country)'
                            , array(
                                'federation' => $federation,
                                'geo_country' => $_POST['geo_countryP'][$i]
                            ));
                    }
                }
            }
            $regions = $_POST['geo_regionP'];
            if (count($regions) && $_POST['type'] > 2) {
                for ($i = 0; $i < count($regions); $i++) {
                    if ($_POST['geo_regionP'][$i]) {
                        common_query($dbConnect,
                            'INSERT INTO federregion
                              (federation, geo_region)
                              VALUES (:federation, :geo_region)'
                            , array(
                                'federation' => $federation,
                                'geo_region' => $_POST['geo_regionP'][$i]
                            ));
                    }
                }
            }

            return array(
                'page' => '/?r=federation'
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function federation_createRegion($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_POST['federation']] == 1)) {
            $federation = $_POST['federation'];
            if ($federation) {
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/geolocation.php');
                common_query($dbConnect, '
                INSERT INTO
                  federregion
                  (federation, geo_region)
                  VALUES (:federation, :region)
                ', array(
                    'federation' => $federation,
                    'region' => $_POST['geo_region']
                ));
            }
            return array(
                'page' => '/?r=federation/view&federation='.$federation
            );
        }
    }

    function federation_createCountry($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_POST['federation']] == 1)) {
            $federation = $_POST['federation'];
            if ($federation) {
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/geolocation.php');
                common_query($dbConnect, '
                    INSERT INTO
                      federcountry
                      (federation, geo_country)
                      VALUES (:federation, :country)
                    ', array(
                    'federation' => $federation,
                    'country' => $_POST['geo_country']
                ));
            }
            return array(
                'page' => '/?r=federation/view&federation='.$federation
            );
        }
    }


    function federation_info ($dbConnect, $CONSTPath) {
        $result = array();
        if ($_GET['federation'] == 11) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
            $result['navigation'] = start_NAVIG();
        }

        return $result;
    }

    function federation_func ($dbConnect, $CONSTPath) {
        $result = array();
        if ($_GET['federation'] == 11) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
            $result['navigation'] = start_NAVIG();
        }

        return $result;
    }

    function federation_history($dbConnect, $CONSTPath) {
        if ($_GET['federation'] == 11) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
            $result['navigation'] = start_NAVIG();
        }

        return $result;
    }

    function federation_contacts ($dbConnect, $CONSTPath) {
        $result = array();
        if ($_GET['federation'] == 11) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
            $result['navigation'] = start_NAVIG();
        }

        return $result;
    }
    function federation_logo ($dbConnect, $CONSTPath) {
        $result = array();
        if ($_GET['federation'] == 11) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
            $result['navigation'] = start_NAVIG();
        }
        $result['answer'] = array();
        $federation = federation_read($dbConnect, $CONSTPath);
        $result['answer']['federation'] = $federation;

        return $result;
    }
    function federation_presentation ($dbConnect, $CONSTPath) {
        $result = array();
        if ($_GET['federation'] == 11) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
            $result['navigation'] = start_NAVIG();
        }

        return $result;
    }
    function federation_face ($dbConnect, $CONSTPath) {
        $result = array();
        if ($_GET['federation'] == 11) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/start.php');
            $result['navigation'] = start_NAVIG();
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/userfederation.php');
        $userfed = userfederation_index($dbConnect, $CONSTPath, $_GET['federation']);
        $result['answer']['userfederation'] = $userfed['answer'];

        return $result;
    }

