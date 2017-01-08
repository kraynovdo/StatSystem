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
            <?=$answer[$i]['name']?>
        </div>
    <?}?>
</div>