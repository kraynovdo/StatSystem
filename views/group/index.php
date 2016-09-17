<h2>Дивизионы</h2>
<?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
    <a class="main-addLink" href="/?r=group/add&comp=<?=$_GET['comp']?>">Добавить дивизион</a>
<?}?>
<div class="listview">

    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <div class="listview-item">
            <?=$answer[$i]['name']?>
            <a class="main-delLink" href="/?r=group/delete&id=<?=$answer[$i]['id']?>&comp=<?=$_GET['comp']?>">[x]</a>
        </div>
    <?}?>
</div>