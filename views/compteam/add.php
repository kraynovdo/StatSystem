<h2>Добавление команды</h2>
<form action="/?r=compteam/create" method="POST">
    <input type="hidden" value="<?=$_GET['comp']?>" name="comp"/>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Команда</label>
        <select name="team" data-validate="req">
            <option value="">-Выберите команду-</option>
            <?
            $team = $answer['team'];

            for ($i = 0; $i < count($team); $i++) {
                $age = '';
                if ($team[$i]['age'] != 'Взрослые') {
                    $age = ', ' . $team[$i]['age'] . '';
                }
                ?>
                <option value="<?=$team[$i]['id']?>"><?=$team[$i]['rus_name']?> (<?=$team[$i]['city']?><?=$age?>)</option>
            <?   }?>
        </select>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Группа</label>
        <?$group = $answer['group'];?>
        <select name="group"<?if (count($group)){?> data-validate="req"<?}?>>
            <option value="">-Выберите группу-</option>



            <?for ($i = 0; $i < count($group); $i++) {?>
                <option value="<?=$group[$i]['id']?>"><?=$group[$i]['name']?></option>
            <?   }?>
        </select>
    </div>
    <input class="main-btn main-submit" type="button" value="Сохранить"/>
</form>