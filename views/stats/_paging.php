<div class="fafr-paging main-paging">
<?
    if ($p_limit && $p_count > $p_limit) {
        $numPages = ceil($p_count / $p_limit);

        for ($i = 1; $i <= $numPages; $i++) {?>
            <a class="fafr-paging_item fafr-textColor main-paging_item<?if ($i == $p_page){?> fafr-bg_dark main-paging_item_active<?}?>"
               href="<?=$p_href.'&page='.$i?>"><?=$i?></a>
        <?}
    }
?>
</div>
