<div class="stats-addWrapper">
    <?for ($i = 0; $i < count($answer['chartype']); $i++){?>
        <div class="main-fieldWrapper">
            <div><?=$answer['chartype'][$i]['name']?></div>
            <input type="text" name="char[<?=$answer['chartype'][$i]['id']?>]"/>
        </div>
    <?}?>
    <?for ($i = 0; $i < count($answer['persontype']); $i++){?>
        <div class="main-fieldWrapper">
            <div><?=$answer['persontype'][$i]['name']?></div>
            <select name="teamSt[]" class="stats-team">
                <option value="">Команда</option>
            </select>
            <select name="person[<?=$answer['persontype'][$i]['id']?>]" class="stats-persontype">
                <option value="">Игрок</option>
            </select>
        </div>
    <?}?>
    <div class="main-fieldWrapper">
        <select name="point">
            <option value="">Результат</option>
        <?for ($i = 0; $i < count($answer['point']); $i++){?>
            <option value="<?=$answer['point'][$i]['id']?>"><?=$answer['point'][$i]['name']?></option>
        <?}?>
        </select>
    </div>
</div>