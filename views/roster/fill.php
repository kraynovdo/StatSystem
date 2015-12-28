<h1><?=$answer['team']?></h1>
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

            <input class="roster-citizenship_face_code" name="geo_country" type="hidden" data-geo="country" value="<?=$answer['person']['geo_country']?>"/>
            <input placeholder="Гражданство" autocomplete="off" class="roster-citizenship_face geo-country" data-validate="geo" data-geo="country" name="geo_countryTitle" type="text" value="<?=$answer['person']['geo_countryTitle']?>">

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

    <h2>Официальные лица</h2>
    <table class="datagrid roster-grid">
        <colgroup>
            <col/>
            <col/>
            <col/>
            <col width="80px"/>
            <col/>
            <col/>
            <col/>
            <col width="30px"/>
        </colgroup>
        <thead class="datagrid_thead">
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Д.Р.</th>
            <th>Гражданство</th>
            <th>Должность</th>
            <th>Телефон</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody class="datagrid_tbody">
        <?php for ($i = 0; $i < count($answer['face']); $i++) {?>
            <?
            if ($answer['face'][$i]['birthdate'] != '0000-00-00') {
                $birth_arr = explode('-', $answer['face'][$i]['birthdate']);
                $bitrhdate = $birth_arr[2] . '.' . $birth_arr[1] . '.' . $birth_arr[0];
            }
            ?>
            <tr>
                <td><?=$answer['face'][$i]['surname']?></td>
                <td><?=$answer['face'][$i]['name']?></td>
                <td><?=$answer['face'][$i]['patronymic']?></td>
                <td><?=$bitrhdate?></td>
                <td><?=$answer['face'][$i]['geo_countryTitle']?></td>
                <td><?=$answer['face'][$i]['facetype']?></td>
                <td><?=$answer['face'][$i]['phone']?></td>
                <td>
                    <a href="/?r=roster/deleteFace&face=<?=$answer['face'][$i]['id']?>">[X]</a>
                </td>
            </tr>
        <?}?>
        </tbody>
    </table>

<h2>Игроки</h2>
<table class="datagrid roster-grid">
    <colgroup>
        <?if ($_SESSION['userType'] == 3) {?>
            <col width="27px"/>
        <?}?>
        <col width="50px"/>
        <col/>
        <col/>
        <col/>
        <col width="80px"/>
        <col/>
        <col width="80px"/>
        <col width="60px"/>
        <col width="50px"/>
        <col width="50px"/>
        <col/>
        <col width="30px"/>

    </colgroup>
    <thead class="datagrid_thead">
        <tr>
            <?if ($_SESSION['userType'] == 3) {?>
                <th><span class="roster-confirm roster-confirm_1" href="javascript: void(0);"></span></th>
            <?}?>
            <th>№ п/п</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Д.Р.</th>
            <th>Гражданство</th>
            <th>№ игрока</th>
            <th>Позиция</th>
            <th>Рост (см.)</th>
            <th>Вес (кг.)</th>
            <th>Телефон</th>
            <th colspan="2">Управление</th>
        </tr>
    </thead>
    <tbody class="datagrid_tbody">
<?php for ($i = 0; $i < count($answer['roster']); $i++) {?>
<?
    if ($answer['roster'][$i]['birthdate'] != '0000-00-00') {
        $birth_arr = explode('-', $answer['roster'][$i]['birthdate']);
        $bitrhdate = $birth_arr[2] . '.' . $birth_arr[1] . '.' . $birth_arr[0];
    }
?>
    <tr>
        <?if ($_SESSION['userType'] == 3) {?>
            <td><a data-id="<?=$answer['roster'][$i]['id']?>" class="roster-confirm roster-confirm_<?=$answer['roster'][$i]['confirm']?>" href="javascript: void(0);"></a></td>
        <?}?>
        <td><?=$i+1?></td>
        <td><?=$answer['roster'][$i]['surname']?></td>
        <td><?=$answer['roster'][$i]['name']?></td>
        <td><?=$answer['roster'][$i]['patronymic']?></td>
        <td><?=$bitrhdate?></td>
        <td><?=$answer['roster'][$i]['geo_countryTitle']?></td>
        <td><?=$answer['roster'][$i]['number']?></td>
        <td><?=$answer['roster'][$i]['pos']?></td>
        <td><?=$answer['roster'][$i]['growth']?></td>
        <td><?=$answer['roster'][$i]['weight']?></td>
        <td><?=$answer['roster'][$i]['phone']?></td>
        <td class="roster-editTD">
            <? if (!$answer['roster'][$i]['confirm']) {?>
                <a title="Редактировать" href="/?r=roster/edit&roster=<?=$answer['roster'][$i]['id']?>">[Ред]</a>
            <?} else {?>
                &nbsp;
            <?}?>
        </td>
        <td class="roster-delTD">
            <? if (!$answer['roster'][$i]['confirm']) {?>
                <a title="Удалить" href="/?r=roster/delete&roster=<?=$answer['roster'][$i]['id']?>">[X]</a>
            <?} else {?>
                &nbsp;
            <?}?>
        </td>

    </tr>
<?}?>
    </tbody>
</table>
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
<a class='main-btn' target="_blank" href="/?r=roster/print&comp=<?=$_GET['comp']?>&team=<?=$_GET['team']?>">Вывод на печать</a>
<a class='main-btn' target="_blank" href="/?r=roster/printCards&comp=<?=$_GET['comp']?>&team=<?=$_GET['team']?>">Карточки</a>
<?if ($_SESSION['userType'] != 3) {?>
<a class='main-btn main-btn_important' href="/?r=roster/request&comp=<?=$_GET['comp']?>&team=<?=$_GET['team']?>">Отправить заявку</a>
<?}?>