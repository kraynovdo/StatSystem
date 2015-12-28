<table class="match_maintable">
    <colgroup>
        <col width="50%"/>
        <col width="50%"/>
    </colgroup>
    <tr>
        <td class="match_teamhead"><h3><?=$answer['match']['t1name']?></h3></td>
        <td class="match_teamhead"><h3><?=$answer['match']['t2name']?></h3></td>
    </tr>
    <?
    if (!$answer['match']['score1'] && $answer['match']['score1'] !== '0') {
        $score1 = '-';
    }
    else {
        $score1 = $answer['match']['score1'];
    }
    if (!$answer['match']['score2'] && $answer['match']['score2'] !== '0') {
        $score2 = '-';
    }
    else {
        $score2 = $answer['match']['score2'];
    }
    ?>
    <tr>
        <td class="match_teamhead"><h1><?=$score1?></h1></td>
        <td class="match_teamhead"><h1><?=$score2?></h1></td>
    </tr>
    <?
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['match']['team1']])) {
        $team1 = true;
    }
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['match']['team2']])) {
        $team2 = true;
    }
    ?>
</table>