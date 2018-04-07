<h2>Новости</h2>
<?
$filter = '';
$access = $_SESSION['userType'] == 3;
if ($_GET['comp']) {
    $filter .= '&comp='.$_GET['comp'];
    $access = $_SESSION['userType'] == 3;
}
if ($_GET['team']) {
    $filter .= '&team='.$_GET['team'];
    $access = ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']]);
}

if ($_GET['federation']) {
    $filter .= '&federation='.$_GET['federation'];
    $access = ($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']]);
}
?>
<?if ($access) {?>
    <a class="main-addLink" href="/?r=material/add<?=$filter?>&ret=news">Добавить новость</a>
<?}?>

<div class="listview">
    <?$prev_date=''?>
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <?if ($prev_date != $answer[$i]['date']) {?>
            <?
                $prev_date = $answer[$i]['date'];
                $date_arr = explode('-', $answer[$i]['date']);
                $date = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
            ?>
            <h3><?=$date?></h3>
        <?}?>
        <div class="listview-item">
            <div>
                <a class="news-title" href="/?r=material/view&mater=<?=$answer[$i]['material']?><?=$filter?>&ret=news"><?=$answer[$i]['title']?></a>
            </div>
            <div>
                <?=nl2br($answer[$i]['preview']);?>
            </div>
        </div>
    <?}?>
</div>