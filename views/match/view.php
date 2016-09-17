<? include '_head.php'?>
<table class="match_maintable">
    <colgroup>
        <col width="50%"/>
        <col width="50%"/>
    </colgroup>
    <tr><td colspan="2" class="match_maintable_header"><h2>Набранные очки</h2></td></tr>

        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
            <tr><td colspan="2" class="match_maintable_formAdd">
                <form action="/?r=action/insert" method="POST" class="action-addForm">
                    <input type="hidden" name="comp" value="<?=$_GET['comp']?>">
                    <input type="hidden" name="match" class="action-match" value="<?=$_GET['match']?>"/>
                    <div class="main-fieldWrapper action-addColumn">
                        <label class="main-label_top">Команда</label>
                        <select class="action-team" name="team" data-validate="req">
                            <option value="">Выберите команду</option>
                            <option value="<?=$answer['match']['team1']?>"><?=$answer['match']['t1name']?></option>
                            <option value="<?=$answer['match']['team2']?>"><?=$answer['match']['t2name']?></option>
                        </select>
                    </div>
                    <div class="main-fieldWrapper  action-addColumn">
                        <label class="main-label_top">Действие</label>
                        <select name="pointsget" data-validate="req" class="action-pointsget">
                            <?for ($i = 0; $i < count($answer['pointsget']); $i++) {?>
                                <option value=<?=$answer['pointsget'][$i]['id']?>><?=$answer['pointsget'][$i]['name']?></option>
                            <?}?>
                        </select>
                    </div>
                    <div class="main-fieldWrapper action-addColumn">
                        <label class="main-label_top">Игрок</label>
                        <select name="person" class="action-person">

                        </select>
                    </div>

                    <input type="button" class="main-submit main-btn" value="ОK"/>
                </form>
            </td></tr>
        <?}?>
    <tr>
        <td class="match_cellborder">
<?for ($i = 0; $i < count($answer['action']); $i++) {
    $action = $answer['action'][$i];
    if ($action['team'] == $answer['match']['team1']) {?>
        <div style="margin-bottom: 8px;">
            <span class="match-point"><?='+'.$action['point']?></span>
            <?=$action['surname']. ' '.$action['name'] . ' - '.$action['pgname']?>
            <?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4)|| ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
                <a href="/?r=action/delete&action=<?=$action['id']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">[X]</a>
            <?}?>
        </div>
<?  }
}?>
        </td>
        <td class="match_cellborder">
            <?for ($i = 0; $i < count($answer['action']); $i++) {
                $action = $answer['action'][$i];
                if ($action['team'] == $answer['match']['team2']) {?>
                    <div style="margin-bottom: 8px;">
                        <span class="match-point"><?='+'.$action['point']?></span>
                    	<?=$action['surname']. ' '.$action['name'] . ' - '.$action['pgname']?>
                        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
                            <a href="/?r=action/delete&action=<?=$action['id']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">[X]</a>
                        <?}?>
                    </div>
                <?  }
            }?>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="match_maintable_header"><h2>Составы на игру</h2></td>
    </tr>
<?
function initials($record) {
    return $record['surname'] . ' ' . $record['name'] . ' '. $record['patronymic'];
}
?>
    <tr>
        <td class="match_cellborder">

            <?  $roster = $answer['team1roster'];
                if (!count($roster)) {?>
                <div>
                    Состав не заполнен
                    <?if ($team1) {?>
                        <button class="main-btn match-matchroster_addlink" data-match="<?=$_GET['match']?>" data-team="<?=$answer['match']['team1']?>">+</button>
                    <?}?>
                </div>
                <?if ($team1) {?>
                    <a href="/?r=matchroster/autofill&match=<?=$_GET['match']?>&team=<?=$answer['match']['team1']?>">Заполнить автоматически</a>
                <?}?>
            <?} else {?>
                <?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
                    <h3 class="match-rostercheck"><a href="/?r=matchroster/refcheck&match=<?=$_GET['match']?>&team=<?=$answer['match']['team1']?>&comp=<?=$_GET['comp']?>">Проверка состава</a></h3>
                <?}?>
                <h3>
                    Игроки
                    <?if ($team1) {?>
                        <button class="main-btn match-matchroster_addlink" data-match="<?=$_GET['match']?>" data-team="<?=$answer['match']['team1']?>">+</button>
                    <?}?>
                </h3>
                <table class="match-mathcroster_table" data-team="<?=$answer['match']['team1']?>">
                    <colgroup>
                        <col width="20px"/>
                        <col/>
                        <?if ($team1) {?><col width="100px"<?}?>
                    </colgroup>

                    <?
                    for ($i = 0; $i < count($roster); $i++) {?>
                        <tr>
                            <td class="match-matchroster_number">#<?=$roster[$i]['number']?></td>
                            <td class="match-matchroster_fio"><a target="_blank" href="/?r=person/view&person=<?=$roster[$i]['personID']?>"><?=initials($roster[$i])?></a> (<?=$roster[$i]['abbr']?>)</td>
                            <?if ($team1) {?>
                                <td>
                                    <a href="javascript: void(0)" class="match-matchroster_edit" data-mr="<?=$roster[$i]['id']?>">[ред]</a>
                                    <a href="javascript: void(0)" class="match-matchroster_del" data-mr="<?=$roster[$i]['id']?>">[x]</a>
                                </td>
                            <?}?>
                        </tr>
                    <?}?>
                </table>
                <h3>Официальные лица</h3>
                <table class="match-mathcroster_table">
                    <colgroup>
                        <col/>
                        <col/>
                    </colgroup>
                    <?
                    $roster = $answer['face1'];
                    for ($i = 0; $i < count($roster); $i++) {?>

                        <tr>
                            <td class="match-matchroster_fio"><?=initials($roster[$i])?></td>
                            <td class="match-matchroster_fio"><?=$roster[$i]['facetype']?></td>
                        </tr>
                    <?}?>
                </table>
                <a href="/?r=matchroster/print&team=<?=$answer['match']['team1']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Печать</a>
            <?}?>
        </td>
        <td class="match_cellborder">

            <?  $roster = $answer['team2roster'];
                if (!count($roster)) {?>
                <div>
                    Состав не заполнен
                    <?if ($team2) {?>
                        <button class="main-btn match-matchroster_addlink" data-match="<?=$_GET['match']?>" data-team="<?=$answer['match']['team2']?>">+</button>
                    <?}?>
                </div>
                <?if ($team2){?>
                    <a href="/?r=matchroster/autofill&match=<?=$_GET['match']?>&team=<?=$answer['match']['team2']?>">Заполнить автоматически</a>
                <?}?>
            <?} else {?>
                <?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
                    <h3 class="match-rostercheck"><a href="/?r=matchroster/refcheck&match=<?=$_GET['match']?>&team=<?=$answer['match']['team2']?>&comp=<?=$_GET['comp']?>">Проверка состава</a></h3>
                <?}?>
                <h3>
                    Игроки
                    <?if ($team2) {?>
                        <button class="main-btn match-matchroster_addlink" data-match="<?=$_GET['match']?>" data-team="<?=$answer['match']['team2']?>">+</button>
                    <?}?>
                </h3>
                <table class="match-mathcroster_table" data-team="<?=$answer['match']['team2']?>">
                    <colgroup>
                        <col width="20px"/>
                        <col/>
                        <?if ($team2) {?><col width="100px"<?}?>
                    </colgroup>
                    <?
                    $roster = $answer['team2roster'];
                    for ($i = 0; $i < count($roster); $i++) {?>
                        <tr>
                            <td class="match-matchroster_number">#<?=$roster[$i]['number']?></td>
                            <td class="match-matchroster_fio"><a target="_blank" href="/?r=person/view&person=<?=$roster[$i]['personID']?>"><?=initials($roster[$i])?></a> (<?=$roster[$i]['abbr']?>)</td>
                            <?if ($team2) {?>
                                <td>
                                    <a href="javascript: void(0)" class="match-matchroster_edit" data-mr="<?=$roster[$i]['id']?>">[ред]</a>
                                    <a href="javascript: void(0)" class="match-matchroster_del" data-mr="<?=$roster[$i]['id']?>">[x]</a>
                                </td>
                            <?}?>
                        </tr>
                    <?}?>
                </table>
                <h3>Официальные лица</h3>
                <table class="match-mathcroster_table">
                    <colgroup>
                        <col/>
                        <col/>
                    </colgroup>
                    <?
                    $roster = $answer['face2'];
                    for ($i = 0; $i < count($roster); $i++) {?>

                        <tr>
                            <td class="match-matchroster_fio"><?=initials($roster[$i])?></td>
                            <td class="match-matchroster_fio"><?=$roster[$i]['facetype']?></td>
                        </tr>
                    <?}?>
                </table>
                <a href="/?r=matchroster/print&team=<?=$answer['match']['team2']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Печать</a>
            <?}?>
        </td>
    </tr>
</table>
<div class="match-matchroster-edit">
    <input type="text" class="match-matchroster_numberinput"/>
    <span class="match-matchroster_fioinput"></span>
    <a class="match-matchroster_ok" href="javascript:void(0);">[ok]</a>
    <a class="match-matchroster_cancel" href="javascript:void(0);">[отмена]</a>
</div>
<div class="match-matchroster_add">
    <input type="text" class="match-matchroster_numberinputAdd" data-validate="req" placeholder="№"/>
    <select class="match-matchroster_player">

    </select>
    <a class="match-matchroster_okAdd" href="javascript:void(0);">[ok]</a>
</div>