<?php
    function request_fill($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1) ||  ($_SESSION['userTeams'][$_GET['team']])) {
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/competition.php');
            $result = array();
            $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);

            $data = common_getrecord($dbConnect, '
                SELECT
                  CT.confirm AS confirm, CT.id AS ctid,
                  T.rus_name,
                  T.name,
                  T.city,
                  T.city_adj,
                  T.city_eng,
                  T.org_form,
                  T.color_1,
                  T.color_2,
                  T.color_3,
                  T.color_helmet,
                  T.color_mask,
                  T.color_jersey1,
                  T.color_jersey2,
                  T.color_breeches1,
                  T.color_breeches2,
                  T.color_socks1,
                  T.color_socks2,
                  T.color_sleeve1,
                  T.color_sleeve2
                FROM
                  team T LEFT JOIN compteam CT ON T.id = CT.team AND competition = :comp
                WHERE
                  T.id = :team
            ', array(
                    'team' => $_GET['team'],
                'comp' => $_GET['comp']
            ));

            $result['answer'] = array();

            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/opf.php');
            $opf = opf_index($dbConnect, $CONSTPath);
            $result['answer']['opf'] = $opf['answer'];

            require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/user.php');
            $user = user_search($dbConnect, $CONSTPath);
            $result['answer']['user'] = $user;

            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/facetype.php');
            $facetype = facetype_index($dbConnect, $CONSTPath);
            $result['answer']['facetype'] = $facetype['answer'];

            $result['answer']['request'] = $data;

            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function request_post ($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_POST['comp']] == 1) ||  ($_SESSION['userTeams'][$_POST['team']])) {
            $data = common_getrecord($dbConnect, '
                SELECT
                  1
                FROM
                  compteam CT
                WHERE
                  team = :team AND competition = :comp
            ', array(
                'team' => $_POST['team'],
                'comp' => $_POST['comp']
            ));



            if (!count($data)) {
                common_query($dbConnect, '
                  INSERT INTO
                    compteam
                    (team, competition, confirm)
                  VALUES
                    (:team, :comp, 0)
                ', array(
                    'team' => $_POST['team'],
                    'comp' => $_POST['comp']
                ));

                common_query($dbConnect, '
                  INSERT INTO
                    rosterface
                    (team, competition, person, facetype)
                  VALUES
                    (:team, :comp, :person, :facetype)
                ', array(
                    'team' => $_POST['team'],
                    'comp' => $_POST['comp'],
                    'person' => $_POST['director'],
                    'facetype' => $_POST['work']
                ));
            }
            common_query($dbConnect, '
                UPDATE team
                SET
                  name = :name,
                  rus_name = :rus_name,
                  city = :city,
                  city_adj = :city_adj,
                  city_eng = :city_eng,
                  color_1 = :color_1,
                  color_2 = :color_2,
                  color_3 = :color_3,
                  color_helmet = :color_helmet,
                  color_mask = :color_mask,
                  color_jersey1 = :color_jersey1,
                  color_breeches1 = :color_breeches1,
                  color_sleeve1 = :color_sleeve1,
                  color_socks1 = :color_socks1,
                  color_jersey2 = :color_jersey2,
                  color_breeches2 = :color_breeches2,
                  color_sleeve2 = :color_sleeve2,
                  color_socks2 = :color_socks2
                WHERE
                  id = :team
            ', array(
                'name' => $_POST['name'],
                'rus_name' => $_POST['rus_name'],
                'city' => $_POST['city'],
                'city_adj' => $_POST['city_adj'],
                'city_eng' => $_POST['city_eng'],
                'team' => $_POST['team'],
                'color_1' => $_POST['color_1'],
                'color_2' => $_POST['color_2'],
                'color_3' => $_POST['color_3'],
                'color_helmet' => $_POST['color_helmet'],
                'color_mask' => $_POST['color_mask'],
                'color_jersey1' => $_POST['color_jersey1'],
                'color_breeches1' => $_POST['color_breeches1'],
                'color_sleeve1' => $_POST['color_sleeve1'],
                'color_socks1' => $_POST['color_socks1'],
                'color_jersey2' => $_POST['color_jersey2'],
                'color_breeches2' => $_POST['color_breeches2'],
                'color_sleeve2' => $_POST['color_sleeve2'],
                'color_socks2' => $_POST['color_socks2']
            ));

            return array(
                'page' => '/?r=team/request&team='.$_POST['team']
            );
        }
        else {
            return 'ERROR-403';
        }

    }

    function request_choose($dbConnect, $CONSTPath) {
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
        $result = array();
        $result['navigation'] = competition_NAVIG($dbConnect, $_GET['comp']);
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/userteam.php');
        if ($_SESSION['userPerson']) {
            $list = userteam_list($dbConnect, $CONSTPath, null, $_SESSION['userPerson']);
            if (count($list) > 1) {
                $result['answer'] = $list;
                return  $result;
            }
            else {
                if (count($list) == 1) {
                    return array(
                        'page' => '/?r=request/fill&comp='.$_GET['comp'].'&team='.$list[0]['team']
                    );
                }
                else {
                    return 'ERROR-403';
                }
            }
        }
        else {
            return 'ERROR-403';
        }
    };

    function request_confirm ($dbConnect, $comp, $team, $confirm) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_POST['comp']] == 1)) {
            common_query($dbConnect, '
              UPDATE compteam
              SET confirm = :confirm
              WHERE team = :team AND competition = :comp
            ', array(
                'comp' => $comp,
                'team' => $team,
                'confirm' => $confirm
            ));
            return array(
                'page' => '/?r=request/fill&team='.$team.'&comp='.$comp
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function request_confirm_1($dbConnect) {
        return request_confirm($dbConnect, $_GET['comp'], $_GET['team'], 1);
    }

    function request_confirm_0($dbConnect) {
        return request_confirm($dbConnect, $_GET['comp'], $_GET['team'], 0);
    }

