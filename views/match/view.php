<?
function initials($record) {
    return $record['surname'] . ' ' . $record['name'];
}
?>
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
    <?$teamArr = array('team1', 'team2');?>
    <?for ($j = 0; $j < count($teamArr); $j++) {?>
            <td class="match_cellborder">
                <?for ($i = 0; $i < count($answer['action']); $i++) {
                    $action = $answer['action'][$i];
                    if ($action['team'] == $answer['match'][$teamArr[$j]]) {?>
                        <?
                            $actionStr = trim($action['surname']. ' '.$action['name']);
                            if (!$IS_MOBILE) {
                                if ($actionStr) {

                                    $actionStr .= ' - ';
                                }
                                $actionStr .= $action['pgname'];
                            }
                            else {
                                if (!$actionStr) {
                                    $actionStr .= $action['pgname'];
                                }
                            }

                        ?>
                        <div class="match-point_item">
                            <span class="match-point"><?='+'.$action['point']?></span><span class="match-point_fio"><?=$actionStr?></span>
                            <?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4)|| ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
                                <?if($IS_MOBILE){?><br/><?}?><a class="match-point_delLink main-delLink" href="/?r=action/delete&action=<?=$action['id']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">[X]</a>
                            <?}?>
                        </div>
                <?  }
                }?>
            </td>
    <?}?>

    </tr>

    <tr>
        <td colspan="2" class="match_maintable_header"><h2>Составы на игру</h2></td>
    </tr>
    <tr>
        <td class="match_cellborder">

            <?
                $roster = $answer['team1roster'];
                $rosterFace = $answer['face1'];
                $hasAccess = $team1 && !$answer['match']['confirm'];
                $teamID = $answer['match']['team1'];
                include '_matchroster.php';
            ?>

        </td>
        <td class="match_cellborder">
            <?
                $roster = $answer['team2roster'];
                $rosterFace = $answer['face2'];
                $hasAccess = $team2 && !$answer['match']['confirm'];
                $teamID = $answer['match']['team2'];
                include '_matchroster.php';
            ?>
        </td>
    </tr>
</table>
<div class="match-matchroster-edit">
    <div class="match-matchroster_fio">
        <span class="match-matchroster_fioinput"></span>
    </div>
    <div>
        <input type="text" class="match-matchroster_numberinput"/>
        <span class="match-matchroster_ctrl">
            <a class="match-matchroster_ok" href="javascript:void(0);">[ok]</a>
            <a class="match-matchroster_cancel" href="javascript:void(0);">[отмена]</a>
        </span>
    </div>
</div>
<div class="match-matchroster_add">
    <div class="match-matchroster_fio">
        <select class="match-matchroster_player">

        </select>
    </div>
    <div>
        <input type="text" class="match-matchroster_numberinputAdd" data-validate="req" placeholder="№"/>
        <span class="match-matchroster_ctrl">
            <a class="match-matchroster_okAdd" href="javascript:void(0);">[ok]</a>
        </span>
    </div>
</div>