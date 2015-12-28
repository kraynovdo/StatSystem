<a class='print-go' href="javascript: window.print();">Печать</a>
<?
/*TODO года*/
$year = 2015;
$active = '1.11.2015';
?>
<table class="roster-tablecard"><tr>
<?php for ($i = 0; $i < count($answer['roster']); $i++) { ?>
    <?
    if ($answer['roster'][$i]['birthdate'] != '0000-00-00') {
        $birth_arr = explode('-', $answer['roster'][$i]['birthdate']);
        $bitrhdate = $birth_arr[2] . '.' . $birth_arr[1] . '.' . $birth_arr[0];
    }
    ?>
    <td>
        <div class='roster-card'>
            <img class="roster-card__year" src="//<?=$HOST?>/themes/img/year.png"/>
            <img class="roster-card__map" src="//<?=$HOST?>/themes/img/russiamap.png"/>
            <table class="roster-card_table">
                <colgroup>
                    <col width="100px"/>
                    <col/>
                </colgroup>
                <tr class="roster-card_firstrow">
                    <td><img style="width:100px" src="//<?=$HOST?>/themes/img/fafr_logo_print.png""</td>
                    <td class="roster-card_rightcol">
                        <h1 class="roster-card_topheader">Удостоверение</h1>
                        <h3 class="roster-card_topsubheader">футболиста<br/>федерации американского футбола россии</h3>
                    </td>
                </tr>
                <tr>
                    <td><div class="roster-card_avatar"><img style="width:100px" src="//<?=$HOST?>/upload/<?=$answer['roster'][$i]['avatar']?>"/></div></td>
                    <td class="roster-card_rightcol">
                        <div class="roster-card_fio"><?=$answer['roster'][$i]['surname']?></div>
                        <div class="roster-card_fio"><?=$answer['roster'][$i]['name']?></div>
                        <div class="roster-card_fio"><?=$answer['roster'][$i]['patronymic']?></div>
                        <div class="roster-card_info">д.р.:   <?=$bitrhdate?></div>
                        <div class="roster-card_info">клуб:   <?=$answer['teamRec']['rus_name']?></div>
                        <div class="roster-card_info">город:   <?=$answer['teamRec']['city']?></div>
                        <div class="roster-card_info">действителен до:   <?=$active?></div>
                        <div class="roster-card_info roster-card_pres">президент фафр</div>
                    </td>
                </tr>
            </table>
        </div>
    </td>
    <?if (($i > 0) && (($i + 1) % 9 == 0)) {?>
        </tr></table><table class="roster-tablecard"><tr>
    <?}?>
    <?if (($i > 0) && (($i + 1) % 3 == 0)) {?>
        </tr><tr>
    <?}?>

<?}?>
    </tr>
</table>