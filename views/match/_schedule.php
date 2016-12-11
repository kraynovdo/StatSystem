<?if (!$viewHref) $viewHref='match/view';?>
<div class="match-list">
    <?$prev_date=''?>
    <?php for ($i = 0; $i < count($match); $i++) {?>
        <?if ($prev_date != $match[$i]['date']) {?>
        <?
            $prev_date = $match[$i]['date'];
            $date = common_dateFromSQL($prev_date);
        ?>
        <h3 class="clearfix main-centerAlign main-h3_columns"><?=$date?></h3>
        <?}?>
        <?
        if (!$match[$i]['score1'] && $match[$i]['score1'] !== '0') {
            $score1 = '-';
        }
        else {
            $score1 = $match[$i]['score1'];
        }
        if (!$match[$i]['score2'] && $match[$i]['score2'] !== '0') {
            $score2 = '-';
        }
        else {
            $score2 = $match[$i]['score2'];
        }
        ?>
    <a href="/?r=<?=$viewHref?>&match=<?=$match[$i]['id']?>&comp=<?=$_GET['comp']?>" class="match-list_item">
        <div class="match-list_itemContent">

            <div class="match-list_itemLeft main-rightAlign">
                <span class="match-list_team"><?=$match[$i]['t1name']?></span>
                <span class="match-list_value match-list_value_left"><?=$score1?></span>
            </div>
            <div class="match-list_itemRight">
                <span class="match-list_value match-list_value_left"><?=$score2?></span>
                <span class="match-list_team"><?=$match[$i]['t2name']?></span>
            </div>
            <div class="match-list_itemFooter clearfix">
                <div class="match-list_footerItemLeft main-centerAlign">
                    <?if ($match[$i]['g']){?><span class="match-list_itemDivName"><?=$match[$i]['gname']?></span><?}?>
                    <?if ($match[$i]['city']){?><?=$match[$i]['city']?><?}?>
                    <?if ($match[$i]['timeh']){?><?=$match[$i]['timeh']?>:<?=$match[$i]['timem']?><?}?>
                </div>
                <div class="match-list_footerItemRight main-rightAlign">
                    <?if ((($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1))  && ($ctrlMode)) {?>
                        <a href="/?r=match/edit&comp=<?=$_GET['comp']?>&match=<?=$match[$i]['id']?>">[Ред]</a>
                        <a class="main-delLink main-danger" href="/?r=match/delete&comp=<?=$_GET['comp']?>&match=<?=$match[$i]['id']?>">[X]</a>
                    <?}?>
                </div>

            </div>

        </div>
    </a>
    <?}?>
</div>