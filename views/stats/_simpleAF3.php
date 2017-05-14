<table class="stats-table stats-table_person datagrid datagrid_zebra">
    <colgroup>
        <col/>
        <?for ($i = 0; $i < count($columns); $i++ ){?>
            <col width="60px"/>
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
    <?for ($i = 0; $i < count($arr); $i++) {?>
        <tr class="stats-item">
            <td>
                <?=$statName?>
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