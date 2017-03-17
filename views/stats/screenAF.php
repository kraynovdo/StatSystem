<form>
    <div class="main-fieldWrapper">
        <span class="main-tile_rb">
            <input type="radio" name="team" id="team1" class="main-hidden" checked="checked">
            <label class="main-tile" for="team1"><?=$answer['matchInfo']['t1name']?></label>
        </span>
        <span class="main-tile_rb">
            <input type="radio" name="team" id="team2" class="main-hidden">
            <label class="main-tile" for="team2"><?=$answer['matchInfo']['t2name']?></label>
        </span>
    </div>
</form>