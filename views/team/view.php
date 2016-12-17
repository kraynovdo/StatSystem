<?php if (count($answer)) { $team = $answer['team']?>
    <div class="main-infoBlock team-infoBlock">
        <div class="main-infoText__title team-infoText__title"><?=$team['rus_name']?></div>
        <span class="main-infoText__value"><?=$team['city']?>, <?=$team['geo_countryTitle']?></span>
        <?if ($team['email']) {?>
            <span class="main-infoText__value">E-mail: <span class="main-infoText__content"><?=$team['email']?></span></span>
        <?}?>
        <?if ($team['vk_link']) {?>
            <span class="main-infoText__value">Ссылка ВК: <a class="main-infoText__content" target="_blank" href="<?=$team['vk_link']?>"><?=$team['vk_link']?></a></span>
        <?}?>
        <?if ($team['inst_link']) {?>
            <span class="main-infoText__value">Instagram: <a class="main-infoText__content" target="_blank" href="<?=$team['inst_link']?>"><?=$team['inst_link']?></a></span>
        <?}?>
        <?if ($team['twitter_link']) {?>
            <span class="main-infoText__value">Twitter: <a class="main-infoText__content" target="_blank" href="<?=$team['twitter_link']?>"><?=$team['twitter_link']?></a></span>
        <?}?>
        <div class="main-infoBlock__footer">
            <?if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']])) {?>
                <a class="main-editLink" href="/?r=team/edit&team=<?=$_GET['team']?>">Редактировать данные</a>
                <a class="main-editLink" href="/?r=team/request&team=<?=$_GET['team']?>">Заявки на турниры</a>
            <?}?>
        </div>
    </div>
    <?if (count($answer['match'])) {?>
        <h2>Календарь игр</h2>
        <?if (count($answer['comps'])) {?>
            <div class="main-fieldWrapper">
                <label>Турнир </label>
                <select class="team-compSelector">
                    <?for ($i = 0; $i < count($answer['comps']); $i++) {?>
                        <option value="<?=$answer['comps'][$i]['id']?>"
                            <?if ($answer['comps'][$i]['id'] == $answer['compId']) {?> selected="selected"<?}?>><?=$answer['comps'][$i]['name']?> <?=$answer['comps'][$i]['yearB']?></option>
                    <?}?>
                </select>
            </div>
        <?}?>
        <?$match = $answer['match']; $ctrlMode = false;?>
        <? include $_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/match/_schedule.php'?>
    <?}?>
<?} else {?>
    Команда не найдена
<?}?>
