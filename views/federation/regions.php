<?
$typeName = array(
    '1' => 'Международные',
    '2' => 'Национальные',
    '3' => 'Межрегиональные',
    '4' => 'Региональные'
)
?>
<div class="federation-regions">
    <?$type=null;?>
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <div class="federation-regions-item">
            <div class="federation-regions-logo">
                <?if ($answer[$i]['logo']) {?>
                    <img alt="Логотип федерации" style="width:85px" src="//<?=$HOST?>/upload/<?=$answer[$i]['logo']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </div>
            <div class="federation-regions-count">
                <div class="federation-regions-row">
                    <span class="federation-regions-cell federation-regions-cellTitle"></span>
                    <span class="federation-regions-cell federation-regions-cellCountTitle">М</span>
                    <span class="federation-regions-cell federation-regions-cellCountTitle">Ж</span>
                    <span class="federation-regions-cell federation-regions-cellCountTitle">Ю</span>
                </div>
                <div class="federation-regions-row">
                    <span class="federation-regions-cell federation-regions-cellTitle">Команды</span>
                    <span class="federation-regions-cell federation-regions-cellCount"><?=$answer[$i]['m']?></span>
                    <span class="federation-regions-cell federation-regions-cellCount"><?=$answer[$i]['w']?></span>
                    <span class="federation-regions-cell federation-regions-cellCount"><?=$answer[$i]['u']?></span>
                </div>
            </div>
            <div class="federation-regions-name">
                <div class="federation-regions-fullname"><?=$answer[$i]['fullname']?></div>
                <div class="federation-regions-abbr"><?=$answer[$i]['name']?></div>
            </div>

        </div>
    <?}?>
</div>