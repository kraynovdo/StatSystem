<h2>Редактирование официального лица</h2>
<?if (count($answer['face'])) {?>
    <h3><?=$answer['face']['surname'] . ' ' . $answer['face']['name'] . ' ' .$answer['face']['patronymic'] ?></h3>
    <form action="/?r=roster/updateFace" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="face" value="<?=$_GET['face']?>"/>
        <input type="hidden" name="person" value="<?=$answer['face']['personid']?>"/>
        Фото
        <div class="main-file roster-photo">
            <?if ($answer['face']['avatar']) {?>
                <img src="//<?=$HOST?>/upload/<?=$answer['face']['avatar']?>" class="main-file_miniature">
            <?} else {?>
                <div class="main-file_label">Добавить<br/>фотографию<br/>(формат jpeg)</div>
            <?}?>
            <input class="main-file_input" type="file" name="avatar"/>
        </div>
        Гражданство
        <div class="person-edit_block">
            <input name="geo_country" type="hidden" data-geo="country" value="<?=$answer['face']['geo_country']?>"/>
            <input placeholder="Гражданство" autocomplete="off" class="roster-citizenship_face geo-country" data-validate="geo" data-geo="country" name="geo_countryTitle" type="text" value="<?=$answer['face']['geo_countryTitle']?>">
        </div>

        Должность
        <div class="person-edit_block">
            <select name="facetype" data-validate="req">
                <option value="">--</option>
                <?for ($j = 0; $j < count($answer['facetype']); $j++) {?>
                    <?
                    $selected = '';
                    if ($answer['facetype'][$j]['id'] == $answer['face']['facetype']) {
                        $selected = ' selected="selected"';
                    }
                    ?>
                    <option value="<?=$answer['facetype'][$j]['id']?>"<?=$selected?>><?=$answer['facetype'][$j]['name']?></option>
                <?}?>
            </select>
        </div>


        Телефон
        <div class="person-edit_block">
            <input type="text" name="phone" data-validate="phone" class="roster-phone" placeholder="Телефон" value="<?=$answer['face']['phone']?>"/>
        </div>
        <input type="button" class="main-submit main-btn" value="Сохранить">
        <a href="/?r=roster/fill&comp=<?=$answer['bind']['comp']?>&team=<?=$answer['bind']['team']?>">Отмена</a>
    </form>
<?} else {?>
    Персона не найдена
<?}?>