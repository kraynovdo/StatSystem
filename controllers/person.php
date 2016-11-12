<?php
    function person_navig($person=null) {
        if (!$person) $person = $_GET['person'];
        $menu = array(
            'Профиль' => '/?r=person/view&person='. $person
        );
        if ($_SESSION['userType'] == 3) {
            $menu['Команды'] = '/?r=userteam/index&person=' . $person;
        }
        $navig = array(
            'menu' => $menu,
            'header' => 'профиль'
        );
        return $navig;
    }
    function person_view($dbConnect, $CONSTPath) {
        $queryresult = $dbConnect->prepare('
        SELECT
          P.name, surname, patronymic, birthdate, GC.id AS geo_country, GC.name AS geo_countryTitle, phone, P.email, vk_link, skype, avatar, weight, growth, U.id AS user, U.type AS utype
        FROM
          person P LEFT JOIN user U ON U.person = P.id LEFT JOIN geo_country GC ON GC.id = P.geo_country
        WHERE
          P.id = :id
        LIMIT 1');
        $queryresult->execute(array(
            'id' => $_GET['person']
        ));
        $data = $queryresult->fetchAll();
        if (count($data)) {
            $result['answer']['person'] = $data[0];
        } else {
            $result['answer']['person'] = array();
        }
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/action.php');
        $result['answer']['stats'] = action_personstats($dbConnect, $CONSTPath, $_GET['person']);

        $result['navigation'] = person_navig();
        $result['navigation']['mobile_view'] = 1;

        return $result;
    }

    function person_stat($dbConnect) {
        $navig = person_navig();
        $result = array(
            'navigation' => $navig,
            'header' => 'Профиль игрока'
        );
        return $result;
    }

    function person_edit($dbConnect, $CONSTPath) {
        if (($_GET['person'] == $_SESSION['userPerson']) || ($_SESSION['userType'] == 3)) {
            return person_view($dbConnect, $CONSTPath);
        }
        else {
            return 'ERROR-403';
        }
    }

    function person_getNewAvatar($dbConnect, $CONSTPath, $person, $fileName) {
        $avatar = null;
        $oldRecord = common_getrecord($dbConnect, '
              SELECT
                avatar
              FROM
                person AS P
              WHERE id = :id',
                array(
                    'id' => $person
                )
        );
        if ($oldRecord) {
            $oldAvatar = $oldRecord['avatar'];
            $avatar = common_loadFile($fileName, $CONSTPath);
            if ($avatar) {
                if ($oldAvatar) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/upload/' . $oldAvatar);
                }
            }
            else {
                $avatar = $oldAvatar;
            }
        }
        return $avatar;
    }


    function person_update($dbConnect, $CONSTPath) {
        $id = $_POST['person'];
        if (($id == $_SESSION['userPerson']) || ($_SESSION['userType'] == 3)) {

            $avatar = person_getNewAvatar($dbConnect, $CONSTPath, $id, 'avatar');
            $date = common_dateToSQL($_POST['birthdate']);
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/geolocation.php');
            $queryresult = $dbConnect->prepare('
            UPDATE
              person
            SET
              birthdate = :birthdate,
              growth = :growth,
              weight = :weight,
              geo_country = :geo_country,
              phone = :phone,
              skype = :skype,
              vk_link = :vk_link,
              avatar = :avatar
            WHERE
              id = :id');

            if (strlen($_POST['geo_country'])) {
                $geo_country = $_POST['geo_country'];
            }
            else {
                $geo_country = NULL;
            }

            $queryresult->execute(array(
                'id' => $id,
                'birthdate' => $date,
                'growth' => $_POST['growth'],
                'weight' => $_POST['weight'],
                'geo_country' => $geo_country,
                'phone' => $_POST['phone'],
                'skype' => $_POST['skype'],
                'vk_link' => $_POST['vk_link'],
                'avatar' => $avatar
            ));
            $_SESSION['message'] = 'Ваши данные изменены';
            return array(
                'page' => '/?r=person/view&person=' . $id
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function person_check($dbConnect, $s, $n, $p, $b) {
        $birthdate = common_dateToSQL($b);
        $surname = trim($s);
        $name = trim($n);
        $patronymic = trim($p);

        $queryresult = $dbConnect->prepare('
            SELECT id
            FROM person
            WHERE surname = :surname AND name = :name AND patronymic = :patronymic AND birthdate = :birthdate');

        $queryresult->execute(array(
            'surname' => $surname,
            'name' => $name,
            'patronymic' => $patronymic,
            'birthdate' => $birthdate
        ));
        $data = $queryresult->fetchAll();
        if (count($data)) {
            return array(
                'answer' => 1
            );
        }
        else {
            return array(
                'answer' => 0
            );
        }
    }
    function person_autocomplete($dbConnect) {
        $surname = $_POST['surname'];
        $result = array();
        $queryresult = $dbConnect->prepare('
              SELECT
                P.id, P.surname, P.name, P.patronymic, P.birthdate, P.phone, GC.id AS geo_country, GC.name AS geo_countryTitle, P.growth, P.weight, P.email, P.avatar
              FROM
                person AS P LEFT JOIN geo_country GC ON GC.id = P.geo_country
              WHERE
                P.surname = :surname
              ORDER BY P.surname, P.name');
        $queryresult->execute(array(
            'surname' => $surname
        ));
        $dataset = $queryresult->fetchAll();
        $result['answer'] = $dataset;
        return $result;
    }

    function person_checkemail($dbConnect) {
        $email = $_POST['email'];
        $result = array();
        $query = 'SELECT id FROM person where email = :email';
        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute(array(
            'email' => $email
        ));

        $dataset = $queryresult->fetchAll();
        $result['answer'] = $dataset;
        return $result;
    }

    function person_insert($dbConnect, $CONSTPath, $fields) {
        $RES = array();
        $exists = person_check($dbConnect, $fields['surname'],  $fields['name'],  $fields['patronymic'],  $_POST['birthdate']);
        if ($exists['answer'] == 1) {
            $RES['error'] = 'Пользователь с данными Ф.И.О и датой рождения уже зарегистрирован в системе';
            return $RES;
        }
        $fields['surname'] = trim($fields['surname']);
        $fields['name'] = trim($fields['name']);
        $fields['patronymic'] = trim($fields['patronymic']);
        $fields['birthdate'] = common_dateToSQL($fields['birthdate']);

        if (!strlen($fields['geo_country'])) {
            $fields['geo_country'] = NULL;
        }
        common_query($dbConnect,
            'INSERT INTO person
                      (surname, name, patronymic, birthdate, phone, email, vk_link, skype, geo_country, avatar, growth, weight)
                      VALUES
                      (:surname, :name, :patronymic, :birthdate, :phone, :email, :vk_link, :skype, :geo_country, :avatar, :growth, :weight)'
            , $fields
        );
        $person = $dbConnect->lastInsertId('id');
        return array(
            'success' => $person
        );
    }