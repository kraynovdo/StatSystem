<?if (!$viewHref) $viewHref='match/view';?>
<table class="datagrid match-grid">
    <colgroup>
        <col/>
        <col/>
        <col width="50px"/>
        <col width="50px"/>
        <col width="50px"/>
        <col/>
        <col width="100px"/>
    <?if ((($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1))  && ($ctrlMode)) {?>
        <col width="170px"/>
    <?}?>
    </colgroup>
    <tbody class="datagrid_tbody">
    <?$prev_date=''?>
    <?php for ($i = 0; $i < count($match); $i++) {?>
        <?if ($prev_date != $match[$i]['date']) {?>
            <?
            $prev_date = $match[$i]['date'];
            $date_arr = explode('-', $match[$i]['date']);
            $date = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
            ?>
            <tr><td colspan=<?if (($_SESSION['userType'] == 3) && ($ctrlMode)) {?>"8"<?} else {?>"7"<?}?> style="font-size: 15px"><?=$date?></td></tr>
        <?}?>
        <tr class="datagrid_datatr">
            <?
            if (!$match[$i]['score1'] && $match[$i]['score1'] !== '0') {
                $score1 = '-';
            }
            else {
                $score1 = $match[$i]['score1'];
            }
            if (!$match[$i]['score2'] && $match[$i]['score2'] !== '0') {
                $score2 = '-';
            }
            else {
                $score2 = $match[$i]['score2'];
            }
            ?>
            <td style="font-size: 10px; color: #aaaaaa;"><?if ($match[$i]['g1'] == $match[$i]['g2']){?><?=$match[$i]['g1name']?><?}?></td>
            <td class="match-rightAl match-team"  style="white-space: nowrap"><?=$match[$i]['t1name']?></td>
            <td class="match-rightAl match-score"><?=$score1?></td>
            <td class="match-centerAl">:</td>
            <td class="match-score"><?=$score2?></td>
            <td class="match-team" style="white-space: nowrap"><?=$match[$i]['t2name']?></td>
            <td class="match-rightAl"><a href="/?r=<?=$viewHref?>&match=<?=$match[$i]['id']?>&comp=<?=$_GET['comp']?>">Подробнее</a></td>
            <?if ((($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1))  && ($ctrlMode)) {?>
                <td>
                    <a href="/?r=match/edit&comp=<?=$_GET['comp']?>&match=<?=$match[$i]['id']?>">Редактировать</a>
                    <a class="main-delLink" href="/?r=match/delete&comp=<?=$_GET['comp']?>&match=<?=$match[$i]['id']?>">Удалить</a>
                </td>
            <?}?>
        </tr>
    <?}?>
    </tbody>
</table>