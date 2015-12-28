<h2>Игровые позиции</h2>
<?if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {?>
    <a class="main-addLink" href="/?r=position/add">Добавить позицию</a>
<?}?>
<div class="listview">

    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <div class="listview-item">
            <a href="/?r=position/edit&id=<?=$answer[$i]['id']?>"><?=$answer[$i]['abbr']?> - <?=$answer[$i]['rus_name']?></a>
        </div>
    <?}?>
</div>