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
        <h3 class="match-rostercheck"><a href="/?r=matchroster/refcheck&match=<?=$_GET['match']?>&team=<?=$teamID?>&comp=<?=$_GET['comp']?>">Проверка состава</a></h3>
    <?}?>
    <h3>
        Игроки
        <?if ($hasAccess) {?>
            <button class="main-btn match-matchroster_addlink" data-match="<?=$_GET['match']?>" data-team="<?=$teamID?>">+</button>
        <?}?>
    </h3>
    <table class="match-mathcroster_table" data-team="<?=$teamID?>">
        <colgroup>
            <col width="20px"/>
            <col/>
            <?if ($hasAccess) {?><col width="100px"<?}?>
        </colgroup>

        <?
        for ($i = 0; $i < count($roster); $i++) {?>
            <tr>
                <td class="match-matchroster_number">#<?=$roster[$i]['number']?></td>
                <td class="match-matchroster_fio"><a target="_blank" href="/?r=person/view&person=<?=$roster[$i]['personID']?>"><?=initials($roster[$i])?></a> (<?=$roster[$i]['abbr']?>)</td>
                <?if ($hasAccess) {?>
                    <td>
                        <a href="javascript: void(0)" class="match-matchroster_edit" data-mr="<?=$roster[$i]['id']?>">[ред]</a>
                        <a href="javascript: void(0)" class="match-matchroster_del" data-mr="<?=$roster[$i]['id']?>">[x]</a>
                    </td>
                <?}?>
            </tr>
        <?}?>
    </table>
    <h3>Официальные лица</h3>
    <table class="match-mathcroster_table">
        <colgroup>
            <col/>
            <col/>
        </colgroup>
        <?
        $roster = $answer['face1'];
        for ($i = 0; $i < count($roster); $i++) {?>

            <tr>
                <td class="match-matchroster_fio"><?=initials($roster[$i])?></td>
                <td class="match-matchroster_fio"><?=$roster[$i]['facetype']?></td>
            </tr>
        <?}?>
    </table>
    <a href="/?r=matchroster/print&team=<?=$teamID?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Печать</a>
<?}?>