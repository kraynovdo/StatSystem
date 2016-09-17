<table class="stats-table datagrid datagrid_zebra">
    <colgroup>
        <col width="35px"/>
        <col/>
        <col width="60px"/>
        <col width="60px"/>
        <col width="60px"/>
        <col width="80px"/>
    </colgroup>
    <thead class="datagrid_thead">
    <tr>
        <th></th>
        <th>Игрок</th>
        <th class="main-rightAlign">Попыток</th>
        <th class="main-rightAlign">Принято</th>
        <th class="main-rightAlign">Тачдауны</th>
        <th class="main-rightAlign">Перехваты</th>
        <th class="main-rightAlign">Ярды</th>
    </tr>
    </thead>
    <tbody class="datagrid_tbody">
    <?for ($i = 0; $i < count($arr); $i++) {?>
        <tr class="stats-item">
            <td>
                <div class="stats-teamLogo">
                    <?if ($arr[$i]['logo']) {?>
                        <img style="width: 35px;" src="//<?=$HOST?>/upload/<?=$arr[$i]['logo']?>">
                    <?} else {?>
                        <div class="main-noPhoto">?</div>
                    <?}?>
                </div>
            </td>
            <td>
                <?=$arr[$i]['surname']. ' '.$arr[$i]['name']?>
            </td>
            <td class="stats-counter main-rightAlign">
                <?=$arr[$i]['num']?>
            </td>
            <td class="stats-counter main-rightAlign">
                <?=$arr[$i]['rec']?>
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