<h2>Календарь игр</h2>
<?if (count($answer['group'])) {?>
<div class="main-fieldWrapper">
    <label>Группа </label>
    <select class="match-groupSelector">
        <option value="">- Все -</option>
        <?for ($i = 0; $i < count($answer['group']); $i++) {?>
            <option value="<?=$answer['group'][$i]['id']?>"
                <?if ($answer['group'][$i]['id'] == $_GET['group']) {?> selected="selected"<?}?>><?=$answer['group'][$i]['name']?></option>
        <?}?>
    </select>
</div>
<?}?>
<?if(($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)){?>
    <a class="main-addLink" href="/?r=match/add&ret=match&comp=<?=$_GET['comp']?>">Добавить матч</a>
<?}?>
<?$match = $answer['match']; $ctrlMode = 'match';?>
<? include '_schedule.php'?>