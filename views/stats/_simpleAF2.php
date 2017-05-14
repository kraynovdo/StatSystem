<table class="stats-table datagrid datagrid_zebra">
    <colgroup>
        <col width="35px"/>
        <col/>
        <?for ($i = 0; $i < count($columns); $i++ ){?>
            <col width="50px"/>
        <?}?>
    </colgroup>
    <thead class="datagrid_thead">
    <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <?for ($i = 0; $i < count($columns); $i++ ){?>
            <th class="main-rightAlign"><?=$columns[$i]['title']?></th>
        <?}?>
    </tr>
    </thead>
    <tbody class="datagrid_tbody">
    <?for ($i = 0; $i < count($arr); $i++) {?>
        <tr class="stats-item">
            <td>
                <div class="stats-teamLogo">
                    <?if ($arr[$i]['avatar']) {?>
                        <img style="width: 35px;" src="//<?=$HOST?>/upload/<?=$arr[$i]['avatar']?>">
                    <?} else {?>
                        <div class="main-noPhoto">?</div>
                    <?}?>
                </div>
            </td>
            <td>
                <?=$arr[$i]['name']. ' '.$arr[$i]['surname']?>
            </td>
            <?for ($j = 0; $j < count($columns); $j++ ){?>
                <td class="stats-counter main-rightAlign">
                    <?=$arr[$i][$columns[$j]['field']]?>
                </td>
            <?}?>
        </tr>
    <?}?>
    </tbody>
</table>