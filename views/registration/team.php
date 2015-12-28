<h2>Регистрация команды</h2>
<form method="POST" enctype="multipart/form-data" action="/?r=registration/regteam">
    <div class="reg-leftCol">
        <h3>Логотип</h3>
        <div class="main-file">
            <div class="main-file_label">Добавить логотип<br/>(формат png)</div>
            <input class="main-file_input" type="file" name="logo"/>
        </div>
        <div class="main-file main-file_simple reg-teamlogo_v">
            <div class="main-file_label">Добавить логотип<br/>в векторе</div>
            <input class="main-file_input" type="file" name="vect_logo"/>
        </div>
    </div>
    <div class="reg-rightCol">

        <div class="reg-block reg-block_main">
            <h3>Данные</h3>
            <div class="reg-firstList reg-list_main">
                <input class="reg-surname reg-field" data-validate="rus" name="rus_name" type="text" placeholder="Название команды (rus)"/>
                <input class="reg-surname reg-field" data-validate="eng" name="name" type="text" placeholder="Название команды (eng)"/>
                <input name="geo_country" type="hidden" data-geo="country" class="reg-countryCode"/>
                <input autocomplete="off" class="reg-field geo-country" name="geo_countryTitle" data-validate="geo" data-geo="country" type="text" placeholder="Страна *"/>
                <input name="geo_region" type="hidden" data-geo="region"/>
                <input autocomplete="off" class="geo-region reg-field" name="geo_regionTitle" data-validate="geo2" data-geo="region" type="text" placeholder="Регион" data-geo-country="country"/>
                <input class="reg-city reg-field" data-validate="req" name="city"  type="text" placeholder="Город *"/>
                <select name="org_form" data-validate="req" class="reg-field">
                    <option value="">--Организационно-правовая форма</option>
                    <?for ($j = 0; $j < count($answer['opf']); $j++) {?>
                        <option value="<?=$answer['opf'][$j]['id']?>"><?=$answer['opf'][$j]['name']?></option>
                    <?}?>
                </select>
                <select name="sport" data-validate="req" class="reg-field">
                    <option value="">--Вид спорта</option>
                    <?for ($j = 0; $j < count($answer['sport']); $j++) {?>
                        <option value="<?=$answer['sport'][$j]['id']?>"><?=$answer['sport'][$j]['name']?></option>
                    <?}?>
                </select>
                <select name="sex" data-validate="req" class="reg-field">
                    <option value="">--Пол игроков</option>
                    <option value="1">Мужской</option>
                    <option value="2">Женский</option>
                </select>
                <select name="age" data-validate="req" class="reg-field">
                    <option value="">--Возраст игроков</option>
                    <?for ($j = 0; $j < count($answer['age']); $j++) {?>
                        <option value="<?=$answer['age'][$j]['id']?>"><?=$answer['age'][$j]['name']?></option>
                    <?}?>
                </select>
            </div>
            <div class="reg-secondList reg-list_main">
                <input class="reg-email reg-field" data-validate="email" name="email" type="text" placeholder="Электронная почта"/>
                <input class="reg-vk reg-field" name="vk_link" type="text" placeholder="Ссылка на страницу ВК"/>
                <input class="reg-email reg-field" name="inst_link" type="text" placeholder="Instagram"/>
                <input class="reg-vk reg-field" name="twitter_link" type="text" placeholder="Twitter"/>
                <div class="main-file main-file_simple reg-teamOGRN">
                    <div class="main-file_label">Загрузить<br/>свидетельство ОГРН</div>
                    <input class="main-file_input" type="file" name="ogrn_doc"/>
                </div>
            </div>
        </div>
    </div>
    <input type="button" class="main-btn main-submit" value="Готово"/>
</form>