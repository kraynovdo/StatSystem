<h2>Документы</h2>
<?if (($_SESSION['userType'] == 3)  || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {?>
    <a class="main-addLink" href="/?r=document/add&federation=<?=$_GET['federation']?>">Добавить документ</a>
<?}?>
<table class="datagrid datagrid_zebra">
    <colgroup>
        <col/>
        <col width="80px"/>
        <?if (($_SESSION['userType'] == 3)  || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {?>
            <col width="80px"/>
        <?}?>
    </colgroup>

    <tbody class="datagrid_tbody">
<?php for ($i = 0; $i < count($answer); $i++) {?>
<tr>
    <td>
        <a target="_blank" href="//<?=$HOST?>/upload/<?=$answer[$i]['link']?>"><?=$answer[$i]['title']?></a>
    </td>
    <td>
        <span class="document-date"><?=common_dateFromSQL($answer[$i]['date'])?></span>
    </td>
    <?if (($_SESSION['userType'] == 3)  || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {?>
        <td>
            <a href="/?r=document/edit&doc=<?=$answer[$i]['id']?>&federation=<?=$_GET['federation']?>">[Ред]</a>
            <a class="main-delLink" href="/?r=document/delete&doc=<?=$answer[$i]['id']?>&federation=<?=$_GET['federation']?>">[X]</a>
        </td>
    <?}?>
</tr>
<?}?>
    </tbody>
</table>