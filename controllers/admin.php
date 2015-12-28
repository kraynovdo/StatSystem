<?php
    //OK
    function admin_navig() {
        $person = $_SESSION['userPerson'];
        $menu = array(
            'Мой профиль' => '/?r=admin&person='. $person,
            'Мои команды' => '/?r=userteam&person='. $person
        );
        if ($_SESSION['userType'] == 3) {
            $menu['Федерации'] = '/?r=federation';
            $menu['Пользователи'] = '/?r=user';
            $menu['Статистика'] = '/?r=statconfig';
        }
        return array(
            'menu' => $menu,
            'header' => 'Панель пользователя'
        );
    }
    function admin_index($db, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
        $person = person_view($db, $CONSTPath);
        $person['navigation'] = admin_navig();
        return $person;

    }