<div class="main-infoBlock main-infoBlock_results">

    <br/><h2 style="text-align: center">Результаты матчей</h2>
    <div class="comp-resultsTable">
<?
    $res = $answer['results'];
    for ($i = count($res) - 1; $i >= 0 ; $i--) {
        if (!$res[$i]['score1'] && $res[$i]['score1'] != '0') {
            $score1 = '-';
        }
        else {
            $score1 = $res[$i]['score1'];
        }
        if (!$res[$i]['score2'] && $res[$i]['score2'] != '0') {
            $score2 = '-';
        }
        else {
            $score2 = $res[$i]['score2'];
        }
?>
    <a target="_blank" class="comp-resultsTable_match" href="/?r=match/view&match=<?=$res[$i]['id']?>&comp=<?=$_GET['comp']?>">
        <div class="comp-resultsTable_datetime">
            <?=common_dateFromSQL($res[$i]['date'])?>
            <?if (strlen($res[$i]['timeh']) && strlen($res[$i]['timeh'])) {?>
                <?=$res[$i]['timeh']?>:<?=$res[$i]['timem']?> (мск)
            <?}?>
        </div>
        <div class="comp-resultsTable_row">
            <div class="comp-resultsTable_score"><?=$score1?></div>
            <div class="comp-resultsTable_team">
                <?if (!$IS_MOBILE) {?>
                    <?=$res[$i]['t1name']?>
                <?} else {?>
                    <?=$res[$i]['t1abbr']?>
                <?}?>
            </div>
        </div>
        <div class="comp-resultsTable_row">
            <div class="comp-resultsTable_score"><?=$score2?></div>
            <div class="comp-resultsTable_team">
                <?if (!$IS_MOBILE) {?>
                    <?=$res[$i]['t2name']?>
                <?} else {?>
                    <?=$res[$i]['t2abbr']?>
                <?}?>
            </div>
        </div>
    </a>
<?}?>

        </div>
        <?if($_GET['comp'] == 18){?><h2><a href="/?r=standings">Сетка плей-офф</a></h2><?}?>
    </div>
    <br/>
    <div>
        <?if ($_SESSION['userType'] == 3) {?>
            <div style="text-align: center">
                <a href="/?r=translation/edit&comp=<?=$_GET['comp']?>">Добавить трансляцию</a>
            </div>
        <?}?>
<?
    $trans = $answer['trans'];
    if (count($trans)) {?>
        <h1>Трансляции online</h1>
        <?
            for ($i = 0; $i < count($trans); $i++) {?>
            <h2><?=$trans[$i]['title']?></h2>
                <?if ($_SESSION['userType'] == 3){?>
                    <div style="text-align: right">
                        <a href="/?r=translation/edit&trans=<?=$trans[$i]['id']?>&comp=<?=$_GET['comp']?>">Ред</a>
                        <a class="main-delLink" href="/?r=translation/delete&trans=<?=$trans[$i]['id']?>&comp=<?=$_GET['comp']?>">[x]</a>
                    </div>
                <?}?>
                <?
                    $link = $trans[$i]['link'];
                    $link = str_replace("\\\"", "\"", $link);
                    echo $link;

                ?><br/><br/>
        <?  }?>
<?  }?>
        <div class="top10">
        <?if (count($answer['top10'])) {?>
<div class="top10_column<?if (count($answer['top10kick'])) {?> top10_column_2<?}?>">
<?$top = $answer['top10'];?>

    <div class="main-card">
    <?if (count($top)){?><h2 style="text-align: center;">ТОП по набранным очкам</h2><?}?>
        <? include '_top.php'?>
    </div>
	</div>
	<?}?>

	<?if (count($answer['top10kick'])) {?>
	<div class="top10_column top10_column_2">
	<?$top = $answer['top10kick'];?>
    <div class="main-card">
	<h2 style="text-align: center;">ТОП кикеров по очкам</h2>
        <? include '_top.php'?>
    </div>
</div>
<?}?>
    </div>


    </div>