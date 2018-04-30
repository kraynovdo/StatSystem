<h2>Видео</h2>
<form action="/?r=video/update" method="POST">
    <input type="hidden" name="video" value="<?=$_GET['video']?>"/>
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Заголовок</label>
        <input data-validate="req" name="title" class="video-field" type="text" value="<?=$answer['title']?>"/>
    </div>

    <div class="main-fieldWrapper">
        <label class="main-label_top">Ссылка на youtu.be</label>
        <input name="content" class="video-field" type="text" value="<?=$answer['content']?>"/>
    </div>

    <div class="main-fieldWrapper">
        <label class="main-label_top">Дата публикации</label>
        <input type="text" class="main-date" value="<?=common_dateFromSQL($answer['date'])?>" name="date"/>
    </div>

    <div class="main-fieldWrapper">
        <label for="ismain">Показывать в ленте</label>
        <input type="checkbox" name="ismain" id="ismain" <?if ($answer['ismain']) {?>checked="checked"<?}?>/>
    </div>

    <div class="main-fieldWrapper">
        <label class="main-label_top">Категория</label>
        <select class="video-field" name="category">
            <option value="0">Прочее</option>
            <option value="1"<?if ($answer['category'] == 1) {?> selected="selected"<?}?>>Обзоры</option>
            <option value="2"<?if ($answer['category'] == 2) {?> selected="selected"<?}?>>Лучшие моменты</option>
        </select>
    </div>
    <input class="main-btn main-submit" type="button" value="Сохранить"/>
</form>