<?if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4) || ($_SESSION['userComp'][$_GET['comp']] == 1) || $hasAccess) {?>
    <h3 class="match-rostercheck"><a href="/?r=matchroster/refcheck&match=<?=$_GET['match']?>&team=<?=$teamID?>&comp=<?=$_GET['comp']?>">Управление составом</a></h3>
<?}?>
<?if (!count($roster)) {?>
    <div>
        Состав не заполнен

    </div>

<?} else {?>

    <h3>
        Игроки

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