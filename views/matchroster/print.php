<a class='print-go' href="javascript: window.print();">Печать</a>
<div class="protocol-center">
    <img class="protocol-print_fafr" src="//<?=$HOST?>/themes/img/fafr_logo_print.png"/>
</div>
<h2 class="protocol-center">ФЕДЕРАЦИЯ АМЕРИКАНСКОГО ФУТБОЛА РОССИИ</h2>
<h1 class="protocol-center">ЗАЯВКА НА ИГРУ</h1>
<h1 class="protocol-center">"<?=$answer['compinfo']['name']?> <?=$answer['compinfo']['yearB']?>"</h1>
<br/>
<table class="protocol-table_col2">
    <colgroup>
        <col width="33%"/>
        <col width="33%"/>
        <col width="33%"/>
    </colgroup>
    <tbody>
    <tr>
        <td>КОМАНДА  - <?=$answer['match']['match']['t1name']?></td>
        <td>СОПЕРНИК  - <?=$answer['match']['match']['t2name']?></td>
        <td>ДАТА МАТЧА - <?=common_dateFromSQL($answer['match']['match']['date'])?> <?=$answer['match']['match']['timeh']?>:<?=$answer['match']['match']['timem']?></td>
    </tr>

</table>
<h3>Игроки</h3>
<table class="matchroster-print_table">
    <colgroup>
        <col width="40px"/>
        <col/>

    </colgroup>
    <tr><td>№</td><td>Ф.И.О.</td></tr>
    <?
    $roster = $answer['roster']['answer'];
    function initials($record) {
        return $record['surname'] . ' ' . $record['name'] . ' '. $record['patronymic'];
    }
    for ($i = 0; $i < count($roster); $i++) {?>
        <tr>
            <td class="match-matchroster_number">#<?=$roster[$i]['number']?></td>
            <td class="match-matchroster_fio"><?=initials($roster[$i])?> (<?=$roster[$i]['abbr']?>)</td>
        </tr>
    <?}?>
</table>
<h3>Официальные лица</h3>
<table class="matchroster-print_table">
    <colgroup>
        <col/>
        <col/>

    </colgroup>
    <?
    $roster = $answer['face'];

    for ($i = 0; $i < count($roster); $i++) {?>
        <tr>

            <td class="match-matchroster_fio"><?=initials($roster[$i])?></td>
            <td class="match-matchroster_number"><?=$roster[$i]['facetype']?></td>
        </tr>
    <?}?>
</table>
<table class="protocol-table_col2 matchroster-print_table_center">
    <colgroup>
        <col width="70%"/>
        <col width="30%"/>
    </colgroup>
    <tbody>
    <tr>
        <td>ПРЕДСТАВИТЕЛЬ КОМАНДЫ - _____________________</td>
        <td>ПОДПИСЬ - _________</td>
    </tr>

</table>

Я подтверждаю что:<br/>
1.	Все игроки команды проинформированы, что экипировка должна отвечать требованиям   «Правил игры в футбол» редакцией <?=$answer['compinfo']['yearB']?> года  принятых  IFAF   и Регламента.<br/>
2.	Все игроки команды используют экипировку согласно  требованиям «Правил игры в футбол» редакцией <?=$answer['compinfo']['yearB']?> года  принятых IFAF   и Регламента.<br/>
3.	Все игроки команды проинструктированы, что в течение игры их экипировка должна соответствовать требованиям «Правил игры в футбол» редакцией 2014 года  принятых IFAF   и Регламента и в  случае, если их экипировка пришла в негодность в течение игры, то они обязаны немедленно проинформировать об этом тренерский состав команды.<br/>
4.	Все вышеперечисленные в заявке люди являются представителями команды в данной игре.<br/>
