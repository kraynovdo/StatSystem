<?if (!count($roster)) {?>
    <div>
        Состав не заполнен
    </div>
<?} else {?>

    <h2 class="fafr-h2">Игроки</h2>

    <div class="match-roster_logoWrapper">
        <?if ($rlogo) {?>
            <div class="match-roster_logo">
                <img style="width:100%" src="//<?=$HOST?>/upload/<?=$rlogo?>"/>
            </div>
        <?}?>

        <?
        for ($i = 0; $i < count($roster); $i++) {?>
            <div class="match-roster_item <?if($i % 2 == 0){?> match-roster_item_zebra<?}?>">
                <div class="match-roster_photo">
                    <?if ($roster[$i]['avatar']) {?>
                        <img style="width:100%" src="//<?=$HOST?>/upload/<?=$roster[$i]['avatar']?>">
                    <?} else {?>
                        <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
                <div class="match-roster_text">
                    <div class="match-roster_fio match-roster_playerInfo">
                        <a class="match-roster_fioLink fafr-textColor" target="_blank" href="/?r=person/view&person=<?=$roster[$i]['personID']?>"><?=initials($roster[$i])?></a>
                        <span class="match-roster_pos"><?=$roster[$i]['abbr']?></span>
                    </div>
                    <div class="match-roster_playerInfo">
                        <span class="match-roster_number">#<?=$roster[$i]['number']?></span>
                    </div>
                </div>
            </div>
        <?}?>
    <h2 class="fafr-h2">Официальные лица</h2>
    <div class="match-roster_table">

        <?
        for ($i = 0; $i < count($rosterFace); $i++) {?>

            <div class="match-roster_item <?if($i % 2 == 0){?> match-roster_item_zebra<?}?>">
                <div class="match-roster_photo">
                    <?if ($rosterFace[$i]['avatar']) {?>
                        <img style="width:100%" src="//<?=$HOST?>/upload/<?=$rosterFace[$i]['avatar']?>">
                    <?} else {?>
                        <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
                <div class="match-roster_text">
                    <div class="match-roster_fio match-roster_playerInfo"><?=initials($rosterFace[$i])?></div>
                    <div class="match-roster_playerInfo match-roster_playerInfo_face fafr-textAdd">
                        <?=$rosterFace[$i]['facetype']?>
                    </div>
                </div>
            </div>
        <?}?>
    </div>
    <a href="/?r=matchroster/print&team=<?=$teamID?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Печать</a>
<?}?>