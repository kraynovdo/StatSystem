<h2>Добавление материала</h2>
<form action="/?r=material/create" method="POST" enctype="multipart/form-data">
    <?if ($_GET['comp']){?>
        <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <?}?>
    <?if ($_GET['team']){?>
        <input type="hidden" name="team" value="<?=$_GET['team']?>"/>
    <?}?>
    <?if ($_GET['federation']){?>
        <input type="hidden" name="federation" value="<?=$_GET['federation']?>"/>
    <?}?>
    <input data-validate="req" name="title" class="material-editTitle" type="text" value="" placeholder="Заголовок"/>
    <div class="main-fieldWrapper">
        <div class="main-file material-img" data-ratio="2">
            <div class="main-file_label">Добавить<br/>миниатюру<br/>(формат jpeg)</div>
            <input class="main-file_input" type="file" name="image"/>
        </div>
    </div>
    <div class="main-fieldWrapper">
        <textarea name="preview" class="material-editPreview" placeholder="Краткий анонс"></textarea>
    </div>
    <div class="main-fieldWrapper">
        <label>Показывать в ленте</label>
        <input type="checkbox" name="ismain"/>
    </div>
    <div class="main-fieldWrapper">
        <textarea name="content" class="material-editContent main-textEditor" placeholder="Содержание"></textarea>
    </div>
    <input class="main-btn main-submit" type="button" value="Сохранить"/>
</form>