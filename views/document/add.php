<h2>Добавление документа</h2>
<form action="/?r=document/create" method="post" enctype="multipart/form-data">
    <div class="main-fieldWrapper">
        <label class="main-label_top">Заголовок</label>
        <input class="document-field" type="text" name="title" data-validate="req"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Файл</label>
        <input class="document-field" type="file" name="link" data-validate="req"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Дата</label>
        <input type="text" class="main-date" name="date" data-validate="date" value="<?=common_dateFromSQL(date('Y-m-d'))?>" />
    </div>
    <input type="hidden" name="federation" value="<?=$_GET['federation']?>"/>
    <div class="main-fieldWrapper">
        <input type="button" class="main-btn main-submit" value="Готово"/>
    </div>
</form>