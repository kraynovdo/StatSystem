<h2>Состав</h2>
<?if (count($answer['comps'])) {?>
    <div class="main-fieldWrapper">
    <label>Турнир - </label>
    <select class="team-compSelector">
<?for ($i = 0; $i < count($answer['comps']); $i++) {?>
   <option value="<?=$answer['comps'][$i]['id']?>"
       <?if ($answer['comps'][$i]['id'] == $answer['compId']) {?> selected="selected"<?}?>><?=$answer['comps'][$i]['name']?> <?=$answer['comps'][$i]['yearB']?></option>
<?}?>
    </select>
    </div>
<?}?>
<table class="datagrid roster-view datagrid_zebra">
    <colgroup>
        <col width="500px"/>
        <col width="80px"/>
        <col/>
        <col width="80px"/>
        <col width="60px"/>
        <col width="50px"/>
        <col width="50px"/>

    </colgroup>
    <thead class="datagrid_thead">
    <tr>
        <th></th>
        <th>Д.Р.</th>
        <th>Гражданство</th>
        <th>№ игрока</th>
        <th>Позиция</th>
        <th>Рост</th>
        <th>Вес</th>
    </tr>
    </thead>
    <tbody class="datagrid_tbody">
    <?php for ($i = 0; $i < count($answer['roster']); $i++) {?>

        <?
        if ($answer['roster'][$i]['birthdate'] != '0000-00-00') {
            $birth_arr = explode('-', $answer['roster'][$i]['birthdate']);
            $bitrhdate = $birth_arr[2] . '.' . $birth_arr[1] . '.' . $birth_arr[0];
        }
        ?>
        <tr>
            <td><a target="_blank" href="/?r=person/view&person=<?=$answer['roster'][$i]['person']?>">
                <?=$answer['roster'][$i]['surname']?>
                <?=$answer['roster'][$i]['name']?>
                <?=$answer['roster'][$i]['patronymic']?>
                </a>
            </td>
            <td><?=$bitrhdate?></td>
            <td><?=$answer['roster'][$i]['geo_countryTitle']?></td>
            <td><?=$answer['roster'][$i]['number']?></td>
            <td><?=$answer['roster'][$i]['pos']?></td>
            <td><?=$answer['roster'][$i]['growth']?></td>
            <td><?=$answer['roster'][$i]['weight']?></td>

        </tr>

    <?}?>
    </tbody>
</table>

<h2>Официальные лица</h2>
<table class="datagrid roster-view datagrid_zebra">
    <colgroup>
        <col width="500px"/>
        <col width="80px"/>
        <col/>
    </colgroup>
    <tbody class="datagrid_tbody">
    <?php for ($i = 0; $i < count($answer['face']); $i++) {?>
        <?
        if ($answer['face'][$i]['birthdate'] != '0000-00-00') {
            $birth_arr = explode('-', $answer['face'][$i]['birthdate']);
            $bitrhdate = $birth_arr[2] . '.' . $birth_arr[1] . '.' . $birth_arr[0];
        }
        ?>
        <tr>
            <td><a target="_blank" href="/?r=person/view&person=<?=$answer['face'][$i]['person']?>">
                <?=$answer['face'][$i]['surname']?>
                <?=$answer['face'][$i]['name']?>
                <?=$answer['face'][$i]['patronymic']?></a>
            </td>
            <td><?=$bitrhdate?></td>
            <td><?=$answer['face'][$i]['facetype']?></td>
        </tr>
    <?}?>
    </tbody>
</table>