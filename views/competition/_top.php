<?for ($i = 0; $i < count($top) ; $i++) {?>
    <div class="top10-item">
        <a class="top10-item_avatar top10-item_img" target="_blank" href="/?r=person/view&person=<?=$top[$i]['person']?>">
            <?if ($top[$i]['avatar']) {?>
                <img style="width:50px" src="//<?=$HOST?>/upload/<?=$top[$i]['avatar']?>">
            <?} else {?>
                <div class="main-noPhoto">?</div>
            <?}?>
        </a>
        <div class="top10-item_logo">
            <?if ($top[$i]['logo']) {?>
                <img style="width: 30px;" src="//<?=$HOST?>/upload/<?=$top[$i]['logo']?>">
            <?} else {?>
                <div class="main-noPhoto">?</div>
            <?}?>
        </div>
        <div class="top10-item_content">
            <a class="top10-item_fio"  target="_blank" href="/?r=person/view&person=<?=$top[$i]['person']?>&comp=<?=$_GET['comp']?>"><?=$top[$i]['surname'] . ' ' . $top[$i]['name']?></a>
        </div>
        <span class="top10-item_point main-rightAlign"><?=$top[$i]['points']?></span>
    </div>
<?}?>