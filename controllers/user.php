<?php
    function user_index($dbConnect, $CONSTPath) {
        if (isset($_SESSION['userID']) && $_SESSION['userType'] == 3) {
            $result = array();
            $queryresult = $dbConnect->prepare('
                  SELECT
                    P.id, P.surname, P.name, P.patronymic
                  FROM
                    user U JOIN person AS P ON P.id = U.person
                  ORDER BY P.surname, P.name');
            $queryresult->execute(array());
            $dataset = $queryresult->fetchAll();
            $result['answer'] = $dataset;
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/admin.php');
            $result['navigation'] = admin_navig();
            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }
    function user_auth ($dbConnect, $CONSTPath) {
        $queryresult = $dbConnect->prepare('
          SELECT
            U.id, U.type, U.code, U.person, P.surname, P.name, P.patronymic
          FROM
            user AS U LEFT JOIN person AS P ON P.id = U.person
          WHERE U.email = :login AND U.pass = :password');
        $queryresult->execute(array(
            'login' => $_POST['username'],
            'password' => md5($_POST['password'])
        ));

        $data = $queryresult->fetchAll();
        if (count($data) >0 ) {
            if (!$data[0]['code']) {
                $result = $data[0]['id'];
                $_SESSION['userID'] = $result;
                $_SESSION['userType'] = $data[0]['type'];
                $_SESSION['userPerson'] = $data[0]['person'];
                $_SESSION['userFio'] = $data[0]['surname'] . ' ' . ' ' . $data[0]['name'] . ' ' . $data[0]['patronymic'];

                $person = $data[0]['person'];
                /*получаем права на команды*/
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/userteam.php');
                $userteam = userteam_index($dbConnect, $CONSTPath, null, $person);

                $teams = $userteam['answer'];
                if (count($teams)) {
                    $_SESSION['userTeams'] = array();
                    foreach($teams as $teamid) {
                        $_SESSION['userTeams'][$teamid['team']] = 1;
                    }
                }

                /*получаем права на федерации*/
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/userfederation.php');
                $userteam = userfederation_index($dbConnect, $CONSTPath, null, $person);

                $fed = $userteam['answer'];
                if (count($fed)) {
                    $_SESSION['userFederations'] = array();
                    foreach($fed as $fedid) {
                        $_SESSION['userFederations'][$fedid['federation']] = $fedid['type'];
                    }
                }

                /*получаем права на турниры*/
                /*TODO перенести в контроллер*/
                $usercomp = common_getlist($dbConnect,
                    'SELECT
                        competition as comp
                      FROM
                        usercomp UC
                      WHERE person = :person',
                    array(
                        'person' => $person
                    ));
                if (count($usercomp)) {
                    $_SESSION['userComp'] = array();
                    foreach($usercomp as $compid) {
                        $_SESSION['userComp'][$compid['comp']] = 1;
                    }
                }
            }
            else {
                $_SESSION['error'] = 'Вы не подтвердили регистрацию. Проверьте свой E-Mail';
            }
        }
        else {
            $_SESSION['error'] = 'Неверные логин или пароль <a href="/?r=user/forget">Забыли пароль?</a>';
        }
        return (array(
            'page' => 'index.php'
        ));
    }

    function user_logout () {
        unset($_SESSION['userID']);
        unset($_SESSION['userType']);
        unset($_SESSION['userPerson']);
        unset($_SESSION['userFio']);
        unset($_SESSION['userTeams']);
        unset($_SESSION['userFederations']);
        unset($_SESSION['userComp']);
        return (array(
            'page' => 'index.php'
        ));
    }
    function user_confirm($dbConnect) {
        if (isset($_GET['code'])) {
            $queryresult = $dbConnect->prepare('
              SELECT
                U.id
              FROM
                user AS U
              WHERE U.code = :code');
            $queryresult->execute(array(
                'code' => $_GET['code']
            ));
            $data = $queryresult->fetchAll();
            if (count($data) >0 ) {
                $id = $data[0]['id'];
                $queryresult = $dbConnect->prepare('
                    UPDATE
                      user
                    SET
                      code = ""
                    WHERE
                      id = :id');

                $queryresult->execute(array(
                    'id' => $id
                ));
                $_SESSION['message']='Вы подтвердили свою регистрацию';
            }

        }
        return (array(
            'page' => 'index.php'
        ));
    }
    function user_forget() {

    }
    function user_sendpass($dbConnect, $CONSTPath) {
        $email = $_POST['email'];
        $queryresult = $dbConnect->prepare('
              SELECT
                U.id
              FROM
                user AS U
              WHERE U.email = :email
              LIMIT 1');
        $queryresult->execute(array(
            'email' => $email
        ));
        $data = $queryresult->fetchAll();
        if (count($data) > 0 ) {
            $forget = common_GUID();
            $id = $data[0]['id'];
            $queryresult = $dbConnect->prepare('
                    UPDATE
                      user
                    SET
                      forget = :forget
                    WHERE
                      id = :id');

            $queryresult->execute(array(
                'id' => $id,
                'forget' => $forget
            ));
            common_sendmail($email, 'Access restoring', 'Вы запросили восстановление пароля на сайте amfoot.ru<br/>Перейдите пожалуйста по ссылке <a href="http://amfoot.ru/?r=user/restore&code='.$forget.'">http://amfoot.ru/?r=user/restore&code='.$forget.'</a><br/>Внимание! По ссылке можно перейти только один раз');
            $_SESSION['message'] = 'На ваш E-mail ' . $email . ' выслано письмо со ссылкой на восстановление доступа';
        }
        else {
            $_SESSION['error'] = 'Указанный E-mail не зарегистрирован';
        }
        return array(
            'page' => '/?r=user/forget'
        );
    }
    function user_restore($dbConnect) {
        if (isset($_GET['code'])) {
            $queryresult = $dbConnect->prepare('
              SELECT
                U.id
              FROM
                user AS U
              WHERE U.forget = :code');
            $queryresult->execute(array(
                'code' => $_GET['code']
            ));
            $data = $queryresult->fetchAll();
            if (count($data) >0 ) {
                $id = $data[0]['id'];
                $queryresult = $dbConnect->prepare('
                    UPDATE
                      user
                    SET
                      forget = ""
                    WHERE
                      id = :id');

                $queryresult->execute(array(
                    'id' => $id
                ));
                $_SESSION['forgetUser'] = $id;
                return array(
                    'answer' => $id
                );
            }
            else {
                $_SESSION['error'] = 'Данная ссылка недействительна. Запросите восстановление пароля еще раз';
                return array(
                    'page' => '/?r=user/forget'
                );
            }

        }
        return (array(
            'page' => '/'
        ));
    }

    function user_restorepass($dbConnect) {
        $id = $_POST['id'];
        if ($id == $_SESSION['forgetUser']) {
            $queryresult = $dbConnect->prepare('
                    UPDATE
                      user
                    SET
                      pass = :password
                    WHERE
                      id = :id');

            $queryresult->execute(array(
                'id' => $id,
                'password' => md5($_POST['password'])
            ));
            $_SESSION['forgetUser'] == '';
            $_SESSION['message'] = 'Ваш пароль успешно изменен';
        }
        else {
            $_SESSION['error'] = 'Произошла ошибка при изменении пароля';
        }
        return (array(
            'page' => '/'
        ));
    }

    function user_changepass($db, $CONSTPath) {
        if ($_SESSION['userID']) {
            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
            return array(
                'navigation' => person_navig(),
                'answer' => 1
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function user_savepass($dbConnect) {
        if ($_SESSION['userID']) {
            $id = $_SESSION['userID'];
            $queryresult = $dbConnect->prepare('
                    UPDATE
                      user
                    SET
                      pass = :password
                    WHERE
                      id = :id');

            $queryresult->execute(array(
                'id' => $id,
                'password' => md5($_POST['password'])
            ));
            $_SESSION['message'] = 'Ваш пароль успешно изменен';
        }

        return (array(
            'page' => '/'
        ));
    }

    function user_changetype($dbConnect) {
        if ($_SESSION['userType'] == 3) {
            $queryresult = $dbConnect->prepare('
                    UPDATE
                      user
                    SET
                      type = :type
                    WHERE
                      id = :id');

            $queryresult->execute(array(
                'id' => $_POST['user'],
                'type' => $_POST['type']
            ));
            return (array(
                'page' => '/?r=person/view&person='.$_POST['person']
            ));
        }
    }