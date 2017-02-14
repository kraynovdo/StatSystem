<div class="request-print_wrapper">
    <div class="request-print_fafr">
        В Комитет по организации и проведению соревнований Федерации Американского Футбола России
    </div>
</div>
<?
    $compStr = 'турнире ' . $answer['comp'];
    if ($answer['comp'] == 'Лига Американского Футбола') {
        $compStr = 'открытом Чемпионате России (Лига Американского Футбола)';
    }
?>
<div class="request-print_mainText">
    <div>Клуб по Американскому Футболу "<strong><?=$answer['city_adj'] . ' ' . $answer['rus_name']?></strong>" планирует принять участие в
    <?=$compStr?> в <?=$answer['yearB']?> году.</div>
    <div>Выполнение условий регламента гарантируем.</div>
</div>

<div class="request-print_sign">
    <div class="request-print_facetype"><?=$answer['facetype']?></div>
    <div class="request-print_right">
        <span class="print-underline request-print_fio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <span class="request-print_fio"><?=$answer['surname'].' '.$answer['name'].' '.$answer['patronymic']?></span>
        <div class="request-print_hint">(печать и подпись)</div>
    </div>
</div>