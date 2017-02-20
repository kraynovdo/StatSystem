<script src="//<?=$HOST?>/themes/jscolor.min.js"></script>
<h2>Заявка</h2>
<?if ($answer['request']['ctid']) {?>
    <div class="request-already request-already_confrim-<?=$answer['request']['confirm']?>">
        Заявка уже создана<?if ($answer['request']['confirm']) {?> и одобрена<?} else {?>, но пока не одобрена<?}?>
        <?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_POST['comp']] == 1)) {?>
            <a class="request-confirmLink" href="/?r=request/confirm_<?=(1 - $answer['request']['confirm'])?>&team=<?=$_GET['team']?>&comp=<?=$_GET['comp']?>">
                <?if ($answer['request']['confirm']) {?>Отменить одобрение<?} else {?>Одобрить<?}?></a>
        <?}?>
        <a target="_blank" class="request-printLink" href="/?r=request/print&comp=<?=$_GET['comp']?>&team=<?=$_GET['team']?>">Печать</a>

    </div>
<?}?>
<h2>Заполните необходимые данные</h2>

<form action="/?r=request/post" method="post">
    <input type="hidden" name="team" value="<?=$_GET['team']?>"/>
    <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Организационно-правовая форма</label>
        <select name="org_form" data-validate="req"  class="request-field">
            <option value="">--Выберите из списка--</option>
            <?for ($j = 0; $j < count($answer['opf']); $j++) {?>
                <option value="<?=$answer['opf'][$j]['id']?>"
                    <?if ($answer['request']['org_form'] == $answer['opf'][$j]['id']){?> selected="selected"<?}?>><?=$answer['opf'][$j]['name']?></option>
            <?}?>
        </select>
    </div>
    <h3>Названия</h3>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Название (рус)</label>
        <input name="rus_name" data-validate="req" class="request-field" type="text" value="<?=$answer['request']['rus_name']?>"/>
        <span class="main-field_hint">Пример: Бунтари</span>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Название (eng)</label>
        <input name="name" data-validate="req" class="request-field" type="text" value="<?=$answer['request']['name']?>"/>
        <span class="main-field_hint">Пример: Rebels</span>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Город (рус)</label>
        <input name="city" data-validate="req" class="request-field" type="text" value="<?=$answer['request']['city']?>"/>
        <span class="main-field_hint">Пример: Ярославль</span>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Город (прилагательное)</label>
        <input name="city_adj" data-validate="req" class="request-field" type="text" value="<?=$answer['request']['city_adj']?>"/>
        <span class="main-field_hint">Пример: Ярославские</span>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Город (eng)</label>
        <input name="city_eng" data-validate="req" class="request-field" type="text" value="<?=$answer['request']['city_eng']?>"/>
        <span class="main-field_hint">Пример: Yaroslavl</span>
    </div>
    <?if (!$answer['request']['ctid']) {?>
        <div class="main-fieldWrapper">
            <label class="main-label_top">Руководитель команды</label>
            <select name="work" data-validate="req"  class="request-field">
                <option value="">--Должность--</option>
                <?for ($j = 0; $j < count($answer['facetype']); $j++) {?>
                    <option value="<?=$answer['facetype'][$j]['id']?>">
                        <?=$answer['facetype'][$j]['name']?>
                    </option>
                <?}?>
            </select>
            <br/><br/>
            <select name="director" data-validate="req"  class="request-field">
                <option value="">--Выберите из списка--</option>
                <?for ($j = 0; $j < count($answer['user']); $j++) {?>
                    <option value="<?=$answer['user'][$j]['id']?>">
                        <?=$answer['user'][$j]['surname']?>
                        <?=$answer['user'][$j]['name']?>
                        <?=$answer['user'][$j]['patronymic']?>
                    </option>
                <?}?>
            </select>
        </div>
    <?}?>


    <h3>Цвета</h3>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Основной цвет 1</label>
        <input type="text" name="color_1" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_1']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Основной цвет 2</label>
        <input type="text" name="color_2" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_2']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Основной цвет 3</label>
        <input type="text" name="color_3" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_3']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Цвет шлема</label>
        <input type="text" name="color_helmet" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_helmet']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Цвет маски</label>
        <input type="text" name="color_mask" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_mask']?>"/>
    </div>
    <h3>Комплект формы 1</h3>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Джерси</label>
        <input type="text" name="color_jersey1" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_jersey1']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Бриджи</label>
        <input type="text" name="color_breeches1" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_breeches1']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Рукава</label>
        <input type="text" name="color_sleeve1" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_sleeve1']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Леггинсы/носки</label>
        <input type="text" name="color_socks1" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_socks1']?>"/>
    </div>
    <h3>Комплект формы 2</h3>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Джерси</label>
        <input type="text" name="color_jersey2" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_jersey2']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Бриджи</label>
        <input type="text" name="color_breeches2" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_breeches2']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Рукава</label>
        <input type="text" name="color_sleeve2" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_sleeve2']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <label class="main-label_top">Леггинсы/носки</label>
        <input type="text" name="color_socks2" data-validate="req" class="jscolor {required:false}" value="<?=$answer['request']['color_socks2']?>"/>
    </div>
    <div class="main-fieldWrapper">
        <input type="button" class="main-btn main-submit" value="Отправить"/>
    </div>
</form>