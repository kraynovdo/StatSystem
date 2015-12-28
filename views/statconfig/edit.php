<h2>Редактирование действия</h2>
<form action="/?r=statconfig/update" method="post">
    <input type="hidden" name="type" value="<?=$_GET['type']?>"/>
    <div class="main-fieldWrapper">
        <label class="main-label_top" for="type">Название</label>
        <input class="main-field_big" type="text" name="name" data-validate="req" value="<?=$answer['actiontype']['name']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <input type="button" class="main-btn main-submit roster-submit" value="Готово"/>
    </div>
</form>

<h3>
    Характеристики
    <input type="button" class="main-btn statconfig-charbtn" href="javascript: void(0)" value="+"/>
</h3>
<div class="statconfig-sublist">
    <form class="statconfig-charform main-hidden" action="/?r=statconfig/createChar" method="post">
        <input type="hidden" name="type" value="<?=$_GET['type']?>"/>
        <div class="main-fieldWrapper">
            <input class="main-field_med statconfig-fieldChar" type="text" name="name" data-validate="req" placeholder="Название"/>
            <input type="button" class="main-btn main-submit" value="Готово"/>
        </div>
    </form>
    <?for ($i = 0; $i < count($answer['chartype']); $i++) {?>
        <div class="listview-item">
            <?=$answer['chartype'][$i]['name']?>
            <a class="main-delLink" href="/?r=statconfig/deleteChar&char=<?=$answer['chartype'][$i]['id']?>&type=<?=$_GET['type']?>">[X]</a>
        </div>
    <?}?>
</div>


<h3>
    Участники действия
    <input type="button" class="main-btn statconfig-personbtn" href="javascript: void(0)" value="+"/>
</h3>
<div class="statconfig-sublist">
    <form class="statconfig-personform main-hidden" action="/?r=statconfig/createPerson" method="post">
        <input type="hidden" name="type" value="<?=$_GET['type']?>"/>
        <div class="main-fieldWrapper">
            <input class="main-field_med statconfig-fieldPerson" type="text" name="name" data-validate="req" placeholder="Название"/>
            <input type="button" class="main-btn main-submit" value="Готово"/>
        </div>
    </form>
    <?for ($i = 0; $i < count($answer['persontype']); $i++) {?>
        <div class="listview-item">
            <?=$answer['persontype'][$i]['name']?>
            <a class="main-delLink" href="/?r=statconfig/deletePerson&person=<?=$answer['persontype'][$i]['id']?>&type=<?=$_GET['type']?>">[X]</a>
        </div>
    <?}?>
</div>


<h3>
    Возможный результат
    <input type="button" class="main-btn statconfig-pointbtn" href="javascript: void(0)" value="+"/>
</h3>
<div class="statconfig-sublist">
    <form class="statconfig-pointform main-hidden" action="/?r=statconfig/createPoint" method="post">
        <input type="hidden" name="type" value="<?=$_GET['type']?>"/>
        <div class="main-fieldWrapper">
            <select class="main-field_med" name="pointsget">
                <?for ($i = 0; $i < count($answer['pointsget']); $i++) {?>
                    <option value="<?=$answer['pointsget'][$i]['id']?>"><?=$answer['pointsget'][$i]['name']?></option>
                <?}?>
            </select>
            <input type="button" class="main-btn main-submit" value="Готово"/>
        </div>
    </form>
    <?for ($i = 0; $i < count($answer['point']); $i++) {?>
        <div class="listview-item">
            <?=$answer['point'][$i]['name']?>
            <a class="main-delLink" href="/?r=statconfig/deletePoint&point=<?=$answer['point'][$i]['id']?>&type=<?=$_GET['type']?>">[X]</a>
        </div>
    <?}?>
</div>