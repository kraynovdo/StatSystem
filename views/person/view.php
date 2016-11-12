<?php if (count($answer['person'])) {?>
<div class="main-infoBlock person-infoBlock">
    <div class="main-avatar">
        <?if ($answer['person']['avatar']) {?>
            <img style="width:100%" src="//<?=$HOST?>/upload/<?=$answer['person']['avatar']?>">
        <?} else {?>
            <div class="main-noPhoto">?</div>
        <?}?>
    </div>
    <div class="main-infoText__title team-infoText__title"><?=($answer['person']['surname'] . ' ' . $answer['person']['name'])?></div>
    <?
    $bitrhdate = '-';
    if ($answer['person']['birthdate'] != '0000-00-00') {
        $bitrhdate = common_dateFromSQL($answer['person']['birthdate']);
    }
    ?>
    <?if ($IS_MOBILE){?>
        <div class="clearfix"></div>
    <?}?>
    <span class="main-infoText__value">Дата рождения: <span class="main-infoText__content"><?=$bitrhdate?></span></span>
    <span class="main-infoText__value">Рост: <span class="main-infoText__content"><?=($answer['person']['growth'] ? $answer['person']['growth'] . ' см' : '-')?></span></span>
    <span class="main-infoText__value">Вес: <span class="main-infoText__content"><?=($answer['person']['weight'] ? $answer['person']['weight'] . ' кг' : '-')?></span></span>
    <span class="main-infoText__value">Гражданство: <span class="main-infoText__content"><?=($answer['person']['geo_countryTitle'])?></span></span>



    <div class="main-infoBlock__footer">
        <?if ($_SESSION['userID'] && ($_GET['person'] == $_SESSION['userPerson'])) {?>
            <a class="main-editLink" href="/?r=user/changepass&id=<?=$_GET['person']?>">Сменить пароль</a>
        <?}?>
        <?if (($_GET['person'] == $_SESSION['userPerson']) || ($_SESSION['userType'] == 3)) {?>
            <a class="main-editLink" href="/?r=person/edit&person=<?=$_GET['person']?>">Редактировать данные</a>
        <?}?>

    </div>

</div>
<?if (($answer['person']['user']) && ($_SESSION['userType'] == 3) && ($answer['person']['utype'] != 3)){?>
    <h2>Права доступа</h2>
    <form method="POST" action="/?r=user/changetype">
        <input type="hidden" name="person" value="<?=$_GET['person']?>"/>
        <input type="hidden" name="user" value="<?=$answer['person']['user']?>"/>
        <select name="type">
            <option value="1" <?if ($answer['person']['utype'] == 1) {?>selected="selected"<?}?>>Пользователь</option>
            <option value="4" <?if ($answer['person']['utype'] == 4) {?>selected="selected"<?}?>>Судья</option>
        </select>
        <input type="button" class="main-btn main-submit" value="Сменить"/>
    </form>
<?}?>
<?$stats = $answer['stats']; if (count($stats)){?>
    <h2>Персональная статистика</h2>
    <?$comp=null; $compName=null?>
    <?for ($i = 0; $i < count($stats); $i++) {?>
        <?if ($stats[$i]['competition'] != $comp) {
                $comp = $stats[$i]['competition'];
                $compName = $stats[$i]['compname'] . ' ' . $stats[$i]['yearB'];
        ?>
        <h3 class="action-comp"><?=$compName?></h3>
        <?}?>
        <div class="listview-item">
            <span class="action-pgName"><?=$stats[$i]['pointname']?></span> -
            <span class="action-pgCount"><?=$stats[$i]['count']?></span>
        </div>
    <?}?>
<?}?>
<?} else {?>
    Персона не найдена
<?}?>