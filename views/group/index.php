<? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/competition/_adminNavig.php');?>
<h3>Группы</h3>
<?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
    <a class="main-addLink" href="/?r=group/add&comp=<?=$_GET['comp']?>">Добавить группу</a>
<?}?>
<div class="listview">

    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <div class="listview-item">
            <?=$answer[$i]['name']?>
            <a class="main-delLink" href="/?r=group/delete&id=<?=$answer[$i]['id']?>&comp=<?=$_GET['comp']?>">[x]</a>
        </div>
    <?}?>
</div>