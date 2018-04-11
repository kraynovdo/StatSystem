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
<?
    $p_href='/?r=stats/compAF&comp='.$_GET['comp'].'&type='.$_GET['type'];
    if ($p_ret) {
        $p_href='/?r=' . $p_ret . '&comp='.$_GET['comp'].'&type='.$_GET['type'];
    }

?>
<? include '_paging.php';?>
<table class="stats-table fafr-text datagrid datagrid_zebra">
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
            <th class="fafr-rightAl main-rightAlign fafr-textAdd"><?=$columns[$i]['title']?></th>
        <?}?>
    </tr>
    </thead>
    <tbody class="datagrid_tbody">
    <?for ($i = $startPos; $i < $endPos; $i++) {?>
        <tr class="stats-item">
            <td style="position: relative">
                <div class="stats-teamLogo">
                    <?if ($arr[$i]['avatar']) {?>
                        <img style="width: 35px;" src="//<?=$HOST?>/upload/<?=$arr[$i]['avatar']?>">
                    <?} else {?>
                        <div class="main-noPhoto">?</div>
                    <?}?>
                </div>
                <div class="stats-personTeamLogo">
                    <?if ($arr[$i]['logo']) {?>
                        <img style="width: 20px;" src="//<?=$HOST?>/upload/<?=$arr[$i]['logo']?>">
                    <?} else {?>
                        <div class="main-noPhoto">?</div>
                    <?}?>
                </div>
            </td>
            <td>
                <div class="stats-personTeamLogoDesk fafr-middleValign main-middleValign">
                    <?if ($arr[$i]['logo']) {?>
                        <img style="width: 20px;" src="//<?=$HOST?>/upload/<?=$arr[$i]['logo']?>">
                    <?} else {?>
                        <div class="main-noPhoto">?</div>
                    <?}?>
                </div>

                <a class="stats-personLink fafr-textColor fafr-middleValign main-middleValign" href="/?r=person/view&person=<?=$arr[$i]['id']?>&comp=<?=$_GET['comp']?>">
                    <?=$arr[$i]['name']. ' '.$arr[$i]['surname'] . ' (' . ($i+1) . ')'?>
                </a>
            </td>
            <?for ($j = 0; $j < count($columns); $j++ ){?>
                <td class="stats-counter fafr-rightAl main-rightAlign">
                    <?=$arr[$i][$columns[$j]['field']]?>
                </td>
            <?}?>
        </tr>
    <?}?>
    </tbody>
</table>
<? include '_paging.php';?>