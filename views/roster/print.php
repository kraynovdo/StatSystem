<div class="roster-print_head">
    <div class="roster-print_left">

        <h2>Федерация американского футбола России</h2>

        <div class="roster-print_text">Оформлено <span class="print-underline roster-print_date">&nbsp; <?=count($answer['roster'])?></span>игроков</div>
        <div class="roster-print_text">Комиссия по допуску игроков федерации Американского  футбола</div>
        <div class="roster-print_text"><span class="print-underline roster-print_sign">&nbsp;</span>
            <span class="print-underline">(</span><span class="print-underline roster-print_sign">&nbsp;</span><span class="print-underline">)</div>
        <div class="roster-print_text">
            «<span class="print-underline roster-print_date">&nbsp;</span>»
            <span class="print-underline roster-print_sign">&nbsp;</span> <?=date('Y')?> г.
        </div>
    </div>
    <div class="roster-print_right">
        <img class="roster-print_fafr" src="//<?=$HOST?>/themes/img/fafr_logo_print.png"/>
    </div>
</div>
<h1 class="roster-print_mainTitle">Заявочный лист</h1>
<div class="roster-print_text roster-print__subtitle">команды "<?=$answer['team']?>" г. <?=$answer['teamCity']?> участницы турнира "<?=($answer['compinfo']['name'])?> <?print_r($answer['compinfo']['yearB'])?>"</div>
<table class="datagrid roster-print_table">
    <colgroup>
        <col width="50px"/>
        <col width="350px"/>
        <col width="100px"/>
        <col width="220px"/>
        <col/>
        <col width="80px"/>
        <col width="60px"/>
        <col width="50px"/>
        <col width="50px"/>
        <col width="200px"/>
        <col width="220px"/>
    </colgroup>
    <thead class="datagrid_thead">
    <tr>
        <th>№ пп</th>
        <th>Фамилия, имя, отчество (полностью)</th>
        <th>День, месяц, год рождения</th>
        <th>Номер серия паспорта (вписывается от руки)</th>
        <th>Гражданство</th>
        <th>№</th>
        <th>Амплуа</th>
        <th>Рост (см.)</th>
        <th>Вес (кг.)</th>
        <th>Телефон</th>
        <th>Разрешение врача о допуске к соревнованиям (подпись врача и печать)</th>
    </tr>
    </thead>
    <tbody class="datagrid_tbody">
    <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
    </tr>
    <?php for ($i = 0; $i < count($answer['roster']); $i++) {?>
    <?
        if ($answer['roster'][$i]['birthdate'] != '0000-00-00') {
            $birth_arr = explode('-', $answer['roster'][$i]['birthdate']);
            $bitrhdate = $birth_arr[2] . '.' . $birth_arr[1] . '.' . $birth_arr[0];
        }
    ?>
        <tr>
            <td><?=$i+1?></td>
            <td><?=$answer['roster'][$i]['surname'] . ' '. $answer['roster'][$i]['name'] . ' '. $answer['roster'][$i]['patronymic']?></td>
            <td><?=$bitrhdate?></td>
            <td>&nbsp;</td>
            <td><?=$answer['roster'][$i]['geo_countryTitle']?></td>
            <td><?=$answer['roster'][$i]['number']?></td>
            <td><?=$answer['roster'][$i]['pos']?></td>
            <td><?=$answer['roster'][$i]['growth']?></td>
            <td><?=$answer['roster'][$i]['weight']?></td>
            <td><?=$answer['roster'][$i]['phone']?></td>
            <td>&nbsp;</td>
        </tr>
    <?}?>
    </tbody>
</table>
<h1 class="roster-print_mainTitle roster-print_face">Руководящий состав</h1>
<table class="datagrid roster-print_table">
    <colgroup>
        <col width="50px"/>
        <col width="350px"/>
        <col width="400px"/>
        <col width="100px"/>
        <col width="200px"/>
        <col />
    </colgroup>
    <thead class="datagrid_thead">
    <tr>
        <th>№ пп</th>
        <th>Фамилия, имя, отчество (полностью)</th>
        <th>Должность</th>
        <th>День, месяц, год рождения</th>
        <th>Телефон</th>
        <th>Личная подпись</th>
    </tr>
    </thead>
    <tbody class="datagrid_tbody">
    <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
    </tr>
    <?php for ($i = 0; $i < count($answer['face']); $i++) {?>
        <?
        if ($answer['face'][$i]['birthdate'] != '0000-00-00') {
            $birth_arr = explode('-', $answer['face'][$i]['birthdate']);
            $bitrhdate = $birth_arr[2] . '.' . $birth_arr[1] . '.' . $birth_arr[0];
        }
        ?>
        <tr>
            <td><?=$i+1?></td>
            <td><?=$answer['face'][$i]['surname'] . ' '. $answer['face'][$i]['name'] . ' '. $answer['face'][$i]['patronymic']?></td>
            <td><?=$answer['face'][$i]['facetype']?></td>
            <td><?=$bitrhdate?></td>
            <td><?=$answer['face'][$i]['phone']?></td>
            <td>&nbsp;</td>
        </tr>
    <?}?>
    </tbody>
</table>
<table class="roster_signs">
    <colgroup>
        <col width="100px"/>
        <col width="350px"/>
        <col width="300px"/>
        <col width="300px"/>
    </colgroup>
    <tr>
        <td class='roster-align_center'><span class="roster-signs_small">М.П.</span></td>
        <td>Руководитель органа исполнительной власти в области физической культуры и спорта субъекта федерации</td>
        <td><span class="print-underline roster-personsign">&nbsp;</span><br/><span class="roster-signs_small roster-personsign">подпись</span></td>
        <td class='roster-align_center'><br/><span class="roster-signs_small">Ф.И.О</span></td>
    </tr>
</table>
<table class="roster_signs">
    <colgroup>
        <col width="100px"/>
        <col width="250px"/>
        <col width="300px"/>
        <col width="300px"/>
    </colgroup>
    <tr>
        <td class='roster-align_center'><span class="roster-signs_small">М.П.</span></td>
        <td>Руководитель футбольного клуба</td>
        <td><span class="print-underline roster-personsign">&nbsp;</span><br/><span class="roster-signs_small roster-personsign">подпись</span></td>
        <td class='roster-align_center'><br/><span class="roster-signs_small">Ф.И.О</span></td>
    </tr>
    <tr>
        <td class='roster-align_center'>&nbsp;</td>
        <td>Главный тренер команды</td>
        <td><span class="print-underline roster-personsign">&nbsp;</span><br/><span class="roster-signs_small roster-personsign">подпись</span></td>
        <td class='roster-align_center'><br/><span class="roster-signs_small">Ф.И.О</span></td>
    </tr>
</table>

<table class="roster_signs">
    <colgroup>
        <col/>
        <col width="250px"/>
        <col width="300px"/>
        <col width="300px"/>
    </colgroup>
    <tr>
        <td class="roster-align_right">Допущено к соревнованиям</td>
        <td><span class="print-underline roster-personsign">&nbsp;</span><br/><span class="roster-signs_small roster-personsign">прописью</span></td>
        <td>футболистов</td>
    </tr>
    <tr>
        <td class="roster-align_right">Врач</td>
        <td><span class="print-underline roster-personsign">&nbsp;</span><br/><span class="roster-signs_small roster-personsign">Личная подпись и печать</span></td>
        <td class='roster-align_center'><br/><span class="roster-signs_small">Ф.И.О</span></td>
    </tr>
</table>

<a class='print-go' href="javascript: window.print();">Печать</a>