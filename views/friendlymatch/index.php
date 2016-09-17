<h2>Товарищеские матчи</h2>
<table class="datagrid match-grid">
    <colgroup>
        <col/>
        <col width="50px"/>
        <col width="50px"/>
        <col/>
        <col width="100px"/>
    </colgroup>
    <tbody class="datagrid_tbody">
    <?$prev_date=''?>
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <?if ($prev_date != $answer[$i]['date']) {?>
            <?
            $prev_date = $answer[$i]['date'];
            $date = common_dateFromSQL($answer[$i]['date']);
            ?>
            <tr><td colspan="7" style="font-size: 15px"><?=$date?></td></tr>
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
            <td class="match-rightAl match-team"  style="white-space: nowrap"><?=$answer[$i]['t1name']?></td>
            <td class="match-rightAl match-score"><?=$score1?></td>
            <td class="match-centerAl">:</td>
            <td class="match-score"><?=$score2?></td>
            <td class="match-team" style="white-space: nowrap"><?=$answer[$i]['t2name']?></td>
            <td class="match-rightAl"><a href="/?r=friendlymatch/view&match=<?=$answer[$i]['id']?>&comp=<?=$answer[$i]['comp']?>">Подробнее</a></td>
        </tr>
    <?}?>
    </tbody>
</table>