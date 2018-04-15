<?if (count($answer['federation'])) {?>
<div class="federation-columns">
    <div class="federation-logo">
        <?if ($answer['federation']['logo']) {?>
            <img style="width:100%" src="//<?=$HOST?>/upload/<?=$answer['federation']['logo']?>">
        <?} else {?>
            <div class="main-noPhoto">?</div>
        <?}?>
    </div>
    <div class="federation-mainInfo">
        <?
        $type = array(
            1 => 'Международная',
            2 => 'Национальная',
            3 => 'Межрегиональная',
            4 => 'Региональная'
        )
        ?>
        <div class="main-fieldWrapper main-bigText">
            <?=$type[$answer['federation']['type']]?> федерация
        </div>
        <div class="main-fieldWrapper main-bigText">
            <?=$answer['federation']['fullname']?>
        </div>
        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {?>
            <a href="/?r=federation/edit&federation=<?=$_GET['federation']?>">[Редактировать]</a>
        <?}?>
    </div>
</div>
<h2>Контакты</h2>
<?if ($answer['federation']['email']) {?>
    <div class="main-fieldWrapper">
        E-mail - <?=$answer['federation']['email']?>
    </div>
<?}?>
<?if ($answer['federation']['vk_link']) {?>
    <div class="main-fieldWrapper">
        Вконтакте - <a target="_blank" href="<?=$answer['federation']['vk_link']?>"><?=$answer['federation']['vk_link']?></a>
    </div>
<?}?>
<?if ($answer['federation']['inst_link']) {?>
    <div class="main-fieldWrapper">
        Instagram - <a target="_blank" href="<?=$answer['federation']['inst_link']?>"><?=$answer['federation']['inst_link']?></a>
    </div>
<?}?>
<?if ($answer['federation']['twitter']) {?>
    <div class="main-fieldWrapper">
        Twitter - <a target="_blank" href="<?=$answer['federation']['twitter']?>"><?=$answer['federation']['twitter']?></a>
    </div>
<?}?>
<?
    $addr = array();
    array_push ($addr, $answer['federation']['country']);
    array_push ($addr, $answer['federation']['region']);
    array_push ($addr, $answer['federation']['city']);
    if ($answer['federation']['street']) {
        array_push ($addr, $answer['federation']['street']);
    }
    if ($answer['federation']['house']) {
        array_push ($addr, $answer['federation']['house']);
    }
    if ($answer['federation']['corpse']) {
        array_push ($addr, 'к(лит) '.$answer['federation']['corpse']);
    }
    if ($answer['federation']['flat']) {
        array_push ($addr, 'кв(оф) '.$answer['federation']['flat']);
    }

?>

<div class="main-fieldWrapper">
    Адрес - <?=implode(', ', $addr)?>
</div>
<?$userfederation = $answer['userfederation'];?>
<h2>Официальные лица</h2>
<?if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {?>
    <a href="/?r=userfederation/add&ret=federation/view&federation=<?=$_GET['federation']?>" class="main-addLink">Добавить</a>
<?}?>
<?for ($i = 0; $i < count($userfederation); $i++) {?>
    <?if (($userfederation[$i]['work']) || ($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']])) {?>
        <div class="listview-item<?if (!$userfederation[$i]['work']){?> federation-itemUser<?}?>">
        <span class="federation-itemWork">
            <?=$userfederation[$i]['work']?> -
        </span>
            <?=$userfederation[$i]['surname'] . ' ' . $userfederation[$i]['name'] . ' ' . $userfederation[$i]['patronymic']?>
            <?
            $contArr = array();
            if ($userfederation[$i]['phone']) {
                array_push($contArr, 'тел: '.$userfederation[$i]['phone']);
            }
            if ($userfederation[$i]['email']) {
                array_push($contArr, 'e-mail: '.$userfederation[$i]['email']);
            }
            ?>
            (<?=implode($contArr, ', ')?>)
            <?if ((($_SESSION['userType'] == 3)) || (($_SESSION['userFederations'][$_GET['federation']] == 1)) && $userfederation[$i]['person'] != $_SESSION['userPerson']) {?>
                <a class="main-delLink" href="/?r=userfederation/delete&ret=federation/view&uf=<?=$userfederation[$i]['uf']?>&federation=<?=$_GET['federation']?>">[X]</a>
            <?}?>
        </div>
    <?}?>
<?}?>
<?if ($answer['federation']['type'] == 1) {?>
    <h2>Состав федерации</h2>
    <div class="federation-listPart">
        <?for ($i = 0; $i < count($answer['countries']); $i++) {?>
            <div class="listview-item">
               <?=$answer['countries'][$i]['name']?>
            </div>
        <?}?>
        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {?>
            <a class="federation-partAddLink" href="javascript: void(0)">Добавить</a>
            <form class="federation-partAddForm" action="/?r=federation/createCountry" method="post">
                <input name="federation" type="hidden" value="<?=$_GET['federation']?>"/>
                <div class="main-fieldWrapper">
                    <input name="geo_country" type="hidden" data-geo="country" class="federation-countryid"/>
                    <input autocomplete="off" class="geo-country federation-country federation-field" name="geo_countryTitle" data-validate="geo" data-geo="country" type="text" placeholder="Страна"/>
                    <input type="button" class="main-btn main-submit" value="ок"/>
                </div>

            </form>
        <?}?>
    </div>
<?}?>
<?if ($answer['federation']['type'] == 3) {?>
    <h2>Состав федерации</h2>
    <div class="federation-listPart">
        <?for ($i = 0; $i < count($answer['regions']); $i++) {?>
            <div class="listview-item">
                <?=$answer['regions'][$i]['name']?>
            </div>
        <?}?>
        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {?>
            <a class="federation-partAddLink" href="javascript: void(0)">Добавить</a>
            <form class="federation-partAddForm" action="/?r=federation/createRegion" method="post">
                <input name="federation" type="hidden" value="<?=$_GET['federation']?>"/>
                <input name="geo_country" type="hidden" data-geo="country" class="federation-countryid" value="<?=$answer['federation']['geo_country']?>"/>
                <div class="main-fieldWrapper">
                    <input name="geo_region" type="hidden" data-geo="region" class="federation-regionid" />
                    <input autocomplete="off"  class="geo-region federation-region federation-field" name="geo_regionTitle" data-validate="geo2" data-geo="region" type="text" placeholder="Регион" data-geo-country="country"/>
                    <input type="button" class="main-btn main-submit" value="ок"/>
                </div>

            </form>
        <?}?>

    </div>
<?}?>
<?} else {?>
    Федерация не найдена
<?}?>