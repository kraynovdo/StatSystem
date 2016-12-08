<div class="match-dateinfo main-centerAlign">
    <?=common_dateFromSQL($answer['match']['date'])?>
    <?if (strlen($answer['match']['timeh']) && strlen($answer['match']['timeh'])) {?>
        <?=$answer['match']['timeh']?>:<?=$answer['match']['timem']?> (мск.)
    <?}?>
    <?if ($answer['match']['city']) {?>
        <?=$answer['match']['city']?>
    <?}?>
</div>
<table class="match_maintable">
    <colgroup>
        <col width="50%"/>
        <col width="50%"/>
    </colgroup>
    <tr>
        <td class="match_teamhead main-centerAlign">
            <div class="match-teamLogo">
                <?if ($answer['match']['t1logo']) {?>
                    <img style="width:80px" src="//<?=$HOST?>/upload/<?=$answer['match']['t1logo']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </div>
        </td>
        <td class="match_teamhead main-centerAlign">
            <div class="match-teamLogo">
                <?if ($answer['match']['t2logo']) {?>
                    <img style="width:80px" src="//<?=$HOST?>/upload/<?=$answer['match']['t2logo']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="match_teamhead main-centerAlign"><h3><?=$answer['match']['t1name']?></h3></td>
        <td class="match_teamhead main-centerAlign"><h3><?=$answer['match']['t2name']?></h3></td>
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
        <td class="match_teamhead main-centerAlign"><h1><?=$score1?></h1></td>
        <td class="match_teamhead main-centerAlign"><h1><?=$score2?></h1></td>
    </tr>
    <?
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['match']['team1']]) || ($_SESSION['userComp'][$_GET['comp']] == 1) ) {
        $team1 = true;
    }
    if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['match']['team2']]) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
        $team2 = true;
    }
    ?>
</table>