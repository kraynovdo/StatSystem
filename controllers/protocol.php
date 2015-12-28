<?php
    function protocol_view($dbConnect, $CONSTPath) {
        $result = array();
        $queryresult = $dbConnect->prepare(
            'SELECT * FROM protocol WHERE id = :match
        ');
        $queryresult->execute(array(
            'match' => $_GET['match']
        ));
        $protocol = $queryresult->fetchAll();
        /*match*/
        $queryresult = $dbConnect->prepare(
            'SELECT
                M.competition, T1.rus_name AS t1, T2.rus_name AS t2, date, P1.surname AS surname1, P1.name AS name1,  P2.surname AS surname2, P2.name  AS name2
             FROM
                `match` AS M LEFT JOIN team T1 ON T1.id = M.team1
                LEFT JOIN team T2 ON T2.id = M.team2
                LEFT JOIN rosterface RF1 ON RF1.team = M.team1 AND RF1.facetype = 5
                LEFT JOIN rosterface RF2 ON RF2.team = M.team2 AND RF2.facetype = 5
                LEFT JOIN person P1 ON RF1.person = P1.id
                LEFT JOIN person P2 ON RF2.person = P2.id
             WHERE M.id = :match
        ');
        $queryresult->execute(array(
            'match' => $_GET['match']
        ));
        $match = $queryresult->fetchAll();


        $result['answer'] = array(
            'protocol' => $protocol,
            'match' => $match[0]
        );

        /*comp*/

        $comp = $match[0]['competition'];
        require($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
        $result['navigation'] = competition_NAVIG($dbConnect, $comp);

        return $result;
    }

    function protocol_edit($dbConnect, $CONSTPath) {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4)) {
            return protocol_view($dbConnect, $CONSTPath);
        }
        else {
            return 'ERROR-403';
        }
    }
    function protocol_print($dbConnect, $CONSTPath) {
        $result = array(
            'answer' => array()
        );
        $view = protocol_view($dbConnect, $CONSTPath);
        $result['answer']['protocol'] = $view['answer']['protocol'];
        $result['answer']['match'] = $view['answer']['match'];
        require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/controllers/competition.php');
        $result['answer']['compinfo'] = competition_info ($dbConnect, $CONSTPath, $_GET['comp']);
        return $result;

    }

    function protocol_update($dbConnect, $CONSTPath) {
        $result = array();
        if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4)) {

            $queryresult = $dbConnect->prepare('SELECT * FROM protocol WHERE id = :match');
            $queryresult->execute(array(
                'match' => $_POST['match']
            ));
            $protocol = $queryresult->fetchAll();
            $result['answer'] = $protocol;
            if (!count($protocol)) {
                $queryresult = $dbConnect->prepare('INSERT INTO protocol (id) VALUES (:match)');
                $queryresult->execute(array('match' => $_POST['match']));
            }

            $queryresult = $dbConnect->prepare('
              UPDATE protocol SET
              color1 = :color1,
              color2 = :color2,
              timeb = :timeb,
              timee = :timee,
              time1 = :time1,
              time2 = :time2,
              time3 = :time3,
              time4 = :time4,
              point1 = :point1,
              point2 = :point2,
              pointover1 = :pointover1,
              pointover2 = :pointover2,
              razm = :razm,
              razd = :razd,
              ball = :ball,
              chain = :chain,
              ballboy = :ballboy,
              chaincrew = :chaincrew,
              weather = :weather,
              form1 = :form1,
              form2 = :form2,
              player1 = :player1,
              player2 = :player2,
              coach1 = :coach1,
              coach2 = :coach2,
              refferee = :refferee,
              backjudge = :backjudge,
              linejudge = :linejudge,
              linesman = :linesman,
              empire = :empire,
              judge6 = :judge6,
              judge7 = :judge7,
              incident = :incident
              WHERE id = :match
            ');
            $queryresult->execute(array(
                'match' => $_POST['match'],
                'color1' => $_POST['color1'],
                'color2' => $_POST['color2'],
                'timeb' => $_POST['timeb'],
                'timee' => $_POST['timee'],
                'time1' => $_POST['time1'],
                'time2' => $_POST['time2'],
                'time3' => $_POST['time3'],
                'time4' => $_POST['time4'],
                'point1' => $_POST['point1'],
                'point2' => $_POST['point2'],
                'pointover1' => $_POST['pointover1'],
                'pointover2' => $_POST['pointover2'],
                'razm' => $_POST['razm'],
                'razd' => $_POST['razd'],
                'ball' => $_POST['ball'],
                'chain' => $_POST['chain'],
                'ballboy' => $_POST['ballboy'],
                'chaincrew' => $_POST['chaincrew'],
                'weather' => $_POST['weather'],
                'form1' => $_POST['form1'],
                'form2' => $_POST['form2'],
                'player1' => $_POST['player1'],
                'player2' => $_POST['player2'],
                'coach1' => $_POST['coach1'],
                'coach2' => $_POST['coach2'],
                'refferee' => $_POST['refferee'],
                'empire' => $_POST['empire'],
                'backjudge' => $_POST['backjudge'],
                'linejudge' => $_POST['linejudge'],
                'linesman' => $_POST['linesman'],
                'judge6' => $_POST['judge6'],
                'judge7' => $_POST['judge7'],
                'incident' => $_POST['incident']
            ));

            if ($_POST['point1'] || $_POST['point1'] == 0) {
            	$score1 = $_POST['point1'];
            	$scoreover1 = $_POST['pointover1'] ? $_POST['pointover1'] : 0;
            }
            if ($_POST['point2'] || $_POST['point2'] == 0) {
            	$score2 = $_POST['point2'];
            	$scoreover2 = $_POST['pointover2'] ? $_POST['pointover2'] : 0;
            }

            if (($score1 + $scoreover1) || ($score2 + scoreover2)) {
            	$queryresult = $dbConnect->prepare(
                'UPDATE `match` SET score1 = :score1, score2 = :score2 WHERE id = :match
          	');
	            $queryresult->execute(array(
	                'match' => $_POST['match'],
	                'score1' => $score1 + $scoreover1,
	                'score2' => $score2 + $scoreover2
	            ));
            }


            return array(
                'page' => '/?r=protocol/view&match='.$_POST['match']
            );
        }
        else {
            return 'ERROR-403';
        }
    }