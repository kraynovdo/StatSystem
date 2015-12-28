<h2>Календарь игр</h2>
<?if($_SESSION['userType'] == 3){?>
    <a class="main-addLink" href="/?r=match/add&comp=<?=$_GET['comp']?>">Добавить матч</a>
<?}?>
<table class="datagrid match-grid">
    <colgroup>
        <col/>
        <col width="50px"/>
        <col width="50px"/>
        <col width="50px"/>
        <col/>
        <col width="100px"/>
<?if ($_SESSION['userType'] == 3) {?>
    <col width="170px"/>
<?}?>
    </colgroup>
    <tbody class="datagrid_tbody">
    <?$prev_date=''?>
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <?if ($prev_date != $answer[$i]['date']) {?>
            <?
            $prev_date = $answer[$i]['date'];
            $date_arr = explode('-', $answer[$i]['date']);
            $date = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
            ?>
            <tr><td colspan="6"><?=$date?></td></tr>
        <?}?>
        <tr class="datagrid_datatr">
            <?
                if (!$answer[$i]['score1'] && $answer[$i]['score1'] !== '0') {
                    $score1 = '-';
                }
                else {
                    $score1 = $answer[$i]['score1'];
                }
                if (!$answer[$i]['score2'] && $answer[$i]['score2'] !== '0') {
                    $score2 = '-';
                }
                else {
                    $score2 = $answer[$i]['score2'];
                }
            ?>

            <td class="match-rightAl match-team"><?=$answer[$i]['t1name']?></td>
            <td class="match-rightAl match-score"><?=$score1?></td>
            <td class="match-centerAl">:</td>
            <td class="match-score"><?=$score2?></td>
            <td class="match-team"><?=$answer[$i]['t2name']?></td>
            <td class="match-rightAl"><a href="/?r=match/view&match=<?=$answer[$i]['id']?>&comp=<?=$_GET['comp']?>">Подробнее</a></td>
            <?if ($_SESSION['userType'] == 3) {?>
                <td>
                    <a href="/?r=match/edit&comp=<?=$_GET['comp']?>&match=<?=$answer[$i]['id']?>">Редактировать</a>
                    <a class="main-delLink" href="/?r=match/delete&comp=<?=$_GET['comp']?>&match=<?=$answer[$i]['id']?>">Удалить</a>
                </td>
            <?}?>
        </tr>
    <?}?>
    </tbody>
</table>