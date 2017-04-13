<? $qbCookie = $_COOKIE['stats-' . $_GET['match'] . '-team-' . $team . '-qb']; ?>
<div class="main-fieldWrapper stats-screen_QBChoose" data-id="<?= $team ?>"
     <? if ($team != $teamID) { ?>style="display:none"<? } ?>>
    <label class="main-label_top">Квотербек</label>
    <? for ($i = 0; $i < count($qbRoster); $i++) { ?>
        <span class="main-tile_rb">
                <input data-number="<?= $qbRoster[$i]['number'] ?>"
                    type="radio" name="qb<?= $team ?>" value="<?= $qbRoster[$i]['pid'] ?>"
                       id="qb<?= $team ?>_<?= $qbRoster[$i]['pid'] ?>" class="main-hidden stats-screen_QBRadio"
                    <? if ((!$qbCookie && ($i == 0)) || ($qbCookie == $qbRoster[$i]['pid'])) { ?> checked="checked"<? } ?>/>
                <label for="qb<?= $team ?>_<?= $qbRoster[$i]['pid'] ?>"
                       class="main-tile"><?= $qbRoster[$i]['number'] ?></label>
            </span>
    <? } ?>
<? $qbCookieArr = json_decode(stripcslashes($_COOKIE['stats-' . $_GET['match'] . '-team-' . $team . '-qbArr']), true); ?>
    <? for ($i = 0; $i < count($qbCookieArr); $i++) { ?>
        <span class="main-tile_rb">
                <input data-number="<?= $qbCookieArr[$i]['number'] ?>"
                    type="radio" name="qb<?= $team ?>" value="<?= $qbCookieArr[$i]['id'] ?>"
                       id="qb<?= $team ?>_<?= $qbCookieArr[$i]['id'] ?>" class="main-hidden stats-screen_QBRadio"
                    <? if ((!$qbCookie && ($i == 0)) || ($qbCookie == $qbCookieArr[$i]['id'])) { ?> checked="checked"<? } ?>>
                <label for="qb<?= $team ?>_<?= $qbCookieArr[$i]['id'] ?>"
                       class="main-tile"><?= $qbCookieArr[$i]['number'] ?></label>
            </span>
    <? } ?>
</div>