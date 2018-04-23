<?if (!count($roster)) {?>
    <div>
        Состав не заполнен
        <?if ($hasAccess) {?>
            <button class="main-btn match-matchroster_addlink" data-match="<?=$_GET['match']?>" data-team="<?=$teamID?>">+</button>
        <?}?>
    </div>
    <?if ($hasAccess) {?>
        <a href="/?r=matchroster/autofill&match=<?=$_GET['match']?>&team=<?=$teamID?>">Заполнить автоматически</a>
    <?}?>
<?} else {?>
    <?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
        <h3 class="match-rostercheck"><a href="/?r=matchroster/refcheck&match=<?=$_GET['match']?>&team=<?=$teamID?>&comp=<?=$_GET['comp']?>">Управление составом</a></h3>
    <?}?>
    <h3>
        Игроки
        <?if ($hasAccess) {?>
            <button class="main-btn match-matchroster_addlink" data-match="<?=$_GET['match']?>" data-team="<?=$teamID?>">+</button>
        <?}?>
    </h3>
    <div class="match-mathcroster_table" data-team="<?=$teamID?>">


        <?
        for ($i = 0; $i < count($roster); $i++) {?>
            <div class="match-matchroster_item">

                <div class="match-matchroster_fio">
                    <a class="match-matchroster_fioLink" target="_blank" href="/?r=person/view&person=<?=$roster[$i]['personID']?>"><?=initials($roster[$i])?></a>
                </div>
                <div class="match-matchroster_playerInfo">
                    <span class="match-matchroster_number"><?=$roster[$i]['number']?></span>
                    <span class="match-matchroster_pos"><?=$roster[$i]['abbr']?></span>
                    <?if ($hasAccess) {?>
                        <span class="match-matchroster_ctrl">
                            <a href="javascript: void(0)" class="match-matchroster_edit" data-mr="<?=$roster[$i]['id']?>">[ред]</a>
                            <a href="javascript: void(0)" class="match-matchroster_del" data-mr="<?=$roster[$i]['id']?>">[x]</a>
                        </span>
                    <?}?>
                </div>
            </div>
        <?}?>
    <h3>Официальные лица</h3>
    <div class="match-mathcroster_table" data-team="<?=$teamID?>">

        <?
        for ($i = 0; $i < count($rosterFace); $i++) {?>
            <div class="match-matchroster_item">
                <div class="match-matchroster_fio"><?=initials($rosterFace[$i])?></div>
                <div class="match-matchroster_playerInfo match-matchroster_playerInfo_face">
                    <?=$rosterFace[$i]['facetype']?>
                </div>
            </div>
        <?}?>
    </div>
    <a href="/?r=matchroster/print&team=<?=$teamID?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Печать</a>
<?}?>