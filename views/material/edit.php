<h2>Редактирование материала</h2>
<?php if (count($answer)) {?>
    <form action="/?r=material/update" method="POST">
        <input data-validate="req" name="title" class="material-editTitle" type="text" value='<?=$answer['title']?>' placeholder="Заголовок"/>
        <input type="hidden" name="mater" value="<?=$answer['id']?>">
        <?if ($_GET['comp']){?>
            <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
        <?}?>
        <?if ($_GET['team']){?>
            <input type="hidden" name="team" value="<?=$_GET['team']?>"/>
        <?}?>
        <?if ($_GET['federation']){?>
            <input type="hidden" name="federation" value="<?=$_GET['federation']?>"/>
        <?}?>
        <textarea name="preview" class="material-editPreview" placeholder="Краткий анонс"><?=$answer['preview']?></textarea>
        <textarea name="content" class="material-editContent main-textEditor" placeholder="Содержание"><?=$answer['content']?></textarea>
        <input class="main-btn main-submit" type="button" value="Сохранить"/>
    </form>
<?} else {?>
    Материал не найден
<?}?>
