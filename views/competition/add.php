<h2>Добавление товарищеского матча</h2>
<form action="/?r=competition/create" method="post">
<div class="main-fieldWrapper">
    <label class="main-label_top" for="type">Дата матча</label>
    <input type="text" class="main-date" name="date" data-validate="date"/>
</div>
<?$team = $answer['team']?>
<div class="main-fieldWrapper">
    <label class="main-label_top" for="type">Команда - хозяин</label>
    <select name="team1" data-validate="req">
        <option value="">Выберите команду</option>
<?for($i = 0; $i < count($team); $i++) {?>
    <?
    if ($team[$i]['age_id'] != 21) {
        $age = ' ('.$team[$i]['age'].')';
    }
    else {
        $age = '';
    }
    ?>
    <option value="<?=$team[$i]['id']?>">
        <?=$team[$i]['rus_name']?>
        <?=$team[$i]['city']?><?=$age?>
    </option>
<?}?>
    </select>
</div>
<div class="main-fieldWrapper">
    <label class="main-label_top" for="type">Команда гость</label>
    <select name="team2" data-validate="req">
        <option value="">Выберите команду</option>
        <?for($i = 0; $i < count($team); $i++) {?>
            <?
            if ($team[$i]['age_id'] != 21) {
                $age = ' ('.$team[$i]['age'].')';
            }
            else {
                $age = '';
            }
            ?>
            <option value="<?=$team[$i]['id']?>">
                <?=$team[$i]['rus_name']?>
                <?=$team[$i]['city']?><?=$age?>
            </option>
        <?}?>
    </select>
</div>
    <input type="button" class="main-btn main-submit roster-submit" value="Готово"/>
</form>