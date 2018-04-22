<?if ($_GET['ret']) {?>
<div>
    <a href="/?r=<?=$_GET['ret']?>&comp=<?=$_GET['comp']?>&match=<?=$_GET['match']?>">Вернуться к матчу</a>
</div><br/>
<?}?>
<?
    $protocol = array();
    if (count($answer['protocol'])) {
        $protocol = $answer['protocol'][0];
    }
    else {
        $protocol = array();
        $protocol['timeb'] = $answer['match']['timeh'].':'.$answer['match']['timem'];
    }
?>
<form method="POST" action="/?r=protocol/update">
    <input type="hidden" name="ret" value="<?=$_GET['ret']?>"/>
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <div class="main-fieldWrapper">
        <label class="main-label_top"><?=$answer['match']['t1']?> - цвет формы</label>
        <input type="text" name="color1" value="<?=$protocol['color1']?>" class="protocol-txtField"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top"><?=$answer['match']['t2']?> - цвет формы</label>
        <input type="text" name="color2" value="<?=$protocol['color2']?>" class="protocol-txtField"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Плановое время начала</label>
        <input type="text" name="timeb" value="<?=$protocol['timeb']?>" data-validate="time"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Фактическое время начала</label>
        <input type="text" name="timee" value="<?=$protocol['timee']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Продолжительность четвертей, мин</label>
        <label>1я</label>
        <input type="text" name="time1" value="<?=$protocol['time1']?>"/>
        <label>2я</label>
        <input type="text" name="time2" value="<?=$protocol['time2']?>"/>
        <label>3я</label>
        <input type="text" name="time3" value="<?=$protocol['time3']?>"/>
        <label>4я</label>
        <input type="text" name="time4" value="<?=$protocol['time4']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Счет матча</label>
        <label><?=$answer['match']['t1']?></label>
        <input type="text" name="point1" value="<?=$protocol['point1']?>"/>
        <label><?=$answer['match']['t2']?></label>
        <input type="text" name="point2" value="<?=$protocol['point2']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Овертайм</label>
        <label><?=$answer['match']['t1']?></label>
        <input type="text" name="pointover1" value="<?=$protocol['pointover1']?>"/>
        <label><?=$answer['match']['t2']?></label>
        <input type="text" name="pointover2" value="<?=$protocol['pointover2']?>"/>
    </div>
    <hr/>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Разметка поля</label>
        <select name="razm">
            <option value="5"<?if($protocol['razm'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['razm'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['razm'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Раздевалки</label>
        <select name="razd">
            <option value="5"<?if($protocol['razd'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['razd'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['razd'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Мячи</label>
        <select name="ball">
            <option value="5"<?if($protocol['ball'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['ball'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['ball'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Цепь и маркеры</label>
        <select name="chain">
            <option value="5"<?if($protocol['chain'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['chain'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['chain'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Ball boys</label>
        <select name="ballboy">
            <option value="5"<?if($protocol['ballboy'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['ballboy'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['ballboy'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Цепочная бригада</label>
        <select name="chaincrew">
            <option value="5"<?if($protocol['chaincrew'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['chaincrew'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['chaincrew'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Погода</label>
        <select name="weather">
            <option value="5"<?if($protocol['weather'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['weather'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['weather'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Форма игроков</label>
        <label><?=$answer['match']['t1']?></label>
        <select name="form1">
            <option value="5"<?if($protocol['form1'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['form1'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['form1'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
        <label><?=$answer['match']['t2']?></label>
        <select name="form2">
            <option value="5"<?if($protocol['form2'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['form2'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['form2'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Поведение игроков</label>
        <label><?=$answer['match']['t1']?></label>
        <select name="player1">
            <option value="5"<?if($protocol['player1'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['player1'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['player1'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
        <label><?=$answer['match']['t2']?></label>
        <select name="player2">
            <option value="5"<?if($protocol['player2'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['player2'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['player2'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Поведение тренеров</label>
        <label><?=$answer['match']['t1']?></label>
        <select name="coach1">
            <option value="5"<?if($protocol['coach1'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['coach1'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['coach1'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
        <label><?=$answer['match']['t2']?></label>
        <select name="coach2">
            <option value="5"<?if($protocol['coach2'] == 5){?> selected="selected"<?}?>>Отлично</option>
            <option value="4"<?if($protocol['coach2'] == 4){?> selected="selected"<?}?>>Хорошо</option>
            <option value="3"<?if($protocol['coach2'] == 3){?> selected="selected"<?}?>>Удовлетворительно</option>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Описание инцидентов</label>
        <textarea name="incident" class="protocol-incident"><?=$protocol['incident']?></textarea>
    </div>
    <hr/>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Рефери</label>
        <input class="protocol-txtField" type="text" name="refferee" value="<?=$protocol['refferee']?>" data-validate="req"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Ампаэр</label>
        <input class="protocol-txtField" type="text" name="empire" value="<?=$protocol['empire']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Бэк-джадж</label>
        <input class="protocol-txtField" type="text" name="backjudge" value="<?=$protocol['backjudge']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Хэд-лайнсмэн</label>
        <input class="protocol-txtField" type="text" name="linesman" value="<?=$protocol['linesman']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Лайн-джадж</label>
        <input class="protocol-txtField" type="text" name="linejudge" value="<?=$protocol['linejudge']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Филд-джадж</label>
        <input class="protocol-txtField"type="text" name="judge6" value="<?=$protocol['judge6']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Сайд-джадж</label>
        <input class="protocol-txtField" type="text" name="judge7" value="<?=$protocol['judge7']?>"/>
    </div>
    <input type="hidden" name="match" value="<?=$_GET['match']?>"/>
    <input type="button" value="Сохранить" class="main-submit main-btn"/>
</form>