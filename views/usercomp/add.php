<h2>Добавление лица</h2>
<form method="post" action="/?r=usercomp/create" class="federation-formPerson" enctype="multipart/form-data">
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <input type="hidden" name="ret" value="<?=$_GET['ret']?>"/>
    <input type="hidden" name="group" value="1"/>
    <div class="main-file roster-photo" data-validate>
        <div class="main-file_label">Добавить<br/>фотографию<br/>(формат jpeg)</div>
        <input class="main-file_input" type="file" name="avatar"/>
    </div>
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
        <input type="text" name="work" class="federation-field federation-fieldWork" data-validate="req" placeholder="Должность"/>
    </div>
    <div class="main-fieldWrapper">
        <input type="button" class="main-btn main-submit" value="Добавить"/>
    </div>
</form>
