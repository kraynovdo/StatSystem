<h2>Календарь игр</h2>
<?if(($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)){?>
    <a class="main-addLink" href="/?r=match/add&comp=<?=$_GET['comp']?>">Добавить матч</a>
<?}?>
<?$match = $answer; $ctrlMode = true;?>
<? include '_schedule.php'?>