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
<a class="news-main" href="/?r=material/view&mater=<?=$newsmain[0]['material']?><?=$filter?>">
    <img alt="Картинка новости" class="news-main_img" src="//<?=$HOST?>/upload/<?=$newsmain[0]['image']?>"/>
    <div class="news-main_title"><?=$newsmain[0]['title']?></div>
</a>