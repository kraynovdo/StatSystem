<h3>Основные данные</h3>
<div class="main-file federation-logo">
    <?if ($federation['logo']) {?>
        <img src="//<?=$HOST?>/upload/<?=$federation['logo']?>" class="main-file_miniature">
    <?} else {?>
        <div class="main-file_label">Добавить<br/>логотип<br/>(формат png)</div>
    <?}?>
    <input class="main-file_input" type="file" name="logo"/>
</div>
<div class="main-fieldWrapper">
    <label class="main-label_top">Полное название организации</label>
    <input class="federation-field" type="text" name="fullname" data-validate="req" value='<?=$federation['fullname']?>'/>
</div>
<div class="main-fieldWrapper">
    <label class="main-label_top">Сокращенное название не более 10 символов</label>
    <input class="federation-field federation-field_small" type="text" name="name" maxlength="10" data-validate="req" value="<?=$federation['name']?>"/>
</div>
<div class="main-fieldWrapper">
    <label class="main-label_top">E-mail</label>
    <input class="federation-field federation-field" type="text" name="email" data-validate="email" value="<?=$federation['email']?>"/>
</div>