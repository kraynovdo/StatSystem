<?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
    <a href="/?r=compteam/add&comp=<?=$_GET['comp']?>">Добавить команду</a>
<?}?>
<div class="listview">
    <?$prev_group=''; $odd=0;?>

    <?$filter = $_GET['comp'] ? '&comp='.$_GET['comp'] : ''?>
    <?php for ($i = 0; $i < count($answer); $i++) {?>
    <?if ($prev_group != $answer[$i]['group']) {?>
        <?
        $prev_group = $answer[$i]['group'];
        $odd = 0;
        ?>
        <h2 class="fafr-centerAl comp-columnsHeader clearfix fafr-h2"><?=$answer[$i]['groupname']?></h2>
        <?}?>
    <div class="comp-columnItem <?if ($odd) {?>comp-columnItem_odd<?}?>">
        <div class="comp-teamTile comp-columnItem_content">
            <div class="comp-teamTile_logo">
                <?if ($answer[$i]['logo']) {?>
                    <a class="comp-teamTile_logoLink" target="_blank" href="/?r=team/view&team=<?=$answer[$i]['id']?><?=$filter?>">
                        <img style="width:140px" src="//<?=$HOST?>/upload/<?=$answer[$i]['logo']?>">
                    </a>
                <?} else {?>
                    <a class="comp-teamTile_logoLink" target="_blank" href="/?r=team/view&team=<?=$answer[$i]['id']?><?=$filter?>">
                        <div class="fafr-noPhoto">?</div>
                    </a>
                <?}?>
            </div>
            <div class="comp-teamTile_info">
                <a class="comp-teamTile_logoLink fafr-text comp-teamTile_city" target="_blank" href="/?r=team/view&team=<?=$answer[$i]['id']?><?=$filter?>">
                    <?=$answer[$i]['city_adj']?>
                </a>
                <a class="comp-teamTile_logoLink fafr-text comp-teamTile_name" target="_blank" href="/?r=team/view&team=<?=$answer[$i]['id']?><?=$filter?>">
                    <?=$answer[$i]['rus_name']?>
                </a>
                <div class="comp-teamTile_label fafr-textAdd">
                    Главный тренер
                </div>
                <div class="comp-teamTile_coach">
                    <?=$answer[$i]['csname'] . ' ' .  $answer[$i]['cname']?>
                </div>
            </div>
        </div>
    </div>
    <?$odd = 1-$odd;}?>
    <div class="clearfix"></div>
</div>