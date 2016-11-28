<?
    $isover = false;
    if ($answer['compinfo']['reqdate']) {
        $reqtime = strtotime($answer['compinfo']['reqdate']) + 86400;
        if (time() > $reqtime) {
            $isover = true;
        }
    }
?>
<h1><?=$answer['team']?></h1>
    <?if (($_SESSION['userType'] == 3) || (!$isover) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
    <h2>Добавление <a href="javascript:void(0)" class="roster-addLink roster-addLink_player roster-addLink_active">игрока</a> <a href="javascript:void(0)" class="roster-addLink roster-addLink_face">официального лица</a></h2>
    <div class="roster-addPerson">
        <form class="roster-addForm" method="POST" action="/?r=roster/create" enctype="multipart/form-data">
            <div class="main-file roster-photo" data-validate>
                <div class="main-file_label">Добавить<br/>фотографию<br/>(формат jpeg)</div>
                <input class="main-file_input" type="file" name="avatar"/>
            </div>
            <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
            <input type="hidden" name="team" value="<?=$_GET['team']?>"/>
            <input type="hidden" name="person" value="" class="roster-person"/>
            <input type="text" name="surname" data-validate="req" class="roster-surname" placeholder="Фамилия"/>
            <input type="text" name="name" data-validate="req" class="roster-name" placeholder="Имя"/>
            <input type="text" name="patronymic" data-validate="req" class="roster-patronymic" placeholder="Отчество"/>
            <input type="text" name="birthdate" data-validate="date" class="roster-birthdate main-date" placeholder="Дата рожд."/>

            <input class="roster-citizenship_code" name="geo_country" type="hidden" data-geo="country" value="<?=$answer['person']['geo_country']?>"/>
            <input placeholder="Гражданство" autocomplete="off" class="roster-citizenship geo-country" data-validate="geo" data-geo="country" name="geo_countryTitle" type="text" value="<?=$answer['person']['geo_countryTitle']?>">

            <input type="text" name="number" class="roster-number" placeholder="№"/>
            <select name="pos" data-validate="req" class="roster-pos">
                <option value="">--</option>
                <?for ($j = 0; $j < count($answer['position']); $j++) {?>
                    <option value="<?=$answer['position'][$j]['id']?>"><?=$answer['position'][$j]['abbr']?></option>
                <?}?>
            </select>

            <input type="text" name="growth" data-validate="req" class="roster-growth" placeholder="Рост(см)"/>
            <input type="text" name="weight" data-validate="req" class="roster-weight" placeholder="Вес(кг)"/>
            <input type="text" name="phone" data-validate="phone" class="roster-phone" placeholder="Телефон"/>
            <div class="roster-submitContainer">
                <input type="button" class="roster-submit main-submit main-btn" value="Добавить">
                <input type="button" class="roster-clear main-btn" value="Очистить">
            </div>
        </form>
    </div>
    <div class="roster-addFace">
        <form class="roster-addForm" method="POST" action="/?r=roster/createFace" enctype="multipart/form-data">
            <div class="main-file roster-photo_face" data-validate>
                <div class="main-file_label">Добавить<br/>фотографию<br/>(формат jpeg)</div>
                <input class="main-file_input" type="file" name="avatar"/>
            </div>
            <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
            <input type="hidden" name="team" value="<?=$_GET['team']?>"/>
            <input type="hidden" name="person" value="" class="roster-person_face"/>
            <input type="text" name="surname" data-validate="req" class="roster-surname_face" placeholder="Фамилия"/>
            <input type="text" name="name" data-validate="req" class="roster-name_face" placeholder="Имя"/>
            <input type="text" name="patronymic" data-validate="req" class="roster-patronymic_face" placeholder="Отчество"/>
            <input type="text" name="birthdate" data-validate="date" class="roster-birthdate_face main-date" placeholder="Дата рожд."/>

            <input class="roster-citizenship_face_code" name="geo_country" type="hidden" data-geo="country_face" value="<?=$answer['person']['geo_country']?>"/>
            <input placeholder="Гражданство" autocomplete="off" class="roster-citizenship_face geo-country" data-validate="geo" data-geo="country_face" name="geo_countryTitle" type="text" value="<?=$answer['person']['geo_countryTitle']?>">

            <select name="facetype" data-validate="req" class="roster-facetype">
                <option value="">--</option>
                <?for ($j = 0; $j < count($answer['facetype']); $j++) {?>
                    <option value="<?=$answer['facetype'][$j]['id']?>"><?=$answer['facetype'][$j]['name']?></option>
                <?}?>
            </select>

            <input type="text" name="phone" data-validate="phone" class="roster-phone_face" placeholder="Телефон"/>
            <div class="roster-submitContainer">
                <input type="button" class="roster-submit main-submit main-btn" value="Добавить">
                <input type="button" class="roster-clear_face main-btn" value="Очистить">
            </div>
        </form>
    </div>
<?} else {?>
    <h3 class="main-warning">Период заявки игроков истек!</h3>
<?}?>
    <h2>Официальные лица</h2>

<div class="roster-list">
<?php for ($i = 0; $i < count($answer['face']); $i++) {?>
    <?
    $bitrhdate = '';
    if ($answer['face'][$i]['birthdate'] != '0000-00-00') {
        $bitrhdate = common_dateFromSQL($answer['face'][$i]['birthdate']);
    }
    ?>
    <div class="roster-itemFace roster-item">
        <span class="roster-itemFio roster-itemContent">
            <?=$answer['face'][$i]['surname']?>
            <?=$answer['face'][$i]['name']?>
            <?=$answer['face'][$i]['patronymic']?>
        </span>
        <span class="roster-itemDate roster-itemContent">
            <?=$bitrhdate?>
        </span>
        <?if ($IS_MOBILE){?>
            <br/>
        <?}?>
        <span class="roster-itemContent roster-itemWork">
            <?=$answer['face'][$i]['facetype']?>
        </span>


        <span class="roster-itemPhone roster-itemContent">
            <?=$answer['face'][$i]['phone']?>
        </span>
        <span class="roster-itemContent roster-itemCtrl">
            <a href="/?r=roster/editFace&face=<?=$answer['face'][$i]['id']?>">[Ред]</a>
            <a href="/?r=roster/deleteFace&face=<?=$answer['face'][$i]['id']?>">[X]</a>
        </span>
    </div>
<?}?>
</div>
<h2>Игроки</h2>

    <input type="checkbox" class="roster-choose_mainCheckbox"/>
<div class="roster-list">
<?php for ($i = 0; $i < count($answer['roster']); $i++) {?>
    <?
    $bitrhdate = '';
    if ($answer['roster'][$i]['birthdate'] != '0000-00-00') {
        $bitrhdate = common_dateFromSQL($answer['roster'][$i]['birthdate']);
    }
    ?>
    <div class="roster-item roster-row_confirm<?=$answer['roster'][$i]['confirm']?>" data-id="<?=$answer['roster'][$i]['id']?>">
        <span class="roster-itemContent roster-itemCheckbox">
            <input type="checkbox" class="roster-choose_checkbox"/>
        </span>

        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
            <span class="roster-itemContent roster-itemConfirm">
                <a class="roster-confirm roster-confirm_<?=$answer['roster'][$i]['confirm']?>" href="javascript: void(0);"></a>
            </span>
        <?}?>
        <span class="roster-itemContent"><?=$i+1?></span>
        <span class="roster-itemContent roster-itemFio">
            <?=$answer['roster'][$i]['surname']?>
            <?=$answer['roster'][$i]['name']?>
            <?=$answer['roster'][$i]['patronymic']?>
        </span>
        <span class="roster-itemContent"><?=$bitrhdate?></span>
        <span class="roster-itemContent"><?=$answer['roster'][$i]['geo_countryTitle']?></span>
        <span class="roster-itemContent"><?=$answer['roster'][$i]['number']?></span>
        <span class="roster-itemContent"><?=$answer['roster'][$i]['pos']?></span>
        <span class="roster-itemContent"><?=$answer['roster'][$i]['growth']?></span>
        <span class="roster-itemContent"><?=$answer['roster'][$i]['weight']?></span>
        <span class="roster-itemContent"><?=$answer['roster'][$i]['phone']?></span>
        <span class="roster-itemContent roster-editTD">
        	<a title="Редактировать" href="/?r=roster/edit&roster=<?=$answer['roster'][$i]['id']?>">[Ред]</a>
        </span>
        <span class="roster-itemContent roster-delTD">
            <? if (!$answer['roster'][$i]['confirm']) {?>
                <a title="Удалить" href="/?r=roster/delete&roster=<?=$answer['roster'][$i]['id']?>">[X]</a>
            <?} else {?>
                &nbsp;
            <?}?>
        </span>

    </div>
<?}?>
</div>
<br/>
<?
$comps = $answer['compsPast'];
if (count($comps) > 1 && !count($answer['roster'])) {
    ?>
    <h3 class="roster-autofill">Вы можете заполнить ростер автоматически по турниру
        <form method="POST" action="/?r=roster/autofill" class="roster-autoform">
            <input type="hidden" name="team" value="<?=$_GET['team']?>"/>
            <input type="hidden" name="compRet" value="<?=$_GET['comp']?>"/>
            <select name="comp" data-validate="req">
                <option value="">Выберите турнир</option>
                <?; for($i = 0; $i < count($comps); $i++) if ($comps[$i]['id'] != $_GET['comp']){ ?>
                    <option value="<?=$comps[$i]['id']?>"><?=$comps[$i]['name'] . ' ' . $comps[$i]['yearB']?></option>
                <?}?>
            </select>
            <input type="button" class="main-btn main-submit" value="Заполнить"/>
        </form>
    </h3>
<?}?>
<?if ($_SESSION['userType'] == 3) {?>
<a class='main-btn' target="_blank" href="/?r=roster/printCards&comp=<?=$_GET['comp']?>&team=<?=$_GET['team']?>">Карточки (для проверки фото)</a>
<?}?>
<a class='main-btn' target="_blank" href="/?r=roster/print&comp=<?=$_GET['comp']?>&team=<?=$_GET['team']?>">Печать</a>
<a class='main-btn roster-printChooseLink main-hidden' target="_blank" href="/?r=roster/print&comp=<?=$_GET['comp']?>&team=<?=$_GET['team']?>">Печать выбранных</a>

<?if (($_SESSION['userType'] != 3) && ($_SESSION['userComp'][$_GET['comp']] != 1)) {?>
<a class='main-btn main-btn_important' href="/?r=roster/request&comp=<?=$_GET['comp']?>&team=<?=$_GET['team']?>">Отправить заявку</a>
<?}?>