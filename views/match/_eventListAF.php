<?for ($i = 0; $i < count($event); $i++) {?>
    <div class="listview-item">
        <?if ($admin) {?>
        <a class="main-delLink match-eventDelLink"
           href="/?r=match/deleteEvent&event=<?=$event[$i]['id']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>&ret=AF">[X]</a>
        <?}?>
        <div class="match-eventComment"><?if ($event[$i]['period'] < 5){?>Q<?=$event[$i]['period']?><?} else {?>OT<?}?></div>
        <?if ($event[$i]['firstStr']) {?>
            <div class="match-eventImgContainer">
                <?if ($event[$i]['team']){?>
                    <img class="match-eventImg" src="//<?=$HOST?>/upload/<?=$event[$i]['team']?>"/>
                <?}?>
            </div>
            <div class="match-eventMainInfo clearfix">
                <div class="match-eventTitle<?if ($event[$i]['pg']) {?> match-eventPG<?=$event[$i]['pg']?><?}?>"><?=$event[$i]['firstStr']?></div>
                <div class="match-eventAction"><?=$event[$i]['secStr']?></div>
            </div>
        <?}?>
        <div class="match-eventComment"><?=$event[$i]['comment']?></div>
    </div>
<?}?>