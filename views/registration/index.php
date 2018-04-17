<div class="fafr-minWidth fafr-maxWidth">
    <form method="POST" enctype="multipart/form-data" action="/?r=registration/reg">
        <div class="reg-leftCol">
            <h3>Аватар</h3>
            <div class="main-file">
                <div class="main-file_label">Добавить<br/>фотографию<br/>(формат jpeg)</div>
                <input class="main-file_input" type="file" name="avatar"/>
            </div>
        </div>
        <div class="reg-rightCol">
            <input type="checkbox" class="reg-referree" id="referee" name="referee"/><label for="referee" class="reg-referree_link">Я судья</label>
            <span>(ставите галку если собираетесь участвовать в судействе матчей)</span>
            <div class="reg-block reg-block_referree">
                <div class="reg-firstList">
                    <select class="reg-exp reg-field" name="exp">
                        <?
                        $year = date("Y") - 1;
                        echo "<option>Опыт судейства</option>";
                        while($year >= 1990) {
                            echo "<option value=" . $year . ">с ". $year." года</option>";
                            $year--;
                        }
                        ?>
                    </select>
                </div>
                <div class="reg-secondList">
                    <select class="reg-expplay reg-field" name="expplay">
                        <?
                        $year = date("Y") - 1;
                        echo "<option>Опыт игры в американский футбол</option>";
                        while($year >= 1990) {
                            echo "<option value=" . $year . ">с ". $year." года</option>";
                            $year--;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="reg-block reg-block_main">
                <h3>Основные данные</h3>
                <div class="reg-firstList reg-list_main">
                    <input class="reg-surname reg-field" data-validate="req" name="surname" type="text" placeholder="Фамилия *"/>
                    <input class="reg-name reg-field" data-validate="req" name="name" type="text" placeholder="Имя *"/>
                    <input class="reg-patr reg-field" data-validate="req" name="patronymic" type="text" placeholder="Отчество *"/>
                    <input class="reg-date main-date reg-field" data-validate="date" name="birthdate"  type="text" placeholder="Дата рождения *"/>
                </div>
                <div class="reg-secondList reg-list_main">
                    <input name="geo_country" type="hidden" data-geo="country" class="reg-countryCode"/>
                    <input autocomplete="off" class="reg-citizenship reg-field geo-country" name="geo_countryTitle" data-validate="geo" data-geo="country" type="text" placeholder="Гражданство *"/>
                    <input class="reg-phone reg-field" data-validate="phone" name="phone" type="text" placeholder="Мобильный телефон *"/>
                    <input class="reg-vk reg-field" name="vk_link" type="text" placeholder="Ссылка на страницу ВК"/>
                    <input class="reg-skype reg-field" name="skype" type="text" placeholder="Скайп"/>
                </div>
            </div>
            <div class="reg-block reg-block_antr">
                <h3>Антропометрические данные</h3>
                <div class="reg-firstList">
                    <input class="reg-growth reg-field" name="growth" type="text" placeholder="Рост"/>
                </div>
                <div class="reg-secondList">
                    <input class="reg-weight reg-field" name="weight" type="text" placeholder="Вес"/>
                </div>
            </div>

            <div class="reg-block reg-block_enter">
                <h3>Вход на сайт</h3>
                <div class="reg-firstList">
                    <input class="reg-email reg-field" data-validate="email" name="email" type="text" placeholder="Электронная почта"/>
                </div>
                <div class="reg-secondList">
                    <input class="reg-pass reg-field main-password" data-validate="req" name="password" type="password" placeholder="Придумайте пароль"/>
                    <input class="reg-pass reg-field" data-validate="password" name="passworConfirm" type="password" placeholder="Введите пароль еще раз"/>
                </div>
            </div>
        </div>
        <input type="hidden" name="person" class="reg-person"/>
        <input type="hidden" name="newEmail" class="reg-newEmail"/>
        <input type="checkbox" name="imnothuman" class="reg-humanCheckbox"/>
        <input type="hidden" name="personEmail" class="reg-personEmail"/>
        <input type="button" class="main-btn reg-submit" value="Готово"/>
    </form>
</div>