<div>
    <a href="/?r=matchcenter&comp=<?=$_GET['comp']?>&match=<?=$_GET['match']?>">Вернуться к матчу</a>
</div><br/>
<?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
    <form action="/?r=action/insert" method="POST" class="action-addForm">
        <input type="hidden" name="comp" value="<?=$_GET['comp']?>">
        <input type="hidden" name="ret" value="action/edit">
        <input type="hidden" name="match" class="action-match" value="<?=$_GET['match']?>"/>
        <div class="main-fieldWrapper action-addColumn">
            <label class="main-label_top">Команда</label>
            <select class="action-team" name="team" data-validate="req">
                <option value="">Выберите команду</option>
                <option value="<?=$answer['maininfo']['team1']?>"><?=$answer['maininfo']['t1name']?></option>
                <option value="<?=$answer['maininfo']['team2']?>"><?=$answer['maininfo']['t2name']?></option>
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

        <div class="main-fieldWrapper action-addColumn">
            <label class="main-label_top">Четверть</label>
            <select name="period" data-validate="req">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">ОТ</option>
            </select>
        </div>

        <input type="button" class="main-submit main-btn" value="ОK"/>
    </form>
<?}?>
<table class="match_maintable">
    <colgroup>
        <col width="50%"/>
        <col width="50%"/>
    </colgroup>
    <tr>
        <td><h2><?=$answer['maininfo']['t1name']?></h2></td>
        <td><h2><?=$answer['maininfo']['t2name']?></h2></td>
    </tr>
    <tr><?$teamArr = array('team1', 'team2');?>
        <?for ($j = 0; $j < count($teamArr); $j++) {?>
            <td class="match_cellborder">
                <?for ($i = 0; $i < count($answer['action']); $i++) {
                $action = $answer['action'][$i];
                if ($action['team'] == $answer['maininfo'][$teamArr[$j]]) {?>
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

                    if ($action['period'] < 5) {
                        $period = $action['period'] . ' четв';
                    }
                    else {
                        $period = 'ОТ';
                    }
                    ?>
                    <div class="match-point_item">
                        <span class="match-point"><?='+'.$action['point']?></span><span class="match-point_fio"><?=$actionStr?></span><span> (<?=$period?>)</span>
                        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 2) || ($_SESSION['userType'] == 4)|| ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
                            <?if($IS_MOBILE){?><br/><?}?><a class="match-point_delLink main-delLink" href="/?r=action/delete&ret=action/edit&action=<?=$action['id']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">[X]</a>
                        <?}?>
                    </div>
                    <?  }
            }?>
            </td>
            <?}?>

    </tr>