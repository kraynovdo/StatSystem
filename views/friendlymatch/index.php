<?if($_SESSION['userType'] == 3){?>
    <a class="main-addLink" href="/?r=competition/add">Добавить матч</a>
<?}?>
<?$match = $answer; $ctrlMode = false; $viewHref = 'friendlymatch/view'?>
<? include $_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/match/_schedule.php'?>