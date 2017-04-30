<table class="stats-table datagrid datagrid_zebra">
    <colgroup>
        <col/>
        <col width="40px"/>
        <col width="40px"/>
        <col width="40px"/>
        <col width="40px"/>
    </colgroup>
    <thead class="datagrid_thead">
    <tr>
        <th>&nbsp;</th>
        <th class="main-rightAlign">%</th>
        <th class="main-rightAlign">тд</th>
        <th class="main-rightAlign">пер</th>
        <th class="main-rightAlign">яр</th>
    </tr>
    </thead>
    <tbody class="datagrid_tbody">
    <?for ($i = 0; $i < count($arr); $i++) {?>
        <tr class="stats-item">
            <td>
                <?=$arr[$i]['surname']. ' '.$arr[$i]['name']?>
            </td>
            <td class="stats-counter main-rightAlign">
                <?=$arr[$i]['rec']?>/<?=$arr[$i]['num']?>
            </td>
            <td class="stats-counter main-rightAlign">
                <?=$arr[$i]['td']?>
            </td>
            <td class="stats-counter main-rightAlign">
                <?=$arr[$i]['inter']?>
            </td>
            <td class="stats-counter main-rightAlign">
                <?=$arr[$i]['sumr']?>
            </td>
        </tr>
    <?}?>
    </tbody>
</table>