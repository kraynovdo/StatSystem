<form method="POST" action="/?r=translation/update">
    <input type="hidden" name="trans" value="<?=$_GET['trans']?>"/>
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <div>Заголовок</div>
    <input class="trans_input" type="text" name="title" value="<?=$answer['title']?>"/>
    <div>Код плеера</div>
    <input class="trans_input" type="text" name="link" value='<?=$answer['link']?>'/>
    <input type="button" class="main-btn main-submit" value="OK"/>
</form>