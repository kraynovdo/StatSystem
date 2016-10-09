<?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']])) {?>
    <h3>
        <a href="/?r=friendlymatch/edit&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Редактировать</a>
    </h3>
<?}?>


<? include ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/match/_score.php')?>