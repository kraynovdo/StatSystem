<h2>Сетка плей-офф</h2>
<div class="po-table">

    <div class="po-column po-column-25">
    	<?for ($i = 0; $i < 4; $i++) {?>
    	<div class="po-cell po-cell-4">
            <div class="po-match">
                <div class="po-team">
                    <div class="po-logo"><?if ($answer[$i]['t1logo']){?><img style="width:32px"
                                              src="//amfoot.ru/upload/<?=$answer[$i]['t1logo']?>"><?}?></div>
                    <div class="po-count"><?=$answer[$i]['score1']?></div>
                    <div class="po-name"><?=$answer[$i]['t1name']?></div>
                </div>
                <div class="po-date" style="line-height:20px;"><?=common_dateFromSQL($answer[$i]['date'])?></div>
                <div class="po-team">
                    <div class="po-logo"><?if ($answer[$i]['t2logo']){?><img style="width:32px"
                                              src="//amfoot.ru/upload/<?=$answer[$i]['t2logo']?>"><?}?></div>
                    <div class="po-count"><?=$answer[$i]['score2']?></div>
                    <div class="po-name"><?=$answer[$i]['t2name']?></div>
                </div>
            </div>
        </div>
    	<?}?>
    
    
        
    </div>
    <div class="po-column po-column-25">
    <?for ($i = 4; $i < 6; $i++) {?>
    	<div class="po-cell po-cell-2">
            <div class="po-match">
                <div class="po-team">
                    <div class="po-logo"><?if ($answer[$i]['t1logo']){?><img style="width:32px"
                                              src="//amfoot.ru/upload/<?=$answer[$i]['t1logo']?>"><?}?></div>
                    <div class="po-count"><?=$answer[$i]['score1']?></div>
                    <div class="po-name"><?=$answer[$i]['t1name']?></div>
                </div>
                <div class="po-date" style="line-height:20px;"><?=common_dateFromSQL($answer[$i]['date'])?></div>
                <div class="po-team">
                    <div class="po-logo"><?if ($answer[$i]['t2logo']){?><img style="width:32px"
                                              src="//amfoot.ru/upload/<?=$answer[$i]['t2logo']?>"><?}?></div>
                    <div class="po-count"><?=$answer[$i]['score2']?></div>
                    <div class="po-name"><?=$answer[$i]['t2name']?></div>
                </div>
            </div>
        </div>
    	<?}?>
    </div>
    <div class="po-column po-column-25">
        <?for ($i = 6; $i < 8; $i++) {?>
    	<div class="po-cell po-cell-2">
            <div class="po-match">
                <div class="po-team">
                    <div class="po-logo"><?if ($answer[$i]['t1logo']){?><img style="width:32px"
                                              src="//amfoot.ru/upload/<?=$answer[$i]['t1logo']?>"><?}?></div>
                    <div class="po-count"><?=$answer[$i]['score1']?></div>
                    <div class="po-name"><?=$answer[$i]['t1name']?></div>
                </div>
                <div class="po-date" style="line-height:20px;"><?=common_dateFromSQL($answer[$i]['date'])?></div>
                <div class="po-team">
                    <div class="po-logo"><?if ($answer[$i]['t2logo']){?><img style="width:32px"
                                              src="//amfoot.ru/upload/<?=$answer[$i]['t2logo']?>"><?}?></div>
                    <div class="po-count"><?=$answer[$i]['score2']?></div>
                    <div class="po-name"><?=$answer[$i]['t2name']?></div>
                </div>
            </div>
        </div>
    	<?}?>
    </div>
    <div class="po-column po-column-25">
        <div class="po-cell po-cell-1">
        <?$i = 8;?>
            <div class="po-match">
                <div class="po-team">
                    <div class="po-logo"><?if ($answer[$i]['t1logo']){?><img style="width:32px"
                                              src="//amfoot.ru/upload/<?=$answer[$i]['t1logo']?>"><?}?></div>
                    <div class="po-count"><?=$answer[$i]['score1']?></div>
                    <div class="po-name"><?=$answer[$i]['t1name']?></div>
                </div>
                <div class="po-date" style="line-height:20px;"><?=common_dateFromSQL($answer[$i]['date'])?></div>
                <div class="po-team">
                    <div class="po-logo"><?if ($answer[$i]['t2logo']){?><img style="width:32px"
                                              src="//amfoot.ru/upload/<?=$answer[$i]['t2logo']?>"><?}?></div>
                    <div class="po-count"><?=$answer[$i]['score2']?></div>
                    <div class="po-name"><?=$answer[$i]['t2name']?></div>
                </div>
            </div>
        </div>
    </div>
</div>