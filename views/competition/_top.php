<?for ($i = 0; $i < count($top) ; $i++) {?>
    <div class="top10-item">
        <a class="top10-item_avatar top10-item_img" target="_blank" href="/?r=person/view&person=<?=$top[$i]['person']?>">
            <?if ($top[$i]['avatar']) {?>
                <img style="width:50px" src="//<?=$HOST?>/upload/<?=$top[$i]['avatar']?>">
            <?} else {?>
                <div class="main-noPhoto">?</div>
            <?}?>
        </a>
        <div class="top10-item_content">
            <a class="top10-item_fio"  target="_blank" href="/?r=person/view&person=<?=$top[$i]['person']?>"><?=$top[$i]['surname'] . ' ' . $top[$i]['name']?></a>
        </div>
        <span class="top10-item_point main-rightAlign"><?=$top[$i]['points']?></span>
    </div>
<?}?>