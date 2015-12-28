<h2>Новости</h2>
<?if ($_SESSION['userID'] && ($_SESSION['userType'] == 4)) {?>
    <a class="main-addLink" href="/?r=material/add&team=<?=$_GET['id']?>">Добавить новость</a>
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
                <a class="news-title" href="/?r=material/view&id=<?=$answer[$i]['material']?>"><?=$answer[$i]['title']?></a>
            </div>
            <div>
                <?=substr($answer[$i]['content'], 0, 1000). '...';?>
            </div>
        </div>
    <?}?>
</div>