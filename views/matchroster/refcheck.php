<h2>Проверка состава</h2>
<a class="refcheck-bigfont" href="/?r=match/view&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Вернуться к матчу</a>
<?$roster = $answer['roster']['answer'];?>
<?for ($i = 0; $i < count($roster); $i++) {?>
    <div class="listview-item refcheck-item" data-mr="<?=$roster[$i]['id']?>">
        <div class="refcheck-photo">
            <?if ($roster[$i]['avatar']) {?>
                <img style="width:200px" src="//<?=$HOST?>/upload/<?=$roster[$i]['avatar']?>">
            <?} else {?>
                <div class="main-noPhoto">?</div>
            <?}?>
        </div>
        <div class="refcheck-main">
            <div class="refcheck-fio refcheck-bigfont"><?=$roster[$i]['surname'] . ' ' . $roster[$i]['name'] . ' ' . $roster[$i]['patronymic']?></div>
            <div class="refcheck-number  refcheck-bigfont">#<?=$roster[$i]['number']?></div>
            <div class="refcheck-inputCont main-hidden">
                <input class="refcheck-input refcheck-bigfont" value="<?=$roster[$i]['number']?>"/>
            </div>
            <a href="javascript: void(0)" class="refcheck-change refcheck-bigfont">Изменить номер</a>
            <a href="javascript: void(0)" class="main-hidden refcheck-ok refcheck-bigfont">Сохранить</a>
        </div>
    </div>
<?}?>
<a class="refcheck-bigfont" href="/?r=match/view&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Вернуться к матчу</a>