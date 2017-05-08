<?
    include '_head.php';
    $event = $answer['event'];
    $admin = ($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 5);
?>
<h2>Ход игры</h2>

<?$pt = $answer['pointsTable'];?>
<table class="match-pointsTable">
    <tr>
        <td><?=$answer['match']['t1name']?></td>
        <?for ($i = 0; $i < count($pt); $i++ ) {?>
            <td><?=$pt[$i][0]?></td>
        <?}?>
    </tr>
    <tr>
        <td><?=$answer['match']['t2name']?></td>
        <?for ($i = 0; $i < count($pt); $i++ ) {?>
            <td><?=$pt[$i][1]?></td>
        <?}?>
    </tr>
</table>

<?if (($_SESSION['userType'] == 3) && (count($event))) {?>
    <a class="match_shareStat" href="javascript: void(0)" data-id="<?=$_GET['match']?>">
        <?if ($answer['share']) {?>
            Снять с публикации статистику
        <?} else {?>
            Опубликовать статистику
        <?}?>
    </a>
<?}?>
<?include '_eventListAF.php'?>

