<h2>Мои турниры</h2>
<div class="listview">
    <?php for ($i = 0; $i < count($answer); $i++) {?>
<?
    if ($answer[$i]['link']) {
        $href = '//'.$answer[$i]['link'].'.amfoot.ru/?r=roster/complist';
    }
    else {
        $href = '/?r=roster/complist&comp=' . $answer[$i]['comp'];
    }
?>
        <div class="listview-item">
            <a target="_blank" href="<?=$href?>"><?=$answer[$i]['name']?> <?=$answer[$i]['yearB']?></a>
        </div>
    <?}?>
</div>