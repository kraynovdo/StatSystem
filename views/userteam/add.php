<?$team = $answer?>
<form method="POST" action="/?r=userteam/create">
    <input type="hidden" name="person" value="<?=$_GET['person']?>"/>
    <div>
        <select name="team" data-validate="req" class="userteam_team">
            <option value="">Выберите команду</option>
            <?; for($i = 0; $i < count($team); $i++) {?>
                <option value="<?=$team[$i]['id']?>"><?=$team[$i]['rus_name']?></option>
            <?}?>
        </select>
    </div>
    <input type="button" class="main-btn main-submit" value="Добавить"/>
</form>
