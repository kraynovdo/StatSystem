<h2>Редактирование вида спорта</h2>
<?php if (count($answer)) {?>
    <form action="/?r=sport/update" method="POST">
        <p>
            <input name="name" type="text" value="<?=$answer['name']?>" placeholder="Название"/>
            <input type="hidden" name="id" value="<?=$answer['id']?>">
        </p>
        <input class="main-btn" type="submit" value="Сохранить"/>
    </form>
    <p>
        <form action="/?r=sport/delete" method="POST" class="main-delForm">
            <input type="hidden" name="id" value="<?=$answer['id']?>"/>
            <input class="main-btn" type="submit" value="Удалить"/>
        </form>
    </p>
<?} else {?>
    Вид спорта не найден
<?}?>
