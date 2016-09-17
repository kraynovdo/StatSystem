<form method="POST" enctype="multipart/form-data" action="/?r=team/update">
    <h3>Логотип</h3>
    <div class="main-file">
        <?if ($answer['team']['team']['logo']) {?>
            <img src="//<?=$HOST?>/upload/<?=$answer['team']['team']['logo']?>" class="main-file_miniature">
        <?} else {?>
            <div class="main-file_label">Добавить<br/>логотип<br/>(формат png)</div>
        <?}?>
        <input class="main-file_input" type="file" name="logo"/>
    </div>

    <h3 class="person-edit__title">Данные</h3>
    <div class="person-edit_block">
        <div class="person-edit_label">Русское название</div>
        <div class="person-edit_field"><input class="person-edit_city" name="rus_name" type="text" value="<?=$answer['team']['team']['rus_name']?>"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Сокращенное русское название (3 буквы)</div>
        <div class="person-edit_field"><input class="person-edit_city" name="rus_abbr" type="text" value="<?=$answer['team']['team']['rus_abbr']?>" maxlength="3"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Страна</div>
        <input name="geo_country" type="hidden" data-geo="country" value="<?=$answer['team']['team']['geo_country']?>"/>
        <div class="person-edit_field">
            <input autocomplete="off" class="geo-country person-edit_city" name="geo_countryTitle" value="<?=$answer['team']['team']['geo_countryTitle']?>" data-validate="geo" data-geo="country" type="text" placeholder="Страна *"/>
        </div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Регион</div>
        <input name="geo_region" type="hidden" data-geo="region" value="<?=$answer['team']['team']['geo_region']?>"/>
        <div class="person-edit_field">
            <input autocomplete="off" class="geo-region person-edit_city" name="geo_regionTitle" value="<?=$answer['team']['team']['geo_regionTitle']?>" data-validate="geo2" data-geo="region" type="text" placeholder="Регион" data-geo-country="country"/>
        </div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Город</div>
        <div class="person-edit_field"><input class="person-edit_city" name="city" type="text" value="<?=$answer['team']['team']['city']?>"></div>
    </div>

    <div class="person-edit_block">
        <div class="person-edit_label">E-mail</div>
        <div class="person-edit_field"><input class="person-edit_city" data-validate="email" name="email" type="text" value="<?=$answer['team']['team']['email']?>"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Ссылка Вконтакте</div>
        <div class="person-edit_field"><input class="person-edit_city" name="vk_link" type="text" value="<?=$answer['team']['team']['vk_link']?>"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Instagram</div>
        <div class="person-edit_field"><input class="person-edit_city" name="inst_link" type="text" value="<?=$answer['team']['team']['inst_link']?>"></div>
    </div>
    <div class="person-edit_block">
        <div class="person-edit_label">Twitter</div>
        <div class="person-edit_field"><input class="person-edit_city" name="twitter_link" type="text" value="<?=$answer['team']['team']['twitter_link']?>"></div>
    </div>

    <input type="hidden" name="team" value="<?=$_GET['team']?>"/>
    <input type="button" value="Сохранить" class="main-submit main-btn"/>
</form>