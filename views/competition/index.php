<h2>Соревнования</h2>
<div class="listview">
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <?
            if ($answer[$i]['yearB'] == $answer[$i]['yearE'] || !$answer[$i]['yearE']) {
                $year = $answer[$i]['yearB'];
            }
            else {
                $year = $answer[$i]['yearB'] . '/' . $year = $answer[$i]['yearE'];
            }
        ?>
        <div class="listview-item">
<?
    if ($answer[$i]['link']) {
        $href = '//'.$answer[$i]['link'].'.amfoot.ru';
    }
    else {
        $href = '/?r=competition/view&comp='.$answer[$i]['id'];
    }
?>
            <a target="_blank" href="<?=$href?>"><?=$answer[$i]['name'] . ' '.$year?> </a>
        </div>
    <?}?>
</div>