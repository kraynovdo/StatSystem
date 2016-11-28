<h2>Состав</h2>
<?if (count($answer['comps'])) {?>
    <div class="main-fieldWrapper">
    <label>Турнир</label>
    <select class="team-compSelector">
<?for ($i = 0; $i < count($answer['comps']); $i++) {?>
   <option value="<?=$answer['comps'][$i]['id']?>"
       <?if ($answer['comps'][$i]['id'] == $answer['compId']) {?> selected="selected"<?}?>><?=$answer['comps'][$i]['name']?> <?=$answer['comps'][$i]['yearB']?></option>
<?}?>
    </select>
    </div>
<?}?>
<div class="roster-view">
    <?for ($i = 0; $i < count($answer['roster']); $i++) {?>
        <?
            $roster = $answer['roster'][$i];
            if ($roster['birthdate'] != '0000-00-00') {
                $bitrhdate = common_dateFromSQL($answer['roster'][$i]['birthdate']);
            }
        ?>
        <div class="roster-view_item main-columnItem<?if ($i % 2 == 1){?> main-columnItem_odd<?}?>">
            <div class="roster-view_itemContent">
                <div class="roster-view_photo">
                    <?if ($roster['avatar']) {?>
                        <img style="width:50px" src="//<?=$HOST?>/upload/<?=$roster['avatar']?>">
                    <?} else {?>
                        <div class="main-noPhoto">?</div>
                    <?}?>
                </div>
                <div class="roster-view_fio">
                    <a target="_blank" href="/?r=person/view&person=<?=$roster['person']?>">
                            <?=$roster['surname']?>
                            <?=$roster['name']?>
                    </a>
                </div>
                <div class="roster-view_info">
                    <span class="roster-view_number"><?=$roster['number']?></span>
                    <?=$roster['pos']?>
                    <?=$roster['geo_countryTitle']?>
                </div>
            </div>
        </div>
    <?}?>
</div>
<?if (count($answer['roster'])) {?>
    <div class="roster-count">Всего: <?=count($answer['roster'])?></div>
<?}?>
<h2>Официальные лица</h2>
<div class="roster-view">
    <?for ($i = 0; $i < count($answer['face']); $i++) {?>
        <?
        $roster = $answer['face'][$i];
        if ($roster['birthdate'] != '0000-00-00') {
            $bitrhdate = common_dateFromSQL($answer['roster'][$i]['birthdate']);
        }
        ?>
        <div class="roster-view_item main-columnItem<?if ($i % 2 == 1){?> main-columnItem_odd<?}?>">
            <div class="roster-view_itemContent">
                <div class="roster-view_photo">
                    <?if ($roster['avatar']) {?>
                        <img style="width:50px" src="//<?=$HOST?>/upload/<?=$roster['avatar']?>">
                    <?} else {?>
                        <div class="main-noPhoto">?</div>
                    <?}?>
                </div>
                <div class="roster-view_fio">
                    <a target="_blank" href="/?r=person/view&person=<?=$roster['person']?>">
                        <?=$roster['surname']?>
                        <?=$roster['name']?>
                    </a>
                    (<?=$roster['geo_countryTitle']?>)
                </div>
                <div class="roster-view_info">
                    <?=$answer['face'][$i]['facetype']?>
                </div>
            </div>
        </div>
    <?}?>
</div>
<?if (count($answer['face'])) {?>
    <div class="roster-count">Всего: <?=count($answer['face'])?></div>
<?}?>