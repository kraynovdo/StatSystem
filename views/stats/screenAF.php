<form>
    <?$teamID = $answer['teamID'];?>
    <input type="hidden" name="match" class="stats-matchId" value="<?=$_GET['match']?>"/>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Владение</label>
        <span class="main-tile_rb">
            <input type="radio" name="team" id="team1" class="main-hidden"
                   value="<?=$answer['matchInfo']['team1']?>"
                <?if ($teamID == $answer['matchInfo']['team1']){?> checked="checked"<?}?>>
            <label class="main-tile" for="team1"><?=$answer['matchInfo']['t1name']?></label>
        </span>
        <span class="main-tile_rb">
            <input type="radio" name="team" id="team2" class="main-hidden"
                   value="<?=$answer['matchInfo']['team2']?>"
                   <?if ($teamID == $answer['matchInfo']['team2']){?> checked="checked"<?}?>>
            <label class="main-tile" for="team2"><?=$answer['matchInfo']['t2name']?></label>
        </span>
    </div>

    <div class="main-fieldWrapper">
        <label class="main-label_top">Квотербек</label>
<?for ($qbRoster = $answer['qbRoster'], $i = 0; $i < count($qbRoster); $i++) {?>
        <span class="main-tile_rb">
            <input type="radio" name="qb" value="<?=$qbRoster[$i]['pid']?>" id="qb<?=$i?>" class="main-hidden"
                <?if ($i == 0){?> checked="checked"<?}?>
                <?if (!$teamCookie || ($teamCookie == $answer['matchInfo']['team1'])){?> checked="checked"<?}?>>
            <label for="qb<?=$i?>" class="main-tile"><?=$qbRoster[$i]['number']?></label>
        </span>
<?}?>
    </div>


    <div class="main-fieldWrapper">
        <label class="main-label_top">Действие</label>
        <?$statconfig = $answer['statconfig'];?>
        <?for ($i = 0; $i < count($statconfig); $i++) {?>
            <div class="main-tile stats-screen_action"
                 data-id="<?=$statconfig[$i]['id']?>"><?=$statconfig[$i]['name']?></div>
        <?}?>
    </div>
</form>