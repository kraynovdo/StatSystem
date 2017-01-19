<?if (count($answer['newsmain'])) {?>
    <?
        $newsmain = $answer['newsmain'];
        include ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/news/_main.php')
    ?>
<?}?>
<?
    $news = $answer['news'];
    include ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/news/_list.php')
?>