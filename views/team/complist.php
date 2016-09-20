<h2>Команды</h2>
<?if ($_SESSION['userType'] == 3) {?>
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
            <h3 class="main-centerAlign main-h3_columns clearfix"><?=$answer[$i]['groupname']?></h3>
        <?}?>
        <div class="team-clItem main-columnItem main-columnItem<?if ($odd) {?>_odd<?}?>">
            <div class="team-clItemContent">
                <div class="team-clLogo">
                    <?if ($answer[$i]['logo']) {?>
                        <a class="team-clLogoLink" target="_blank" href="//<?=$HOST?>/?r=team/view&team=<?=$answer[$i]['id']?><?=$filter?>">
                            <img style="width:80px" src="//<?=$HOST?>/upload/<?=$answer[$i]['logo']?>">
                        </a>
                    <?} else {?>
                        <a class="team-clLogoLink" target="_blank" href="//<?=$HOST?>/?r=team/view&team=<?=$answer[$i]['id']?><?=$filter?>">
                            <div class="main-noPhoto">?</div>
                        </a>
                    <?}?>
                </div>
                <div class="team-clInfo">
                    <a class="team-clName" target="_blank" href="//<?=$HOST?>/?r=team/view&team=<?=$answer[$i]['id']?><?=$filter?>"><?=$answer[$i]['rus_name']?></a>

                    <br/>
                    <span class="team-clCity"><?=$answer[$i]['city']?></span>
                    <div class="team-clLinks">
                        <a target="_blank" href="/?r=roster&team=<?=$answer[$i]['id']?><?=$filter?>">Состав</a>
                        <?if ($_SESSION['userType'] == 3) {?>
                            <a class="main-delLink main-danger" href="/?r=compteam/delete&id=<?=$answer[$i]['ctid']?>&comp=<?=$_GET['comp']?>">Удалить</a>
                        <?}?>
                    </div>
                </div>
            </div>
        </div>
    <?$odd = 1-$odd;}?>
    <div class="clearfix"></div>
</div>