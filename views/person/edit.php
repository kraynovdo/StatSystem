<h2><?=($answer['person']['surname'] . ' ' . $answer['person']['name'] . ' ' . $answer['person']['patronymic'])?></h2>
<?
    $birthdate = '-';
    if ($answer['person']['birthdate'] != '0000-00-00') {
        $birth_arr = explode('-', $answer['person']['birthdate']);
        $birthdate = $birth_arr[2] . '.' . $birth_arr[1] . '.' . $birth_arr[0];
    }
?>

<form method="POST" enctype="multipart/form-data" action="/?r=person/update">
    <h3>Фотография</h3>
    <div class="main-file">
        <?if ($answer['person']['avatar']) {?>
            <img src="//<?=$HOST?>/upload/<?=$answer['person']['avatar']?>" class="main-file_miniature">
        <?} else {?>
            <div class="main-file_label">Добавить<br/>фотографию<br/>(формат jpeg)</div>
        <?}?>
        <input class="main-file_input" type="file" name="avatar"/>
    </div>
    <h3 class="person-edit__title">Личные данные</h3>
    <div class="person-edit_block">
        <div class="person-edit_label">Дата рождения</div>
        <div class="person-edit_field"><input class="person-edit_birth main-date" data-validate="date" name="birthdate" type="text" value="<?=$birthdate?>"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Рост, см</div>
        <div class="person-edit_field"><input class="person-edit_growth" name="growth" type="text" maxlength="3" value="<?=$answer['person']['growth']?>"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Вес, кг</div>
        <div class="person-edit_field"><input class="person-edit_weight" name="weight" type="text" maxlength="3" value="<?=$answer['person']['weight']?>"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Гражданство (страна)</div>
        <input name="geo_country" type="hidden" data-geo="country" value="<?=$answer['person']['geo_country']?>"/>
        <div class="person-edit_field"><input autocomplete="off" class="person-edit_citizenship geo-country" data-validate="geo" data-geo="country" name="geo_countryTitle" type="text" value="<?=$answer['person']['geo_countryTitle']?>"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Регион</div>
        <input name="geo_region" type="hidden" data-geo="region" value="<?=$answer['person']['geo_region']?>"/>
        <div class="person-edit_field">
            <input autocomplete="off" class="geo-region person-edit_citizenship" name="geo_regionTitle" data-validate="geo2" data-geo="region" type="text" placeholder="Регион" data-geo-country="country"  value="<?=$answer['person']['geo_regionTitle']?>"/>
        </div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Город</div>
        <div class="person-edit_field"><input class="person-edit_city" name="city" type="text" value="<?=$answer['person']['city']?>"></div>
    </div>
    <h3 class="person-edit__title">Контакты</h3>
    <div class="person-edit_block">
        <div class="person-edit_label">Телефон</div>
        <div class="person-edit_field"><input class="person-edit_phone" name="phone" type="text" data-validate="phone" maxlength="15" value="<?=$answer['person']['phone']?>">
            Другие пользователи не будут видеть ваш номер телефона</div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Skype</div>
        <div class="person-edit_field"><input class="person-edit_skype" name="skype" type="text" value="<?=$answer['person']['skype']?>"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Профиль ВКонтакте</div>
        <div class="person-edit_field"><input class="person-edit_vklink" name="vk_link" type="text" value="<?=$answer['person']['vk_link']?>"></div>
    </div>
    <input type="hidden" name="person" value="<?=$_GET['person']?>"/>
    <input type="button" value="Сохранить" class="main-submit main-btn"/>
</form>