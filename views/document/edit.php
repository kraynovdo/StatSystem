<h2>Редактирование документа</h2>
<form action="/?r=document/update" method="post">
    <div class="main-fieldWrapper">
        <label class="main-label_top">Заголовок</label>
        <input class="document-field" type="text" name="title" data-validate="req" value="<?=$answer['title']?>"/>
    </div>
    <input type="hidden" name="federation" value="<?=$_GET['federation']?>"/>
    <input type="hidden" name="doc" value="<?=$_GET['doc']?>"/>
    <div class="main-fieldWrapper">
        <input type="button" class="main-btn main-submit" value="Готово"/>
    </div>
</form>