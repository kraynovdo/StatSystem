<table class="stats-table datagrid datagrid_zebra">
    <colgroup>
        <col/>
        <?for ($i = 0; $i < count($columns); $i++ ){?>
        <col class="stats-counterCol" width="50px"/>
        <?}?>
    </colgroup>
    <thead class="datagrid_thead">
    <tr>
        <th>&nbsp;</th>
        <?for ($i = 0; $i < count($columns); $i++ ){?>
            <th class="main-rightAlign"><?=$columns[$i]['title']?></th>
        <?}?>
    </tr>
    </thead>
    <tbody class="datagrid_tbody">
    <?$sumArr = array()?>
    <?for ($i = 0; $i < count($arr); $i++) {?>
        <tr class="stats-item">
            <td>
                <a class="stats-personLink" href="/?r=person/view&person=<?=$arr[$i]['id']?>&comp=<?=$_GET['comp']?>"><?=$arr[$i]['name']. ' '.$arr[$i]['surname']?></a>
            </td>
            <?for ($j = 0; $j < count($columns); $j++ ){?>
                <td class="stats-counter main-rightAlign">
                    <?=$arr[$i][$columns[$j]['field']]?>
                </td>
                <?if (in_array($columns[$j]['field'], $sum)) {?>
                    <?if (!($sumArr[$columns[$j]['field']])) $sumArr[$columns[$j]['field']] = 0;?>
                    <?$sumArr[$columns[$j]['field']] += $arr[$i][$columns[$j]['field']]?>
                <?}?>
            <?}?>


        </tr>
    <?}?>
    <?if (count($sumArr)) {?>
    <tr class="stats-item_total">
        <td>ВСЕГО</td>
        <?for ($j = 0; $j < count($columns); $j++ ){?>
            <?if (in_array($columns[$j]['field'], $sum)) {?>
                <td class="stats-counter main-rightAlign">
                    <?=$sumArr[$columns[$j]['field']]?>
                </td>
            <?} else {?>
                <td></td>
            <?}?>
        <?}?>
    </tr>
    <?}?>
    </tbody>
</table>