<div class="fafr-minWidth fafr-maxWidth">
    <?if (count($answer['group'])) {?>

    <div class="comp_groupSelector" xmlns="http://www.w3.org/1999/html">
            <h2 class="fafr-h2 comp_groupSelector_label">Дивизион</h2>

            <select class="match-groupSelector comp_groupSelector_dropdown">
                <option value="">- Все -</option>
                <?for ($i = 0; $i < count($answer['group']); $i++) {?>
                <option value="<?=$answer['group'][$i]['id']?>"
                    <?if ($answer['group'][$i]['id'] == $_GET['group']) {?> selected="selected"<?}?>><?=$answer['group'][$i]['name']?></option>
                <?}?>
            </select>
        </div>
    <?}?>

    <?if(($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)){?>
        <a class="fafr-link main-addLink" href="/?r=match/add&ret=calendar&comp=<?=$_GET['comp']?>">Добавить матч</a>
    <?}?>

    <?$match = $answer['match']; $ctrlMode = true;?>
    <?if (!$viewHref) $viewHref='matchcenter';?>


    <div class="match-list">
        <?$prev_date='';$odd = 0;?>
        <?php for ($i = 0; $i < count($match); $i++) {?>

            <?if ($prev_date != $match[$i]['date']) {?>
                <?
                    $prev_date = $match[$i]['date'];
                    $date = common_dateFromSQL($prev_date);
                    $odd = 0;
                ?>
                <h2 class="comp-columnsHeader clearfix fafr-h2"><span class="calendar-dateHeader"><?=$date?></span></h2>
            <?}?>


            <div class="comp-columnItem <?if ($odd) {?>comp-columnItem_odd<?}?>">
                <div class="comp-columnItem_content calendar-item_content">
                    <a class="comp-columnContentLink" href="/?r=<?=$viewHref?>&match=<?=$match[$i]['id']?>&comp=<?=$_GET['comp']?>"></a>
                    <div class="calendar-item_left">
                        <div class="calendar-item_logo">
                            <?if ($match[$i]['t1logo']) {?>
                                <img style="width:50px" src="//<?=$HOST?>/upload/<?=$match[$i]['t1logo']?>">
                            <?} else {?>
                                <div class="fafr-noPhoto">?</div>
                            <?}?>
                        </div>
                        <div class="calendar-item_team">
                            <?=$match[$i]['t1name']?>
                        </div>
                        <div class="calendar-item_city fafr-textAdd">
                            <?=$match[$i]['t1city']?>
                        </div>
                    </div>
                    <div class="calendar-item_center">
                        <div class="calendar-item_count">
                            <a class="calendar-item_digit"><?=strlen ($match[$i]['score1']) ? $match[$i]['score1'] : '-'?></a>
                            <a class="calendar-item_digit"><?=strlen ($match[$i]['score2']) ? $match[$i]['score2'] : '-'?></a>
                        </div>
                        <div class="calendar-item_info">
                            <?if ($match[$i]['timeh']){?><div><?=$match[$i]['timeh']?>:<?=$match[$i]['timem']?> (мск)</div><?}?>
                            <?if ($match[$i]['city']){?><div><?=$match[$i]['city']?></div><?}?>
                            <?if ($match[$i]['g']){?><div><?=$match[$i]['gname']?></div><?}?>
                        </div>
                    </div>
                    <div class="calendar-item_right">
                        <div class="calendar-item_logo">
                            <?if ($match[$i]['t2logo']) {?>
                                <img style="width:50px" src="//<?=$HOST?>/upload/<?=$match[$i]['t2logo']?>">
                            <?} else {?>
                                <div class="fafr-noPhoto">?</div>
                            <?}?>
                        </div>
                        <div class="calendar-item_team">
                            <?=$match[$i]['t2name']?>
                        </div>
                        <div class="calendar-item_city fafr-textAdd">
                            <?=$match[$i]['t2city']?>
                        </div>
                    </div>
                </div>
                <?if ((($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1))  && ($ctrlMode)) {?>
                <a class="fafr-link" href="/?r=match/edit&ret=calendar&comp=<?=$_GET['comp']?>&match=<?=$match[$i]['id']?>">[Ред]</a>
                <a class="fafr-link main-delLink main-danger" href="/?r=match/delete&ret=calendar&comp=<?=$_GET['comp']?>&match=<?=$match[$i]['id']?>">[X]</a>
                <?}?>
            </div>
        <?$odd = 1-$odd;}?>
        <div class="clearfix"></div>
    </div>
</div>