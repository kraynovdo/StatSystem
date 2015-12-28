<h2>Виды спорта</h2>
<?if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {?>
    <a class="main-addLink" href="/?r=sport/add">Добавить вид спорта</a>
<?}?>
<div class="listview">
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <div class="listview-item">
            <a href="/?r=sport/edit&id=<?=$answer[$i]['id']?>"><?=$answer[$i]['name']?></a>
        </div>
    <?}?>
</div>