<h2>Федерации</h2>
<?if ($_SESSION['userID'] && ($_SESSION['userType'] == 3)) {?>
    <a class="main-addLink" href="/?r=federation/add">Добавить федерацию</a>
<?}?>
<?
    $typeName = array(
        '1' => 'Международные',
        '2' => 'Национальные',
        '3' => 'Межрегиональные',
        '4' => 'Региональные'
    )
?>
<div class="listview">
    <?$type=null;?>
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <?if ($answer[$i]['type'] != $type) {
            $type = $answer[$i]['type'];
            ?>
            <h3 class="federation-typeHeader"><?=$typeName[$type]?></h3>
        <?}?>
        <div class="listview-item">
            <a target="_blank" href="/?r=federation/view&federation=<?=$answer[$i]['id']?>"><?=$answer[$i]['name']?></a>
        </div>
    <?}?>
</div>