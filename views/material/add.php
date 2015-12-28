<h2>Добавление материала</h2>
<form action="/?r=material/create" method="POST">
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
    <textarea name="preview" class="material-editPreview" placeholder="Краткий анонс"></textarea>
    <textarea name="content" class="material-editContent main-textEditor" placeholder="Содержание"></textarea>
    <input class="main-btn main-submit" type="button" value="Сохранить"/>
</form>