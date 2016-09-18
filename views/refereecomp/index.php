<h2>Судьи</h2>
<?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
    <div class="main-fieldWrapper">
        <button class="referee-compAddBtn main-btn roster-submit">Добавить</button>
    </div>
    <form class="referee-compAddForm main-hidden" action="/?r=refereecomp/create" method="post">
        <input name="competition" type="hidden" value="<?=$_GET['comp']?>"/>
        <div class="main-fieldWrapper">
            <select class="referee-compAddField" name="referee">
            <?php for ($i = 0; $i < count($answer['all']); $i++) {?>
                <option value="<?=$answer['all'][$i]['refid']?>"><?=implode(' ', array($answer['all'][$i]['surname'], $answer['all'][$i]['name'], $answer['all'][$i]['patronymic']))?></option>
            <?}?>
            </select>
        </div>
        <div class="main-fieldWrapper">
            <label>
                <input type="checkbox" name="main"/>
                Главный судья соревнований
            </label>
        </div>
        <div class="main-fieldWrapper">
            <input type="button" class="main-btn main-submit" value="ок"/>
        </div>
    </form>
<?}?>
<table class="datagrid roster-view datagrid_zebra">
    <colgroup>
        <col width="60px"/>
        <?if (!$IS_MOBILE) {?>
            <col/>
            <col width="80px"/>
            <col width="80px"/>
            <?if ($_SESSION['userType'] == 3) {?>
                <col width="50px"/>
            <?}?>
        <?} else {?>
            <col/>
        <?}?>
    </colgroup>
    <tbody class="datagrid_tbody">
    <?php for ($i = 0; $i < count($answer['referee']); $i++) {?>
        <tr>
            <td>
                <?if ($answer['referee'][$i]['avatar']) {?>
                    <a class="referee-clAvatar" target="_blank" href="/?r=person/view&person=<?=$answer['referee'][$i]['id']?><?=$filter?>">
                        <img style="width:50px" src="//<?=$HOST?>/upload/<?=$answer['referee'][$i]['avatar']?>">
                    </a>
                <?} else {?>
                    <a class="referee-clAvatar" target="_blank" href="/?r=person/view&person=<?=$answer['referee'][$i]['id']?><?=$filter?>">
                        <div class="main-noPhoto">?</div>
                    </a>
                <?}?>
            </td>
            <?if (!$IS_MOBILE) {?>
                <td>
                    <a target="_blank" href="/?r=person/view&person=<?=$answer['referee'][$i]['id']?>"><?=implode(' ', array($answer['referee'][$i]['surname'], $answer['referee'][$i]['name'], $answer['referee'][$i]['patronymic']))?></a>
                </td>
                <td>
                    <?=common_dateFromSQL($answer['referee'][$i]['birthdate'])?>
                </td>
                <td>
                    <?=$answer['referee'][$i]['country']?>
                </td>
                <?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
                    <td>
                        <a class="main-dellink" href="/?r=refereecomp/delete&rc=<?=$answer['referee'][$i]['rc']?>&comp=<?=$_GET['comp']?>">[X]</a>
                    </td>
                <?}?>
            <?} else {?>
                <td>
                    <div>
                        <a target="_blank" href="/?r=person/view&person=<?=$answer['referee'][$i]['id']?>"><?=implode(' ', array($answer['referee'][$i]['surname'], $answer['referee'][$i]['name'], $answer['referee'][$i]['patronymic']))?></a>
                        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
                            <a class="main-dellink refereecomp-dellink_m" href="/?r=refereecomp/delete&rc=<?=$answer['referee'][$i]['rc']?>&comp=<?=$_GET['comp']?>">[X]</a>
                        <?}?>
                    </div>
                    <?=common_dateFromSQL($answer['referee'][$i]['birthdate'])?>
                    <?=$answer['referee'][$i]['country']?>

                </td>
            <?}?>
        </tr>
    <?}?>
    </tbody>
</table>