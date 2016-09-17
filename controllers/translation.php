<?php
    //OK
    function translation_edit($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            $query = '
                SELECT
                  id, title, link
                FROM
                  translation
                WHERE id = :trans
            ';

            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'trans' => $_GET['trans']
            ));
            $dataset = $queryresult->fetchAll();
            $dataset[0]['link'] = str_replace("\\\"", "\"", $dataset[0]['link']);
            $result['answer'] = $dataset[0];


            $result['navigation'] = array(
                'menu' => array(),
                'header' => 'Трансляция'
            );

            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }
    function translation_update($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {

            $link = $_POST['link'];
            if (strpos($_POST['link'], 'youtu.be')) {
                $pos = strripos($link, '/');
                $code = mb_substr($link, $pos+1);
                $link = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$code.'" frameborder="0" allowfullscreen></iframe>';
            }

            if ($_POST['trans']) {
                $query = '
                    UPDATE translation SET title = :title, link = :link WHERE id = :trans
                ';
                $queryresult = $dbConnect->prepare($query);
                $queryresult->execute(array(
                    'title' => $_POST['title'],
                    'link' => $link,
                    'trans' => $_POST['trans']
                ));
            }
            else {
                $query = '
                    INSERT INTO translation (title, link, competition) VALUES (:title, :link, :comp)
                ';
                $queryresult = $dbConnect->prepare($query);
                $queryresult->execute(array(
                    'title' => $_POST['title'],
                    'link' => $link,
                    'comp' => $_POST['comp']
                ));
            }
            return array(
                'page' => '/?r=competition/view&comp='.$_POST['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function translation_mainpage($dbConnect, $CONSTPath) {
        $filter = ' AND link != ""';
        if ($_SESSION['userType'] == 3) {
            $filter = '';
        }

        $query = '
            SELECT
              id, title, link
            FROM
              translation
            WHERE competition = :comp'.$filter;

        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute(array(
            'comp' => $_GET['comp']
        ));
        $dataset = $queryresult->fetchAll();
        return $dataset;
    }

    function translation_delete($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            $query = '
                DELETE FROM translation WHERE id = :trans
            ';
            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'trans' => $_GET['trans']
            ));
            return array(
                'page' => '/?r=competition/view&comp='.$_GET['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }
//<iframe style="margin:0; padding:0; border:0; width:725px; height:408px;" src="//videocore.tv/player_embed_jw/?conferenceId=519&w=725&h=408&a=0"></iframe>