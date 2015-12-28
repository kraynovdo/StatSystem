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

            $query = '
                    UPDATE translation SET title = :title, link = :link WHERE id = :trans
                ';
            $queryresult = $dbConnect->prepare($query);
            $queryresult->execute(array(
                'title' => $_POST['title'],
                'link' => $link,
                'trans' => $_POST['trans']
            ));
            return array(
                'page' => '/'
            );
        }
        else {
            return 'ERROR-403';
        }
    }

    function translation_mainpage($dbConnect, $CONSTPath) {
        $query = '
            SELECT
              id, title, link
            FROM
              translation
            WHERE competition = :comp
        ';

        $queryresult = $dbConnect->prepare($query);
        $queryresult->execute(array(
            'comp' => $_GET['comp']
        ));
        $dataset = $queryresult->fetchAll();
        return $dataset;
    }
//<iframe style="margin:0; padding:0; border:0; width:725px; height:408px;" src="//videocore.tv/player_embed_jw/?conferenceId=519&w=725&h=408&a=0"></iframe>