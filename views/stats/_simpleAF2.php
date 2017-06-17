<table class="stats-table datagrid datagrid_zebra">
    <colgroup>
        <col width="35px"/>
        <col/>
        <?for ($i = 0; $i < count($columns); $i++ ){?>
            <col class="stats-counterCol" width="50px"/>
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
    <?
        $startPos = 0;
        $p_count = count($arr);
        $endPos = $p_count;
        if ($p_page) {
            $startPos = ($p_page - 1) * $p_limit;
            if ($endPos > $startPos + $p_limit) {
                $endPos = $startPos + $p_limit;
            }
        }

    ?>
    <?for ($i = $startPos; $i < $endPos; $i++) {?>
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
                <a class="stats-personLink" href="/?r=person/view&person=<?=$arr[$i]['id']?>&comp=<?=$_GET['comp']?>">
                    <?=$arr[$i]['name']. ' '.$arr[$i]['surname'] . ' (' . ($i+1) . ')'?>
                </a>
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
<? include '_paging.php';?>