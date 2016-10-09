<div class="match-header">
    <a class="matchview-navigLink" href="/?r=match/view&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Составы и очки</a>
    <a class="matchview-navigLink" href="/?r=protocol/view&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>" target="_blank">Протокол матча</a>
    <?if ($answer['match']['video']) { $video = str_replace("\"", "\\\"", $answer['match']['video']);?>
        <a target="_blank" href="<?=$video?>">Видео</a>
        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['match']['team1']]) || ($_SESSION['userTeams'][$answer['match']['team2']]) || ($_SESSION['userComp'][$_GET['comp']] == 1)){?>
            <a class="match-videoEdit matchview-navigLink" href="javascript: void(0);">(Редактировать ссылку)</a>
        <?}?>
    <?}else{ $video='';?>
        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['match']['team1']]) || ($_SESSION['userTeams'][$answer['match']['team2']]) || ($_SESSION['userComp'][$_GET['comp']] == 1)){?>
            <a class="match-videoEdit matchview-navigLink" href="javascript: void(0);">Добавить ссылку на видео</a>
        <?}?>
    <?}?>
    <?if ($_SESSION['userType'] == 3) {?>
        <a class="matchview-navigLink" href="/?r=match/playbyplay&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Ход игры</a>
        
    <?}?>
    <?if (($_SESSION['userType'] == 3) || ($_GET['comp'] == 41)) {?>
    	<a class="matchview-navigLink" href="/?r=stats/matchAF&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Статистика</a>
    <?}?>
    <form method="POST" action="/?r=match/videoupdate" class="main-hidden match-videoForm">
        <input type="hidden" name="match" value="<?=$_GET['match']?>"/>
        <input type="hidden" name="competition" value="<?=$_GET['comp']?>"/>
        <input class="match-videoField" type="text" name="video" value="<?=$video?>"/>
        <input type="button" class="main-btn main-submit" value="ok"/>
    </form>
</div>
<? include ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/match/_score.php')?>