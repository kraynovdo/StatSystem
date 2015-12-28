<?$federation = array();?>
<h2>Добавление федерации</h2>
<form action="/?r=federation/create" method="post" enctype="multipart/form-data">
    <div class="main-editBlock" style="display: block" data-block="1">
        <? include '_maininfo.php'?>
        <input type="button" class="main-btn main-editButton_f" value="Далее" data-block="2"/>
    </div>
    <div class="main-editBlock" data-block="2">
        <? include '_addr.php'?>
        <input type="button" class="main-btn main-editButton_b" value="Назад" data-block="1"/>
        <input type="button" class="main-btn main-editButton_f federation-step3" value="Далее" data-block="3"/>
    </div>

    <div class="main-editBlock" data-block="3">
        <div class="main-fieldWrapper">
            <label class="main-label_top" for="type">Статус федерации</label>
            <select class="federation-field federation-field_small federation-type" name="type" data-validate="req">
                <option value="1">Международная</option>
                <option value="2">Национальная</option>
                <option value="3">Межрегиональная</option>
                <option value="4">Региональная</option>
            </select>
        </div>
        <div class="federation-partBlock federation-partBlock1">
            <h3>Страны в составе федерации</h3>
            <div class="main-fieldWrapper main-fieldWrapper_1country">
                <div class="listview-item">
                    <input class="federation-1countryid" name="geo_countryP[]" type="hidden"/>
                    <input class="federation-1country" name="geo_countryTitleP[]" type="hidden"/>
                    <span class="federation-partTitle federation-1countryTitle"></span>
                </div>
            </div>
            <div class="main-fieldWrapper main-fieldWrapper_2country">
                <input class="federation-2countryid" type="hidden" data-geo="country1"/>
                <input autocomplete="off" class="federation-2country geo-country federation-field" data-geo="country1" type="text" placeholder="Страна"/>
                <input type="button" class="main-btn federation-add_country" value="Добавить"/>
            </div>
        </div>
        <div class="federation-partBlock federation-partBlock2">
            <h3></h3>
            <div class="main-fieldWrapper main-fieldWrapper_1region">
                <div class="listview-item">
                    <input class="federation-1regionid" name="geo_regionP[]" type="hidden"/>
                    <input class="federation-1region" name="geo_regionTitleP[]" type="hidden"/>
                    <span class="federation-partTitle federation-1regionTitle"></span>
                </div>
            </div>
            <div class="main-fieldWrapper main-fieldWrapper_2region">
                <input class="federation-2regionid" type="hidden" data-geo="region1"/>
                <input autocomplete="off" class="federation-2region geo-region federation-field" data-geo="region1" type="text" placeholder="Регион" data-geo-country="country"/>
                <input type="button" class="main-btn federation-add_region" value="Добавить"/>
            </div>

        </div>
        <input type="button" class="main-btn main-editButton_b" value="Назад" data-block="2"/>
        <input type="button" class="main-btn federation-step4" value="Далее"/>
    </div>
    <div class="main-editBlock" data-block="4">
        <h3>Должностные лица</h3>
        <div class="main-fieldWrapper">
            <label for="d_fio">Руководитель федерации</label>
            <input type="text" name="d_fio" class="federation-field_small federation-surname_d" data-validate="req" placeholder="Фамилия"/>
            <input type="text" name="d_name" class="federation-field_small federation-name_d" data-validate="req" placeholder="Имя"/>
            <input type="text" name="d_patr" class="federation-field_small federation-patr_d" data-validate="req" placeholder="Отчество"/>
            <input type="text" name="d_date" class="main-date federation-date_d" data-validate="date" placeholder="Дата рожд"/>
            <input type="text" name="d_phone" class="federation-field_small federation-phone_d" data-validate="phone" placeholder="Телефон"/>
            <input type="hidden" name="d_id" class="federation-id_d"/>
            <a class="federation-person_clear federation-person_cleard" href="javascript: void(0)">[X]</a>
        </div>
        <div class="main-fieldWrapper">
            <label for="d_fio">Администратор федерации</label>
            <input type="text" name="a_fio" class="federation-field_small federation-surname_a" data-validate="req" placeholder="Фамилия"/>
            <input type="text" name="a_name" class="federation-field_small federation-name_a" data-validate="req" placeholder="Имя"/>
            <input type="text" name="a_patr" class="federation-field_small federation-patr_a" data-validate="req" placeholder="Отчество"/>
            <input type="text" name="a_date" class="main-date federation-date_a" data-validate="date" placeholder="Дата рожд"/>
            <input type="text" name="a_phone" class="federation-field_small federation-phone_a" data-validate="phone" placeholder="Телефон"/>
            <input type="hidden" name="a_id" class="federation-id_a"/>
            <a class="federation-person_clear federation-person_cleara" href="javascript: void(0)">[X]</a>
        </div>
        <input type="button" class="main-btn main-editButton_b" value="Назад" data-block="3"/>
        <input type="button" class="main-btn main-submit roster-submit" value="Готово"/>
    </div>
</form>