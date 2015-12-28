<h2>Команды доступные пользователю</h2>
<?if ($_SESSION['userType'] == 3) {?>
    <a class="main-addLink" href="/?r=userteam/add&person=<?=$_GET['person']?>">Добавить команду</a>
<?}?>
<div class="listview">
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <div class="listview-item">
            <a target="_blank" href="/?r=team/view&team=<?=$answer[$i]['team']?>"><?=$answer[$i]['rus_name']?></a>
<?if ($_SESSION['userType'] == 3){?>
            <a href="/?r=userteam/delete&ur=<?=$answer[$i]['id']?>&person=<?=$_GET['person']?>">[X]</a>
<?}?>
        </div>
    <?}?>
</div>