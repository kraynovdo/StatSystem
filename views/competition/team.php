    <div class="fafr-minWidth fafr-maxWidth">
    <?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
        <a class="fafr-link" href="/?r=compteam/add&ret=competition/team&comp=<?=$_GET['comp']?>">Добавить команду</a>
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
                <a  target="_blank" class="fafr-link comp-columnContentLink" href="/?r=team/view&team=<?=$answer[$i]['id']?><?=$filter?>""></a>
                <div class="comp-teamTile_logo">
                    <?if ($answer[$i]['logo']) {?>
                        <span class="comp-teamTile_logoLink">
                            <img style="width:140px" src="//<?=$HOST?>/upload/<?=$answer[$i]['logo']?>">
                        </span>
                    <?} else {?>
                        <span class="comp-teamTile_logoLink">
                            <div class="fafr-noPhoto">?</div>
                        </span>
                    <?}?>
                </div>
                <div class="comp-teamTile_info">
                    <span class="comp-teamTile_city">
                        <?=$answer[$i]['city_adj']?>
                    </span>
                    <span class="comp-teamTile_name">
                        <?=$answer[$i]['rus_name']?>
                    </span>
                    <div class="comp-teamTile_label fafr-textAdd">
                        Главный тренер
                    </div>
                    <div class="comp-teamTile_coach">
                        <?=$answer[$i]['csname'] . ' ' .  $answer[$i]['cname']?>
                    </div>
                </div>
            </div>
            <?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
                <a class="main-delLink fafr-link" href="/?r=compteam/delete&id=<?=$answer[$i]['ctid']?>&ret=competition/team&comp=<?=$_GET['comp']?>">Удалить</a>
            <?}?>
        </div>
        <?$odd = 1-$odd;}?>
        <div class="clearfix"></div>
    </div>
 </div>