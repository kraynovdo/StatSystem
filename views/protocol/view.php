<?if (count($answer['protocol'])) { $protocol = $answer['protocol'][0]?>

        <div class="main-fieldWrapper">
    <? if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4)) {?>
            <a href="/?r=protocol/edit&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Редактировать</a>
    <?}?>
            <a href="/?r=protocol/print&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Печать</a>
        </div>

<? if (count($answer['protocol'])) {
    $protocol = $answer['protocol'][0];
    $points = array(
        '5' => 'Отлично',
        '4' => 'Хорошо',
        '3' => 'Удовлетворительно',
    );
        if ($IS_MOBILE) {
            $points['3'] = 'Удовл.';
        }
}?>
    <table class="protocol-view">
        <colgroup>
            <col width="50px"/>
            <col/>
        </colgroup>
        <tbody>
            <tr>
                <td colspan="2"><h2>Основная информация</h2></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label"><?=$answer['match']['t1']?> - цвет формы</span></td>
                <td><span><?=$protocol['color1']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label"><?=$answer['match']['t2']?> - цвет формы</span></td>
                <td><span><?=$protocol['color2']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Плановое время начала</span></td>
                <td><span><?=$protocol['timeb']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Фактическое время начала</span></td>
                <td><span><?=$protocol['timee']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Продолжительность четвертей</span></td>
                <td><span><?=$protocol['time1']?> мин, <?=$protocol['time2']?> мин, <?=$protocol['time3']?> мин, <?=$protocol['time4']?> мин</span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Счет основного времени</span></td>
                <td><span><?=$protocol['point1']?>:<?=$protocol['point2']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Счет овертайма</span></td>
                <td><?=$protocol['pointover1']?>:<?=$protocol['pointover2']?></span></td>
            </tr>
            <tr>
                <td colspan="2"><h2>Оценки судей</h2></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Разметка поля</span></td>
                <td><span><?=$points[$protocol['razm']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Раздевалки</span></td>
                <td><span><?=$points[$protocol['razd']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Мячи</span></td>
                <td><span><?=$points[$protocol['ball']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Цепь и маркеры</span></td>
                <td><span><?=$points[$protocol['chain']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Цепочная бригада</span></td>
                <td><span><?=$points[$protocol['chaincrew']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Погода</span></td>
                <td><span><?=$points[$protocol['weather']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label"><?=$answer['match']['t1']?> - форма игроков</span></td>
                <td><span><?=$points[$protocol['form1']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label"><?=$answer['match']['t2']?> - форма игроков</span></td>
                <td><span><?=$points[$protocol['form2']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label"><?=$answer['match']['t1']?> - поведение игроков</span></td>
                <td><span><?=$points[$protocol['player1']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label"><?=$answer['match']['t2']?> - поведение игроков</span></td>
                <td><span><?=$points[$protocol['player2']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label"><?=$answer['match']['t1']?> - поведение тренеров</span></td>
                <td><span><?=$points[$protocol['coach1']]?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label"><?=$answer['match']['t2']?> - поведение тренеров</span></td>
                <td><span><?=$points[$protocol['coach2']]?></span></td>
            </tr>
            <? if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4)) {?>
                <tr>
                    <td colspan="2"><h2>Инциденты</h2></td>
                </tr>
                <tr>
                    <td colspan="2"><?=nl2br($protocol['incident'])?></span></td>
                </tr>
            <?}?>
            </tbody>
        </table>
        <table class="protocol-view">
            <colgroup>
                <col width="40px"/>
                <col/>
            </colgroup>
            <tr>
                <td colspan="2"><h2>Судейская бригада</h2></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Рефери</span></td>
                <td><span><?=$protocol['refferee']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Ампаэр</span></td>
                <td><span><?=$protocol['empire']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Бэк-джадж</span></td>
                <td><span><?=$protocol['backjudge']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Хэд-лайнсмэн</span></td>
                <td><span><?=$protocol['linesman']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Лайн-джадж</span></td>
                <td><span><?=$protocol['linejudge']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Филд-джадж</span></td>
                <td><span><?=$protocol['judge6']?></span></td>
            </tr>
            <tr>
                <td><span class="protocol-view_label">Сайд-джадж</span></td>
                <td><span><?=$protocol['judge7']?></span></td>
            </tr>

        </tbody>
    </table>
<?} else {?>
    Протокол не заполнен
    <? if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4)) {?>
        <a href="/?r=protocol/edit&match=<?=$_GET['match']?>&ret=match/view">заполнить</a>
    <?}?>
<?}?>