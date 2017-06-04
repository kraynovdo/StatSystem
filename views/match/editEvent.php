<h2>Редактирование действия</h2>
<h3><?=$answer['event']['aname']?></h3>
<form method="POST" action="/?r=match/updateEvent">
    <div class="main-fieldWrapper">
        <div>Период</div>
        <select name="period">
            <option value="1"<?if ($answer['event']['period'] == 1) {?> selected="selected"<?}?>>1</option>
            <option value="2"<?if ($answer['event']['period'] == 2) {?> selected="selected"<?}?>>2</option>
            <option value="3"<?if ($answer['event']['period'] == 3) {?> selected="selected"<?}?>>3</option>
            <option value="4"<?if ($answer['event']['period'] == 4) {?> selected="selected"<?}?>>4</option>
            <option value="5"<?if ($answer['event']['period'] == 5) {?> selected="selected"<?}?>>Овертайм</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <div>Комментарий</div>
        <textarea rows="3" name="comment"><?=$answer['event']['comment']?></textarea>
    </div>
    <hr/>
    <input type="hidden" name="event" value="<?=$_GET['event']?>"/>
    <input type="hidden" name="action" value="<?=$answer['event']['action']?>"/>
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <input type="hidden" name="match" value="<?=$_GET['match']?>"/>
    <input type="hidden" name="ret" value="<?=$_GET['ret']?>"/>
    <?for ($i = 0; $i < count($answer['statchar']); $i++){?>
        <div class="main-fieldWrapper">
            <div><?=$answer['statchar'][$i]['name']?></div>
            <input type="text" name="char[<?=$answer['statchar'][$i]['ctid']?>]" value="<?=$answer['statchar'][$i]['value']?>"/>
        </div>
    <?}?>
    <hr/>
    <?for ($i = 0; $i < count($answer['statperson']); $i++){?>
    <?$curPerson = $answer['statperson'][$i]['person'];
        $roster = $answer['team'.$answer['statperson'][$i]['offdef'].'roster'];?>
    <div class="stats-teamBlock">
        <div class="main-fieldWrapper">
            <div><?=$answer['statperson'][$i]['name']?></div>
            <select name="person[<?=$answer['statperson'][$i]['ptid']?>]" class="stats-statperson">
                <option value="">Игрок</option>
                <?for($j = 0; $j < count($roster); $j++){?>
                    <option value="<?=$roster[$j]['personID']?>" <?if ($roster[$j]['personID'] == $curPerson) {?>selected="selected"<?}?>>
                        <?=$roster[$j]['number'] . ' - ' . $roster[$j]['surname'] . ' ' . $roster[$j]['name']?>
                    </option>
                <?}?>
            </select>
        </div>
    </div>
    <?}?>
    <hr/>
    <div class="main-fieldWrapper">
        <div>Результат</div>
        <select name="point">
            <option value="">Очки не набраны</option>
            <?for($j = 0; $j < count($answer['point']); $j++){?>
            <option value="<?=$answer['point'][$j]['id']?>" <?if ($answer['point'][$j]['id'] == $answer['event']['pointsget']) {?>selected="selected"<?}?>>
                <?=$answer['point'][$j]['name']?>
            </option>
            <?}?>
        </select>
    </div>
    <button class="main-btn main-submit">Готово</button>
</form>