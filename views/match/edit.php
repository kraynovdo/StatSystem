<h2>Редактирование матча</h2>
<form method="POST" action="/?r=match/update">
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <input type="hidden" name="match" value="<?=$_GET['match']?>"/>
    <?
    if ($answer['match'][0]['date'] != '0000-00-00') {
        $date_arr = explode('-', $answer['match'][0]['date']);
        $date = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
    }
    ?>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Дата матча</label>
        <input type="text" class="main-date" name="date" data-validate="req" value="<?=$date?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Группа</label>
        <select name="group">
            <option value="">-Выберите группу-</option>
            <?
            $group = $answer['group'];
            for ($i = 0; $i < count($group); $i++) {
                $selected = '';
                if ($answer['match'][0]['group'] == $group[$i]['id']) {
                    $selected = ' selected="selected"';
                }
            ?>
                <option value="<?=$group[$i]['id']?>"<?=$selected?>><?=$group[$i]['name']?></option>
            <?   }?>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Команда - хозяин</label>
        <select name="team1" data-validate="req" class="match-teamHome">
            <option value="">-Выберите команду-</option>
            <?
            $team = $answer['team'];

            for ($i = 0; $i < count($team); $i++) {
                $selected = '';
                if ($answer['match'][0]['team1'] == $team[$i]['id']) {
                    $selected = ' selected="selected"';
                }
            ?>
                <option value="<?=$team[$i]['id']?>"<?=$selected?>><?=$team[$i]['rus_name']?> (<?=$team[$i]['city']?>)</option>
            <?   }?>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Очки</label>
        <input type="text" name="score1" value="<?=$answer['match'][0]['score1']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Команда - гость</label>
        <select name="team2" data-validate="req">
            <option value="">-Выберите команду-</option>
            <?
            $team = $answer['team'];

            for ($i = 0; $i < count($team); $i++) {
                $selected = '';
                if ($answer['match'][0]['team2'] == $team[$i]['id']) {
                    $selected = ' selected="selected"';
                }
                ?>
                <option value="<?=$team[$i]['id']?>"<?=$selected?>><?=$team[$i]['rus_name']?> (<?=$team[$i]['city']?>)</option>
            <?   }?>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Очки</label>
        <input type="text" name="score2" value="<?=$answer['match'][0]['score2']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Город проведения матча</label>
        <input class="match-cityField" type="text" name="city" value="<?=$answer['match'][0]['city']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Время начала (по Москве)</label>
        <input class="match-timeField" type="text" name="timeh" maxlength="2" value="<?=$answer['match'][0]['timeh']?>"/>:<input class="match-timeField" type="text" name="timem" maxlength="2" value="<?=$answer['match'][0]['timem']?>"/>
    </div>
    <input type="button" class="main-btn main-submit" value="Готово"/>
    <div class="main-hidden match-cityList">
        <?for ($i = 0; $i < count($team); $i++) {?>
            <div data-id="<?=$team[$i]['id']?>"><?=$team[$i]['city']?></div>
        <?}?>
    </div>
</form>