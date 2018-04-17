<?php
    function registration_index(){
        $result = array();
        $navig_arr = array(
            'code' => 'reg',
            'title' => 'Федерация Американского Футбола России',
            'description' => 'Официальный сайт Федерации Американского Футбола России (ФАФР). Здесь вы можете найти свежие новости, информацию о соревнованиях и командах',
            'keywords' => array('Федерация Американского Футбола России', 'ФАФР'),
            'pageId' => 53
        );
        $result['navigation'] = $navig_arr;
        return $result;

    }

    function registration_team($dbConnect, $CONSTPath) {
        $index = registration_index();
        $index['navigation']['pageId'] = 54;
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/sport.php');
        $sport = sport_index($dbConnect, $CONSTPath);
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/opf.php');
        $opf = opf_index($dbConnect, $CONSTPath);
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/age.php');
        $age = age_index($dbConnect, $CONSTPath);
        return array(
            'navigation' => $index['navigation'],
            'answer' => array(
                'sport' => $sport['answer'],
                'opf' => $opf['answer'],
                'age' => $age['answer']
            )
        );
    }

    function registration_checkEmail($dbConnect, $email){
        $result = false;
        $queryresult = $dbConnect->prepare('
                    SELECT id FROM person WHERE email = :email
                ');
        $queryresult->execute(array(
            'email' => $email
        ));
        $dataset = $queryresult->fetchAll();
        if (count($dataset)) {
            $result = true;
        }
        else {
            $queryresult = $dbConnect->prepare('
                    SELECT id FROM user WHERE email = :email
                ');
            $queryresult->execute(array(
                'email' => $email
            ));
            $dataset = $queryresult->fetchAll();
            if (count($dataset)) {
                $result = true;
            }
        }
        return $result;
    }

    function registration_reg($dbConnect, $CONSTPath){
        if ($_POST['imnothuman'] || (!$_POST['person'] && !$_POST['birthdate'])) {
            $index = registration_index();
            return array(
                'answer' => 'У нас можно регистрироваться только реальным людям',
                'navigation' => $index['navigation']
            );
        }
        /*Если автовыбрали человека*/
        if ($_POST['person']) {
            $personId = $_POST['person'];
            /*Но у него не была задана почта*/
            if ($_POST['newEmail']) {
                $email = $_POST['email'];
                if (registration_checkEmail($dbConnect, $_POST['email'])) {
                    $index = registration_index();
                    return array(
                        'answer' => 'Данный E-mail уже ипользуется',
                        'navigation' => $index['navigation']
                    );
                }
                else {
                    $queryresult = $dbConnect->prepare('
                      UPDATE person SET email = :email WHERE id = :id
                    ');
                    $queryresult->execute(array(
                        'email' => $_POST['email'],
                        'id' => $personId
                    ));
                }
            }
            else {
                $email = $_POST['personEmail'];
            }
        }
        else {
            $email = $_POST['email'];
            if (registration_checkEmail($dbConnect, $_POST['email'])) {
                $index = registration_index();
                return array(
                    'answer' => 'Данный E-mail уже ипользуется. Обратитесь к администратору krdcs@yandex.ru',
                    'navigation' => $index['navigation']
                );
            }
            else {
                require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
                $pIns = person_insert($dbConnect, $CONSTPath, array(
                    'surname' => $_POST['surname'],
                    'name' => $_POST['name'],
                    'patronymic' => $_POST['patronymic'],
                    'birthdate' => $_POST['birthdate'],
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'],
                    'vk_link' => $_POST['vk_link'],
                    'skype' => $_POST['skype'],
                    'geo_country' => $_POST['geo_country'],
                    'avatar' => common_loadFile('avatar', $CONSTPath),
                    'weight' => $_POST['weight'],
                    'growth' => $_POST['growth']
                ));
                if ($pIns['success']) {
                    $personId = $pIns['success'];
                }
                if ($pIns['error']) {
                    $_SESSION['error'] = $pIns['error'];
                }
            }
        }

        /*Судья*/
        if ($personId) {
            if ($_POST['referee']) {
                $queryresult = $dbConnect->prepare('
                      SELECT id FROM referee where person = :person
                    ');
                $queryresult->execute(array(
                    'person' => $personId
                ));
                $dataset = $queryresult->fetchAll();
                if (!count($dataset)) {
                    $queryresult = $dbConnect->prepare('
                      INSERT INTO referee
                      (person, exp, expplay)
                      VALUES
                      (:person, :exp, :expplay)
                    ');
                    $queryresult->execute(array(
                        'person' => $personId,
                        'exp' => $_POST['exp'],
                        'expplay' => $_POST['expplay']
                    ));
                }
            }

            $queryresult = $dbConnect->prepare('
              SELECT id FROM user where person = :person
            ');
            $queryresult->execute(array(
                'person' => $personId
            ));
            $dataset = $queryresult->fetchAll();
            if (count($dataset)) {
                $index = registration_index();
                return array(
                    'answer' => 'Вы уже зарегистрированы в системе. Обратитесь к администратору krdcs@yandex.ru',
                    'navigation' => $index['navigation']
                );
            }
            else {
                $code = common_GUID();
                $queryresult = $dbConnect->prepare('
                      INSERT INTO user
                      (email, pass, type, person, code)
                      VALUES
                      (:email, :pass, :type, :person, :code)
                    ');
                $queryresult->execute(array(
                    'email' => $email,
                    'pass' => md5($_POST['password']),
                    'type' => 1,
                    'person' => $personId,
                    'code' => ''
                ));
                //common_sendmail($_POST['email'], "Registration confirm amfoot.net", ' <p>Ваш E-mail был указан как регистрационный на сайте amfoot.net</p></br> '.
                    //'Для завершения регистрации перейдите по ссылке <a href="http://amfoot.net/?r=user/confirm&code='.$code.'">http://amfoot.net/?r=user/confirm&code='.$code.'</a>');

                /*return array(
                    'answer' => 'На указанный электронный адрес отправлено письмо. Пройдите по ссылке из письма для завершения регистрации<br/>
                    При возникновении проблем напишите на почту krdcs@yandex.ru<br/>'
                );*/
                $index = registration_index();
                return array(
                    'answer' => 'Регистрация прошла успешно<br/>
                    При возникновении проблем напишите на почту krdcs@yandex.ru<br/>',
                    'navigation' => $index['navigation']
                );
            }
        }

    }

    function registration_regteam($dbConnect, $CONSTPath) {
        $queryresult = $dbConnect->prepare('
              SELECT id FROM team where city = :city AND name = :name AND age = :age AND sport = :sport
            ');
        $queryresult->execute(array(
            'name' => $_POST['name'],
            'city' => $_POST['city'],
            'sport' => $_POST['sport'],
            'age' => $_POST['age']
        ));
        $dataset = $queryresult->fetchAll();
        if (count($dataset)) {
            $index = registration_index();
            return array(
                'answer' => 'Данная команда уже была создана ранее. Обратитесь к администратору krdcs@yandex.ru',
                'navigation' => $index['navigation']
            );
        }



        $logo = common_loadFile('logo', $CONSTPath);
        $vect_logo = common_loadFile('vect_logo', $CONSTPath);
        $ogrn_doc = common_loadFile('ogrn_doc', $CONSTPath);
        $queryresult = $dbConnect->prepare('
          INSERT INTO team (rus_name, abbr, rus_abbr, name, geo_region, city, org_form, sport, sex, age, email, vk_link, inst_link, twitter_link, logo, vect_logo, ogrn_doc, geo_country)
          VALUES (:rus_name, :abbr, :rus_abbr, :name, :geo_region, :city, :org_form, :sport, :sex, :age, :email, :vk_link, :inst_link, :twitter_link, :logo, :vect_logo, :ogrn_doc, :geo_country)
        ');

        $region = $_POST['geo_region'] ? $_POST['geo_region'] : NULL;
        $org_form = $_POST['org_form'] ? $_POST['org_form'] : NULL;

        $queryresult->execute(array(
            'rus_name' => $_POST['rus_name'],
            'abbr' => substr($_POST['name'], 0, 3),
            'rus_abbr' => mb_substr($_POST['rus_name'], 0, 6),
            'name' => $_POST['name'],
            'geo_region' => $region,
            'city' => $_POST['city'],
            'sport' => $_POST['sport'],
            'org_form' => $org_form,
            'age' => $_POST['age'],
            'sex' => $_POST['sex'],
            'email' => $_POST['email'],
            'vk_link' => $_POST['vk_link'],
            'inst_link' => $_POST['inst_link'],
            'twitter_link' => $_POST['twitter_link'],
            'logo' => $logo,
            'vect_logo' => $vect_logo,
            'ogrn_doc' => $ogrn_doc,
            'geo_country' => $_POST['geo_country']
        ));
        $index = registration_index();
        return array(
            'answer' => 'Ваша команда успешно создана',
            'navigation' => $index['navigation']
        );


    }