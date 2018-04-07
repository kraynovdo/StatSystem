<h2>Редактирование материала</h2>
<?php if (count($answer)) {?>
    <form action="/?r=material/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="mater" value="<?=$answer['id']?>">
        <input type="hidden" name="ret" value="<?=$_GET['ret']?>"/>
        <?if ($_GET['comp']){?>
            <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
        <?}?>
        <?if ($_GET['team']){?>
            <input type="hidden" name="team" value="<?=$_GET['team']?>"/>
        <?}?>
        <?if ($_GET['federation']){?>
            <input type="hidden" name="federation" value="<?=$_GET['federation']?>"/>
        <?}?>
        <input data-validate="req" name="title" class="material-editTitle" type="text" value='<?=$answer['title']?>' placeholder="Заголовок"/>
        <div class="main-fieldWrapper">
            <div class="main-file material-img" data-ratio="2">
                <?if ($answer['image']) {?>
                    <img src="//<?=$HOST?>/upload/<?=$answer['image']?>" class="main-file_miniature">
                <?} else {?>
                    <div class="main-file_label">Добавить<br/>миниатюру<br/>(формат jpeg)</div>
                <?}?>
                <input class="main-file_input" type="file" name="image"/>
            </div>
        </div>
        <div class="main-fieldWrapper">
            <textarea name="preview" class="material-editPreview" placeholder="Краткий анонс"><?=$answer['preview']?></textarea>
        </div>
        <div class="main-fieldWrapper">
            <label>Показывать в ленте</label>
            <input type="checkbox" name="ismain" <?if ($answer['ismain']) {?>checked="checked"<?}?>/>
        </div>
        <div class="main-fieldWrapper">
            <textarea name="content" class="material-editContent main-textEditor" placeholder="Содержание"><?=$answer['content']?></textarea>
        </div>
        <input class="main-btn main-submit" type="button" value="Сохранить"/>
    </form>
<?} else {?>
    Материал не найден
<?}?>
