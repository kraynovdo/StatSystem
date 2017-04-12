<div class="stats-screen_screen stats-screen_screenRoster" data-id="<?= $team ?>" style="display:none">
    <div class="main-fieldWrapper">
        <label class="main-label_top">Выберите игрока</label>
        <input class="main-tile stats-screen_success stats-screen_rosterOk" type="button" value="Выбрать"/>
        <input class="main-tile stats-screen_cancel stats-screen_rosterCancel" type="button" value="Отмена"/>
        <div class="stats-screen_screenContent">
            <? foreach ($fullRoster as $index => $curRoster) { ?>
                <div class="stats-screen_screenRosterBlock" data-id="<?= $index ?>">
                    <? for ($i = 0, $pos = NULL; $i < count($curRoster); $i++) { ?>
                        <? if ($curRoster[$i]['pos'] != $pos) {
                            $pos = $curRoster[$i]['pos']; ?>
                            <div class="stats-screen_group main-centerAlign">
                        <span class="stats-screen_groupContent">
                            <?= $curRoster[$i]['pos'] ?>
                        </span>
                            </div>
                        <? } ?>
                        <span class="main-tile_rb">
                <input type="radio" name="player<?= $team ?>" value="<?= $curRoster[$i]['pid'] ?>"
                       id="player<?= $team ?>_<?= $curRoster[$i]['pid'] ?>"
                       class="main-hidden" data-number="<?= $curRoster[$i]['number']?>"/>
                <label for="player<?= $team ?>_<?= $curRoster[$i]['pid'] ?>"
                       class="main-tile"><?= $curRoster[$i]['number'] ?></label>
            </span>
                    <? } ?>
                </div>
            <? } ?>
        </div>
        <input class="main-tile stats-screen_success stats-screen_rosterOk" type="button" value="Выбрать"/>
        <input class="main-tile stats-screen_cancel stats-screen_rosterCancel" type="button" value="Отмена"/>
    </div>
</div>