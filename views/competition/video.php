<div class="fafr-minWidth fafr-maxWidth">
    <?if ($_SESSION['userType'] == 3) {?>
        <a class="fafr-link main-addLink" href="/?r=video/edit&comp=<?=$_GET['comp']?>">Добавить видео</a>
    <?}?>

    <?php
    print_r($answer);
    ?>
</div>

