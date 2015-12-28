<a class='print-go' href="javascript: window.print();">Печать</a>
<?
    $marks = array(
        3 => 'Удовл.',
        4 => 'Хорошо',
        5 => 'Отлично'
    )
?>
<div class="protocol-print">
    <?if ($_GET['comp'] == 1) {?>
    <div class="protocol-center">
        <img class="protocol-print_fafr" src="//<?=$HOST?>/themes/img/fafr_logo_print.png"/>
    </div>
    <h2 class="protocol-center">ФЕДЕРАЦИЯ АМЕРИКАНСКОГО ФУТБОЛА РОССИИ</h2>
    <h2 class="protocol-center">СУДЕЙСКИЙ КОМИТЕТ</h2>
    <h2 class="protocol-center">"<?=$answer['compinfo']['name']?> <?=$answer['compinfo']['yearB']?>"</h2>
    <h1 class="protocol-center">НАСТАВЛЕНИЕ ДЛЯ КОМИССАРА МАТЧА</h1>
    <p>- Комиссар Матча  осуществляет свои действия и несёт ответственность за ненадлежащее исполнение возложенных на него обязанностей в соответствии  с требованиями Регламента Чемпионата России по американскому футболу 2015 года.</p>
    <p>- Комиссар Матча назначается Организационным Комитетом Чемпионата России 2015 года.</p>
    <p>- В обязанности Комиссара Матча входит проверка соответствия Игроков обеих команд заявке.</p>
    <p>В качестве документа удостоверяющего личность используется личная карточка игрока /Приложение 4 к Регламенту Чемпионата России 2015 года/. Также  может быть использован гражданский паспорт или  квалификационная книжка спортсмена.</p>
    <p>- Перед началом Матча, Комиссар Матча обязан убедиться что все требования для проведения матча соблюдены:<ol class="print-ol"><li>Наличие участников матча, команда /хозяева в составе не менее 25 человек согласно заявки на матч/  и команда /гости в составе не менее 25 человек согласно заявки на матч/.</li><li>Наличие судейской бригады,  в том числе рефери матча согласно назначения Судейского Комитета Чемпионат России 2015 года.</li><li>Наличие разметки на поле, маркеров и даун-маркеров, ball-bays, мячей, цепочной бригады.</li><li>Наличие бригады скорой помощи. </li></ol></p>
    <p>- В случае если есть опасность для зрителей, игроков и других участников матча и если эта опасность не может быть устранена то матч должен быть отменен.</p>
    <p>- В отсутствии Комиссара Матча функции возлагаются на Рефери Матча.</p>
    <div class="protocol-center">СУДЕЙСКИЙ КОМИТЕТ ФАФР БЛАГОДАРИТ ВАС ЗА РАБОТУ !</div>
    <div class="protocol-center">телефон  8-961-351-92-37 Казанцев Алексей</div>
    <div class="print-pagebreak"></div>
    <?}?>

    <div class="protocol-center">
        <img class="protocol-print_fafr" src="//<?=$HOST?>/themes/img/fafr_logo_print.png"/>
    </div>
    <h2 class="protocol-center">ФЕДЕРАЦИЯ АМЕРИКАНСКОГО ФУТБОЛА РОССИИ</h2>
    <h2 class="protocol-center">СУДЕЙСКИЙ КОМИТЕТ</h2>
    <h2 class="protocol-center">"<?=$answer['compinfo']['name']?> <?=$answer['compinfo']['yearB']?>"</h2>
    <h1 class="protocol-center">ОТЧЕТ О МАТЧЕ</h1>
    <table class="protocol-table_col2">
        <colgroup>
            <col width="25%"/>
            <col width="25%"/>
            <col width="25%"/>
            <col width="25%"/>
        </colgroup>
        <tbody>
        <tr>
            <?
                $date_arr = explode('-', $answer['match']['date']);
                $date = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
            ?>
            <td colspan="2">ДАТА МАТЧА - <?=$date?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2">КОМАНДА ХОЗЯЕВА - <?=$answer['match']['t1']?></td>
            <td colspan="2">КОМАНДА ГОСТИ - <?=$answer['match']['t2']?></td>
        </tr>
        <tr>
            <td colspan="2">ЦВЕТ ФОРМЫ - <?=$answer['protocol'][0]['color1']?></td>
            <td colspan="2">ЦВЕТ ФОРМЫ - <?=$answer['protocol'][0]['color2']?></td>
        </tr>
        <tr>
            <td colspan="2">ГЛАВНЫЙ ТРЕНЕР - <?=$answer['match']['surname1']. ' '.$answer['match']['name1']?></td>
            <td colspan="2">ГЛАВНЫЙ ТРЕНЕР - <?=$answer['match']['surname2']. ' '.$answer['match']['name2']?></td>
        </tr>
        <tr>
            <td colspan="2">НАЧАЛО МАТЧА /план/  - <?=$answer['protocol'][0]['timeb']?></td>
            <td colspan="2">НАЧАЛО МАТЧА /факт/ - <?=$answer['protocol'][0]['timee']?></td>
        </tr>
        <tr>
            <td colspan="4">ПРОДОЛЖИТЕЛЬНОСТЬ МАТЧА:</td>
        </tr>
        <tr>
            <td>I четверть  - <?=$answer['protocol'][0]['time1']?> мин.</td>
            <td>II четверть - <?=$answer['protocol'][0]['time2']?> мин.</td>
            <td>III четверть - <?=$answer['protocol'][0]['time3']?> мин.</td>
            <td>IVчетверть - <?=$answer['protocol'][0]['time4']?> мин.</td>
        </tr>
        <tr>
            <td colspan="2">СЧЕТ МАТЧА - <?=$answer['protocol'][0]['point1']?>:<?=$answer['protocol'][0]['point2']?></td>
            <td colspan="2">ОВЕРТАЙМ - <?=$answer['protocol'][0]['pointover1']?>:<?=$answer['protocol'][0]['pointover2']?></td>
        </tr>
        <tr>
            <td colspan="4">ОЦЕНКИ</td>
        </tr>
        <tr>
            <td colspan="2">РАЗМЕТКА ПОЛЯ  - <?=$marks[$answer['protocol'][0]['razm']]?></td>
            <td colspan="2">РАЗДЕВАЛКИ - <?=$marks[$answer['protocol'][0]['razd']]?></td>
        </tr>
        <tr>
            <td colspan="2">МЯЧИ  - <?=$marks[$answer['protocol'][0]['ball']]?></td>
            <td colspan="2">ЦЕПЬ И МАРКЕРЫ - <?=$marks[$answer['protocol'][0]['chain']]?></td>
        </tr>
        <tr>
            <td colspan="2">BALL BOY  - <?=$marks[$answer['protocol'][0]['ballboy']]?></td>
            <td colspan="2">ЦЕПОЧНАЯ БРИГАДА - <?=$marks[$answer['protocol'][0]['chaincrew']]?></td>
        </tr>
        <tr>
            <td colspan="2">ПОГОДА  - <?=$marks[$answer['protocol'][0]['weather']]?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2">ФОРМА ИГРОКОВ(хозяева) - <?=$marks[$answer['protocol'][0]['form1']]?></td>
            <td colspan="2">ФОРМА ИГРОКОВ(гости) - <?=$marks[$answer['protocol'][0]['form2']]?></td>
        </tr>
        <tr>
            <td colspan="2">ПОВЕДЕНИЕ ИГРОКОВ(хозяева)- <?=$marks[$answer['protocol'][0]['player1']]?></td>
            <td colspan="2">ПОВЕДЕНИЕ ИГРОКОВ(гости) - <?=$marks[$answer['protocol'][0]['player2']]?></td>
        </tr>
        <tr>
            <td colspan="2">ПОВЕДЕНИЕ ТРЕНЕРОВ(хозяева) - <?=$marks[$answer['protocol'][0]['coach1']]?></td>
            <td colspan="2">ПОВЕДЕНИЕ ТРЕНЕРОВ(гости) - <?=$marks[$answer['protocol'][0]['coach2']]?></td>
        </tr>

        <tr>
            <td colspan="4">Рефери - <?=$answer['protocol'][0]['refferee']?></td>
        </tr>
        <tr>
            <td colspan="4">Ампаэр - <?=$answer['protocol'][0]['empire']?></td>
        </tr>
        <tr>
            <td colspan="4">Бэк-джадж - <?=$answer['protocol'][0]['backjudge']?></td>
        </tr>
        <tr>
            <td colspan="4">Хэд-лайнсмэн - <?=$answer['protocol'][0]['linesman']?></td>
        </tr>
        <tr>
            <td colspan="4">Лайн-джадж - <?=$answer['protocol'][0]['linejudge']?></td>
        </tr>
        <tr>
            <td colspan="4">Филд-джадж - <?=$answer['protocol'][0]['judge6']?></td>
        </tr>
        <tr>
            <td colspan="4">Сайд-джадж - <?=$answer['protocol'][0]['judge7']?></td>
        </tr>
        <tr>
            <td colspan="4">РЕФЕРИ МАТЧА  - подпись___________________________</td>
        </tr>
        <tr>
            <td colspan="2">ГЛАВНЫЙ ТРЕНЕР (хозяева) - подпись________________</td>
            <td colspan="2">ГЛАВНЫЙ ТРЕНЕР (гости) - подпись________________</td>
        </tr>
        </tbody>
    </table>
    <p>НАПОМИНАНИЕ :</p>
    <p>- Данная форма подписывается и в заполненном варианте передается комиссару матча</p>
    <p class="protocol-margin">- Обо всех инцидентах надо  сразу же сообщить в организационный комитет Чемпионата по телефону 8-908-610-18-77 </p>
    <div class="protocol-center">СУДЕЙСКИЙ КОМИТЕТ ФАФР БЛАГОДАРИТ ВАС ЗА РАБОТУ !</div>

    <div class="protocol-center">телефон  8-961-351-92-37 Казанцев Алексей</div>
    <div class="print-pagebreak"></div>



    <div class="protocol-center">
        <img class="protocol-print_fafr" src="//<?=$HOST?>/themes/img/fafr_logo_print.png"/>
    </div>
    <h2 class="protocol-center">ФЕДЕРАЦИЯ АМЕРИКАНСКОГО ФУТБОЛА РОССИИ</h2>
    <h2 class="protocol-center">СУДЕЙСКИЙ КОМИТЕТ</h2>
    <h2 class="protocol-center">"<?=$answer['compinfo']['name']?> <?=$answer['compinfo']['yearB']?>"</h2>
    <h1 class="protocol-center">ОТЧЕТ ОБ ИНЦИДЕНТАХ</h1>
    <table class="protocol-table_col2">
        <colgroup>
            <col width="25%"/>
            <col width="25%"/>
            <col width="25%"/>
            <col width="25%"/>
        </colgroup>
        <tbody>
        <tr>
            <?
            $date_arr = explode('-', $answer['match']['date']);
            $date = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
            ?>
            <td colspan="2">ДАТА МАТЧА - <?=$date?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2">КОМАНДА ХОЗЯЕВА - <?=$answer['match']['t1']?></td>
            <td colspan="2">КОМАНДА ГОСТИ - <?=$answer['match']['t2']?></td>
        </tr>
        <tr>
            <td colspan="2">ЦВЕТ ФОРМЫ - <?=$answer['protocol'][0]['color1']?></td>
            <td colspan="2">ЦВЕТ ФОРМЫ - <?=$answer['protocol'][0]['color2']?></td>
        </tr>
        <tr>
            <td colspan="2">ГЛАВНЫЙ ТРЕНЕР - <?=$answer['match']['surname1']. ' '.$answer['match']['name1']?></td>
            <td colspan="2">ГЛАВНЫЙ ТРЕНЕР - <?=$answer['match']['surname2']. ' '.$answer['match']['name2']?></td>
        </tr>
        <tr>
            <td colspan="2">НАЧАЛО МАТЧА /план/  - <?=$answer['protocol'][0]['timeb']?></td>
            <td colspan="2">НАЧАЛО МАТЧА /факт/ - <?=$answer['protocol'][0]['timee']?></td>
        </tr>
        <tr>
            <td colspan="4">ОПИСАНИЕ ИНЦИДЕНТОВ</td>
        </tr>
        <tr>
            <td colspan="4"><?=nl2br($answer['protocol'][0]['incident'])?></td>
        </tr>
        <tr>
            <td colspan="4">РЕФЕРИ МАТЧА  - подпись___________________________</td>
        </tr>
        <tr>
            <td colspan="2">ГЛАВНЫЙ ТРЕНЕР (хозяева) - подпись________________</td>
            <td colspan="2">ГЛАВНЫЙ ТРЕНЕР (гости) - подпись________________</td>
        </tr>
        </tbody>
    </table>
    <p>НАПОМИНАНИЕ :</p>
    <p>- Данная форма подписывается и в заполненном варианте передается комиссару матча</p>
    <p class="protocol-margin">- Обо всех инцидентах надо  сразу же сообщить в организационный комитет Чемпионата по телефону 8-908-610-18-77 </p>
    <div class="protocol-center">СУДЕЙСКИЙ КОМИТЕТ ФАФР БЛАГОДАРИТ ВАС ЗА РАБОТУ !</div>

    <div class="protocol-center">телефон  8-961-351-92-37 Казанцев Алексей</div>
    <div class="print-pagebreak"></div>
</div>