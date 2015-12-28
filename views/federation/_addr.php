<h3>Адрес</h3>
<?if (!$federation['type'] || ($federation['type'] == 1)) {?>
<div class="main-fieldWrapper">
    <input name="geo_country" type="hidden" data-geo="country" class="federation-countryid" value="<?=$federation['geo_country']?>"/>
    <input autocomplete="off" value="<?=$federation['country']?>" class="geo-country federation-country federation-field" name="geo_countryTitle" data-validate="geo" data-geo="country" type="text" placeholder="Страна"/>
</div>
<?} else {?>
    <input name="geo_country" type="hidden" data-geo="country" class="federation-countryid" value="<?=$federation['geo_country']?>"/>
<?}?>

<?if (!$federation['type'] || ($federation['type'] == 1) || ($federation['type'] == 2) || ($federation['type'] == 3)) {?>
<div class="main-fieldWrapper">
    <input name="geo_region" type="hidden" data-geo="region" class="federation-regionid" value="<?=$federation['geo_region']?>"/>
    <input autocomplete="off" value="<?=$federation['region']?>" class="geo-region federation-region federation-field" name="geo_regionTitle" data-validate="geo2" data-geo="region" type="text" placeholder="Регион" data-geo-country="country"/>
</div>
<?}else {?>
    <input name="geo_region" type="hidden" data-geo="region" class="federation-regionid" value="<?=$federation['geo_region']?>"/>
<?}?>
<div class="main-fieldWrapper">
    <input name="geo_city" type="hidden" data-geo="city" value="<?=$federation['geo_city']?>"/>
    <input autocomplete="off" value="<?=$federation['city']?>" class="geo-city federation-region federation-field" name="geo_cityTitle" data-validate="geo" data-geo="city" type="text" placeholder="Город"  data-geo-region="region" data-geo-country="country"/>
</div>
<div class="main-fieldWrapper">
    <input class="federation-field" name="street" type="text" placeholder="Улица" value="<?=$federation['street']?>"/>
</div>
<div class="main-fieldWrapper">
    <label>
        Дом <input class="federation-field_addr" name="house" type="text" value="<?=$federation['house']?>"/>
    </label>
    <label>
        Корпус/Литера/Строение <input class="federation-field_addr" name="corpse" type="text" value="<?=$federation['corpse']?>"/>
    </label>
    <label>
        Квартира/Офис <input class="federation-field_addr" name="flat" type="text" value="<?=$federation['flat']?>"/>
    </label>
</div>