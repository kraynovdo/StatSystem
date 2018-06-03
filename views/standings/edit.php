<h2>Добавить изображение таблицы</h2>
<form method="POST" action="/?r=standings/updateImage" enctype="multipart/form-data">
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <div class="main-fieldWrapper">
        <div class="main-file main-file_simple">
            <div class="main-file_label">Изображение (png)</div>
            <input class="main-file_input" type="file" name="st_img"/>
        </div>
    </div>
    <div class="main-fieldWrapper">
        <input type="button" class="main-btn main-submit" value="Загрузить"/>
    </div>
</form>