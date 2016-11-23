<?php
    class admin extends BaseController {
        function _comp() {
            require_once($_SERVER['DOCUMENT_ROOT'] . $this->CONSTPath  . '/controllers/usercomp.php');
            $userComp = new usercomp($this->dbConnect, $this->CONSTPath);
            $result['answer'] = $userComp->_list(null, $_GET['person']);
            $result['navigation'] = admin_navig();
            return $result;
        }
    }
    //OK
    function admin_navig() {
        $person = $_SESSION['userPerson'];
        $menu = array(
            'Мой профиль' => '/?r=admin&person='. $person,
            'Мои команды' => '/?r=admin/team&person='. $person,
            'Мои турниры' => '/?r=admin/comp&person='. $person
        );
        if ($_SESSION['userType'] == 3) {
            $menu['Федерации'] = '/?r=federation';
            $menu['Пользователи'] = '/?r=user';
            $menu['Статистика'] = '/?r=statconfig';
        }
        return array(
            'menu' => $menu,
            'header' => 'Панель пользователя',
            'mobile_view' => 1

        );
    }
    function admin_index($db, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/person.php');
        $person = person_view($db, $CONSTPath);
        $person['navigation'] = admin_navig();
        return $person;
    }

    function admin_team($db, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/userteam.php');
        $result['answer'] = userteam_list($db, $CONSTPath, null, $_GET['person']);
        $result['navigation'] = admin_navig();
        return $result;
    }

    function admin_comp($db, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/usercomp.php');
        $result['answer'] = usercomp_list($db, $CONSTPath, null, $_GET['person']);
        $result['navigation'] = admin_navig();
        return $result;
    }