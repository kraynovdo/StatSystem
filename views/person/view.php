<?php if (count($answer['person'])) {?>
<div class="main-infoBlock">
    <div class="main-avatar">
        <?if ($answer['person']['avatar']) {?>
            <img style="width:190px" src="//<?=$HOST?>/upload/<?=$answer['person']['avatar']?>">
        <?} else {?>
            <div class="main-noPhoto">?</div>
        <?}?>
    </div>
    <div class="main-infoText">
<?
    $bitrhdate = '-';
    if ($answer['person']['birthdate'] != '0000-00-00') {
        $birth_arr = explode('-', $answer['person']['birthdate']);
        $bitrhdate = $birth_arr[2] . '.' . $birth_arr[1] . '.' . $birth_arr[0];
    }
?>
        <div class="main-infoText__right">
            <div class="main-infoText__element">Дата рождения: <?=$bitrhdate?></div>
            <div class="main-infoText__element">Рост: <?=($answer['person']['growth'] ? $answer['person']['growth'] . ' см' : '-')?></div>
            <div class="main-infoText__element">Вес: <?=($answer['person']['weight'] ? $answer['person']['weight'] . ' кг' : '-')?></div>
            <div class="main-infoText__element">Город: <?=($answer['person']['city'] ? $answer['person']['city'] : '-')?></div>
        </div>
        <div class="main-infoText__left">
            <div class="main-infoText__title"><?=($answer['person']['surname'] . ' ' . $answer['person']['name'])?></div>
        </div>

    </div>
    <?if ($_SESSION['userID'] && ($_GET['person'] == $_SESSION['userPerson'])) {?>
        <a class="main-editLink" href="/?r=user/changepass&id=<?=$_GET['person']?>">Сменить пароль</a>
    <?}?>
    <?if (($_GET['person'] == $_SESSION['userPerson']) || ($_SESSION['userType'] == 3)) {?>
        <a class="main-editLink" href="/?r=person/edit&person=<?=$_GET['person']?>">Редактировать данные</a>
    <?}?>

</div>
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