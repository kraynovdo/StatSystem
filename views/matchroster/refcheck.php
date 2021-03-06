<?
    if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4)) {
        $FULLACCESS = true;
    }
    else {
        if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['maininfo']['team1']]) || ($_SESSION['userComp'][$_GET['comp']] == 1) ) {
            $T1ACCESS = true;
        }
        if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['maininfo']['team2']]) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
            $T2ACCESS = true;
        }
    }
    $ret = 'match/view';
    if ($_GET['ret']) {
        $ret = $_GET['ret'];
    }
?>
<div class="main-fieldWrapper">
    <a class="refcheck-bigfont" href="/?r=<?=$ret?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Вернуться к матчу</a>
</div>
<?if ($FULLACCESS) {?>
    <div class="refcheck_ctrlBlock">
        <a data-id="<?=$_GET['match']?>" href="javascript: void(0);"
           class="refcheck-bigfont refcheck_confirm"><?if ($answer['match']['confirm']) {?>Открыть на изменение<?} else {?>Закрыть от изменений<?}?></a>
    </div>
    <div class="main-tabs">
        <a class="main-tabs_item<?if ($_GET['team'] == $answer['match']['team1']) {?> main-tabs_item_active<?}?>" href="/?r=matchroster/refcheck&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>&team=<?=$answer['match']['team1']?>&ret=<?=$_GET['ret']?>"><?=$answer['match']['t1name']?></a>
        <a class="main-tabs_item<?if ($_GET['team'] == $answer['match']['team2']) {?> main-tabs_item_active<?}?>" href="/?r=matchroster/refcheck&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>&team=<?=$answer['match']['team2']?>&ret=<?=$_GET['ret']?>"><?=$answer['match']['t2name']?></a>
    </div>
<?} else {?>
    <?if ($answer['match']['confirm']) {?>
        <div class="refcheck-bigfont">Состав проверен и закрыт от изменений</div>
    <?}?>
<?}?>
<div class="main-fieldWrapper">
    <a target="_blank" href="/?r=matchroster/print&team=<?=$_GET['team']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Печать</a>
</div>
<?$roster = $answer['roster']['answer'];?>
<div class="refcheck-list">
    <?if (!count($roster)) {?>
        <a class="refcheck-auto<?if ($answer['match']['confirm']) {?> main-hidden<?}?>" href="/?r=matchroster/autofill&match=<?=$_GET['match']?>&team=<?=$_GET['team']?>&ret=<?=$ret?>">Заполнить автоматически</a>
    <?}?>
    <button class="main-btn refcheck_addLink<?if ($answer['match']['confirm']) {?> main-hidden<?}?>" data-match="<?=$_GET['match']?>" data-team="<?=$_GET['team']?>">+ Добавить игрока из заявки</button>
    <div class="refcheck-add main-hidden">
        <input class="refcheck-hMatch" type="hidden" name="match" value="<?=$_GET['match']?>"/>
        <input class="refcheck-hTeam" type="hidden" name="team" value="<?=$_GET['team']?>"/>
        <div class="match-matchroster_fio">
            <select class="refcheck-add_player">

            </select>
        </div>
        <div>
            <input type="text" class="refcheck-numberAdd" data-validate="req" placeholder="№"/>
        <span class="match-matchroster_ctrl">
            <a class="refcheck_okAdd" href="javascript:void(0);">[ok]</a>
        </span>
        </div>
    </div>
    <?for ($i = 0; $i < count($roster); $i++) {?>
        <div class="listview-item refcheck-item" data-mr="<?=$roster[$i]['id']?>">
            <div class="refcheck-photo">
                <?if ($roster[$i]['avatar']) {?>
                    <img style="width:100px" src="//<?=$HOST?>/upload/<?=$roster[$i]['avatar']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </div>
            <div class="refcheck-main">
                <div class="refcheck-fio refcheck-bigfont"><?=$roster[$i]['surname'] . ' ' . $roster[$i]['name'] . ' ' . $roster[$i]['patronymic']?></div>
                <div class="refcheck-number  refcheck-bigfont">#<?=$roster[$i]['number']?></div>
                <div class="refcheck-inputCont main-hidden">
                    <input class="refcheck-input refcheck-bigfont" value="<?=$roster[$i]['number']?>"/>
                </div>
                <a href="javascript: void(0)"
                   class="refcheck-change refcheck-bigfont<?if ($answer['match']['confirm']) {?> main-hidden<?}?>">Изменить номер</a>

                <a href="javascript: void(0)" class="main-hidden refcheck-ok refcheck-bigfont">Сохранить</a>
                    <a href="javascript: void(0)" data-mr="<?=$roster[$i]['id']?>"
                       class="refcheck-delete refcheck-bigfont<?if ($answer['match']['confirm']) {?> main-hidden<?}?>">Удалить из состава</a>
            </div>
        </div>
    <?}?>
</div>


<?if ($FULLACCESS) {?>
<div class="refcheck_ctrlBlock">
    <a data-id="<?=$_GET['match']?>" href="javascript: void(0);"
       class="refcheck-bigfont refcheck_confirm"><?if ($answer['match']['confirm']) {?>Открыть на изменение<?} else {?>Закрыть от изменений<?}?></a>
</div>
<div class="main-tabs">
    <a class="main-tabs_item<?if ($_GET['team'] == $answer['match']['team1']) {?> main-tabs_item_active<?}?>" href="/?r=matchroster/refcheck&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>&team=<?=$answer['match']['team1']?>"><?=$answer['match']['t1name']?></a>
    <a class="main-tabs_item<?if ($_GET['team'] == $answer['match']['team2']) {?> main-tabs_item_active<?}?>" href="/?r=matchroster/refcheck&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>&team=<?=$answer['match']['team2']?>"><?=$answer['match']['t2name']?></a>
</div>
<?}?>

<div class="main-fieldWrapper">
    <a class="refcheck-bigfont" href="/?r=<?=$ret?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Вернуться к матчу</a>
</div>