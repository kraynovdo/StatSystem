<h2>Добавление матча</h2>
<form method="POST" action="/?r=match/create">
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Дата матча</label>
        <input type="text" class="main-date" name="date" data-validate="req"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Команда - хозяин</label>
        <select name="team1" data-validate="req" class="match-teamHome">
            <option value="">-Выберите команду-</option>
    <?
        $team = $answer['team'];
        for ($i = 0; $i < count($team); $i++) {?>
            <option value="<?=$team[$i]['id']?>"><?=$team[$i]['rus_name']?> (<?=$team[$i]['city']?>)</option>
    <?   }?>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Команда - гость</label>
        <select name="team2" data-validate="req">
            <option value="">-Выберите команду-</option>
            <?
            $team = $answer['team'];
            for ($i = 0; $i < count($team); $i++) {?>
                <option value="<?=$team[$i]['id']?>"><?=$team[$i]['rus_name']?> (<?=$team[$i]['city']?>)</option>
            <?   }?>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Город проведения матча</label>
        <input class="match-cityField" type="text" name="city"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Время начала (по Москве)</label>
        <input class="match-timeField" type="text" name="timeh" maxlength="2"/>:<input class="match-timeField" type="text" name="timem" maxlength="2"/>
    </div>
    <input type="button" class="main-btn main-submit" value="Готово"/>
    <div class="main-hidden match-cityList">
        <?for ($i = 0; $i < count($team); $i++) {?>
        <div data-id="<?=$team[$i]['id']?>"><?=$team[$i]['city']?></div>
        <?}?>
    </div>
</form>