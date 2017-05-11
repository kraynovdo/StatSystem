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
<?if (count($answer['comps'])) {?>
    <div class="main-fieldWrapper">
        <label>Турнир </label>
        <select class="team-compSelector">
            <?for ($i = 0; $i < count($answer['comps']); $i++) {?>
                <option value="<?=$answer['comps'][$i]['id']?>"
                    <?if ($answer['comps'][$i]['id'] == $answer['compId']) {?> selected="selected"<?}?>><?=$answer['comps'][$i]['name']?> <?=$answer['comps'][$i]['yearB']?></option>
            <?}?>
        </select>
    </div>
    <?if (count($answer['teamRoster'])) {?>
        <span class="person_careerTeam person_careerElem">
          <?if ($answer['teamRoster']['logo']) {?>
              <img style="width:100%" src="//<?=$HOST?>/upload/<?=$answer['teamRoster']['logo']?>">
          <?} else {?>
              <div class="main-noPhoto">?</div>
          <?}?>
        </span>
        <span class="person_careerElem"><?=$answer['teamRoster']['rus_name']?></span>
        <span class="person_careerElem">№ <?=$answer['teamRoster']['number']?></span>
        <span class="person_careerElem"><?=$answer['teamRoster']['abbr']?></span>
    <?}?>
        <?$stats = $answer['stats']; if (count($stats)){?>
        <h3>Персональная статистика</h3>


        <?for ($i = 0; $i < count($stats); $i++) {?>
            <div class="listview-item">
                <span class="action-pgName"><?=$stats[$i]['pointname']?></span> -
                <span class="action-pgCount"><?=$stats[$i]['count']?></span>
            </div>
        <?}?>
    <?}?>
<?}?>

<br/><br/><br/>
<?if (($answer['person']['user']) && ($_SESSION['userType'] == 3) && ($answer['person']['utype'] != 3)){?>
    <h2>Права доступа</h2>
    <form method="POST" action="/?r=user/changetype">
        <input type="hidden" name="person" value="<?=$_GET['person']?>"/>
        <input type="hidden" name="user" value="<?=$answer['person']['user']?>"/>
        <select name="type">
            <option value="1" <?if ($answer['person']['utype'] == 1) {?>selected="selected"<?}?>>Пользователь</option>
            <option value="4" <?if ($answer['person']['utype'] == 4) {?>selected="selected"<?}?>>Судья</option>
            <option value="5" <?if ($answer['person']['utype'] == 5) {?>selected="selected"<?}?>>Статист</option>
        </select>
        <input type="button" class="main-btn main-submit" value="Сменить"/>
    </form>
<?}?>
<?} else {?>
    Персона не найдена
<?}?>
