<h2>Редактирование ростера</h2>
<?if (count($answer['roster'])) {?>
<h3><?=$answer['roster']['surname'] . ' ' . $answer['roster']['name'] . ' ' .$answer['roster']['patronymic'] ?></h3>
<form action="/?r=roster/update" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="roster" value="<?=$_GET['roster']?>"/>
    <input type="hidden" name="person" value="<?=$answer['roster']['personid']?>"/>
    Фото
    <div class="main-file roster-photo">
        <?if ($answer['roster']['avatar']) {?>
            <img src="//<?=$HOST?>/upload/<?=$answer['roster']['avatar']?>" class="main-file_miniature">
        <?} else {?>
            <div class="main-file_label">Добавить<br/>фотографию<br/>(формат jpeg)</div>
        <?}?>
        <input class="main-file_input" type="file" name="avatar"/>
    </div>
    Гражданство
    <div class="person-edit_block">
        <input name="geo_country" type="hidden" data-geo="country" value="<?=$answer['roster']['geo_country']?>"/>
        <input placeholder="Гражданство" autocomplete="off" class="roster-citizenship_face geo-country" data-validate="geo" data-geo="country" name="geo_countryTitle" type="text" value="<?=$answer['roster']['geo_countryTitle']?>">
    </div>
    №
    <div class="person-edit_block">
        <input type="text" name="number" class="roster-number" placeholder="№" value="<?=$answer['roster']['number']?>"/>
    </div>

    Позиция
    <div class="person-edit_block">
        <select name="pos" data-validate="req" class="roster-pos">
            <option value="">--</option>
            <?for ($j = 0; $j < count($answer['position']); $j++) {?>
                <?
                    $selected = '';
                    if ($answer['position'][$j]['id'] == $answer['roster']['position']) {
                        $selected = ' selected="selected"';
                    }
                ?>
                <option value="<?=$answer['position'][$j]['id']?>"<?=$selected?>><?=$answer['position'][$j]['abbr']?></option>
            <?}?>
        </select>
    </div>

    Рост(см)/Вес(кг)
    <div class="person-edit_block">
        <input type="text" name="growth" data-validate="req" class="roster-growth" placeholder="Рост(см)" value="<?=$answer['roster']['growth']?>"/>
        <input type="text" name="weight" data-validate="req" class="roster-weight" placeholder="Вес(кг)" value="<?=$answer['roster']['weight']?>"/>
    </div>
    Телефон
    <div class="person-edit_block">
        <input type="text" name="phone" data-validate="phone" class="roster-phone" placeholder="Телефон" value="<?=$answer['roster']['phone']?>"/>
    </div>
    <input type="button" class="main-submit main-btn" value="Сохранить">
    <a href="/?r=roster/fill&comp=<?=$answer['bind']['comp']?>&team=<?=$answer['bind']['team']?>">Отмена</a>
</form>
<?} else {?>
    Персона не найдена
<?}?>