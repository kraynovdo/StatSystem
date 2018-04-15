<form method="POST" enctype="multipart/form-data" action="/?r=organization/update">
    <h3>Логотип</h3>
    <div class="main-file">
        <?if ($answer['org']['logo']) {?>
            <img src="//<?=$HOST?>/upload/<?=$answer['org']['logo']?>" class="main-file_miniature">
        <?} else {?>
            <div class="main-file_label">Добавить<br/>логотип<br/>(формат png)</div>
        <?}?>
        <input class="main-file_input" type="file" name="logo"/>
    </div>

    <h3 class="person-edit__title">Данные</h3>

    <div class="main-fieldWrapper">
        <label class="main-label_top">Название</label>
        <input class="org-edit_name" type="text" name="name" value="<?=$answer['org']['name']?>"/>
    </div>

    <div class="main-fieldWrapper">
        <label class="main-label_top">Описание</label>
        <textarea class="org-edit_name" type="text" name="desc" rows="8"><?=$answer['org']['desc']?></textarea>
    </div>

    <div class="main-fieldWrapper">
        <label class="main-label_top">Телефон</label>
        <input class="org-edit_name" type="text" name="phone" data-validate="phone" value="<?=$answer['org']['phone']?>"/>
    </div>

    <div class="main-fieldWrapper">
        <label class="main-label_top">E-mail</label>
        <input class="org-edit_name" type="text" name="email" data-validate="email" value="<?=$answer['org']['email']?>"/>
    </div>

    <div class="main-fieldWrapper">
        <label class="main-label_top">Адрес</label>
        <input class="org-edit_name" type="text" name="address" value="<?=$answer['org']['address']?>"/>
    </div>

    <input type="hidden" name="org" value="<?=$_GET['org']?>"/>
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <input type="hidden" name="ret" value="<?=$_GET['ret']?>"/>
    <input type="button" value="Сохранить" class="main-submit main-btn"/>
</form>