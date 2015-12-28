<h2>Добавление лица</h2>
<form method="post" action="/?r=userfederation/create" class="federation-formPerson">
    <input type="hidden" name="federation" value="<?=$_GET['federation']?>"/>
    <div class="main-fieldWrapper">
        <input type="text" name="d_fio" class="federation-field federation-surname_d" data-validate="req" placeholder="Фамилия"/>
    </div>
    <div class="main-fieldWrapper">
        <input type="text" name="d_name" class="federation-field federation-name_d" data-validate="req" placeholder="Имя"/>
    </div>
    <div class="main-fieldWrapper">
        <input type="text" name="d_patr" class="federation-field federation-patr_d" data-validate="req" placeholder="Отчество"/>
    </div>
    <div class="main-fieldWrapper">
        <input type="text" name="d_date" class="main-date federation-date_d" data-validate="date" placeholder="Дата рожд"/>
        <input type="text" name="d_phone" class="federation-field_small federation-phone_d" data-validate="phone" placeholder="Телефон"/>
        <a class="federation-person_clear federation-person_cleard" href="javascript: void(0)">Очистить</a>
    </div>
    <input type="hidden" name="d_id" class="federation-id_d"/>
    <div class="main-fieldWrapper">
        <label>
            Права доступа
            <select name="type">
                <option value="1">Администратор</option>
                <option value="2" selected="selected">Пользователь</option>
            </select>
        </label>
    </div>
    <div class="main-fieldWrapper">
        <label>
            <input type="checkbox" name="isEmployee" class="federation-empFlag"/>
            Является сотрудником
        </label>
    </div>
    <div class="main-fieldWrapper federation-workField">
        <input type="text" name="work" class="federation-field federation-fieldWork" value=" " data-validate="req" placeholder="Должность"/>
    </div>
    <div class="main-fieldWrapper">
        <input type="button" class="main-btn main-submit" value="Добавить"/>
    </div>
</form>
