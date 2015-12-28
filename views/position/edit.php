<h2>Редактирование игровой позиции</h2>
<?php if (count($answer)) {?>
    <form action="/?r=position/update" method="POST">
        <p>
            <input name="name" type="text" value="<?=$answer['position']['name']?>" placeholder="Название"/>
        </p>
        <p>
            <input name="rus_name" type="text" value="<?=$answer['position']['rus_name']?>" placeholder="Название по-русски"/>
        </p>
        <p>
            <input name="abbr" type="text" value="<?=$answer['position']['abbr']?>" placeholder="Сокращение"/>
            <input name="id" type="hidden" value="<?=$answer['position']['id']?>"/>
        </p>
        <input class="main-btn" type="submit" value="Сохранить"/>
    </form>
    <p>
        <form action="/?r=position/delete" method="POST" class="main-delForm">
            <input type="hidden" name="id" value="<?=$answer['position']['id']?>"/>
            <input class="main-btn" type="submit" value="Удалить"/>
        </form>
    </p>
<?} else {?>
    Вид спорта не найден
<?}?>