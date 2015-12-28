<?php if (count($answer)) { $team = $answer['team']?>
    <div class="main-infoBlock">
        <div class="main-avatar">
            <?if ($team['logo']) {?>
                <img style="width:190px" src="//<?=$HOST?>/upload/<?=$team['logo']?>">
            <?} else {?>
                <div class="main-noPhoto">?</div>
            <?}?>
        </div>

        <div class="main-infoText">
            <div class="main-infoText__right">
                <div class="main-infoText__element">Вид спорта: <?=$team['sport']?></div>
                <div class="main-infoText__element">Пол игроков: <?=($team['sex'] == 2 ? 'Женский' : 'Мужской')?></div>
                <div class="main-infoText__element">Возраст игроков: <?=$team['age']?></div>
                <div class="main-infoText__element">Орг. форма: <?=$team['org_form']?></div>
            </div>
            <div class="main-infoText__left">
                <div class="main-infoText__title"><?=($team['rus_name'] . ' (' . $team['city'] . ')')?></div>
            </div>

        </div>
        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']])) {?>
            <a class="main-editLink" href="/?r=team/edit&team=<?=$_GET['team']?>">Редактировать данные</a>
        <?}?>
    </div>
    <?if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']])) {?>

        <?$comps = $answer['comps']; if (count($comps)) {?>
            <h2>Заявки на турниры</h2>
            <?for ($i = 0; $i < count($comps); $i++){?>
            	<?$host=''; if ($_GET['comp'] != $comps[$i]['id']) $host = '//amfoot.net'?>
                <div class="listview-item"><a href="<?=$host?>/?r=roster/fill&team=<?=$_GET['team']?>&comp=<?=$comps[$i]['id']?>"><?=$comps[$i]['name']?> (<?=$comps[$i]['yearB']?>)</a></div>
            <?}?>
            <br/><br/>
        <?}?>
    <?}?>
    <?if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']])) {?>
    <h2>Контакты</h2>
    <div class="team-infoBlock">
        <div class="team-infoLabel">E-mail</div>
        <div class="team-infoContent"><?=$team['email']?></div>
    </div>
    <div class="team-infoBlock">
        <div class="team-infoLabel">Ссылка Вконтакте</div>
        <div class="team-infoContent"><a target="_blank" href="<?=$team['vk_link']?>"><?=$team['vk_link']?></a></div>
    </div>
    <div class="team-infoBlock">
        <div class="team-infoLabel">Instagram</div>
        <div class="team-infoContent"><?=$team['inst_link']?></div>
    </div>
    <div class="team-infoBlock">
        <div class="team-infoLabel">Twitter</div>
        <div class="team-infoContent"><?=$team['twitter_link']?></div>
    </div>
    <?}?>
<?} else {?>
    Команда не найдена
<?}?>