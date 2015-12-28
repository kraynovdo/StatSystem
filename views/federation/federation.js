(function(){
    $('.federation-step3').click(function(){
        $('.federation-1countryid').first().val($('.federation-countryid').val());
        $('.federation-1country').first().val($('.federation-country').val());
        $('.federation-1countryTitle').first().text($('.federation-country').val());

        $('.federation-1regionid').first().val($('.federation-regionid').val());
        $('.federation-1region').first().val($('.federation-region').val());
        $('.federation-1regionTitle').first().text($('.federation-region').val());
    });
    $('.federation-type').change(function(){
        var
            val = $(this).val(),
            cBlock = $('.federation-partBlock1'), rBlock = $('.federation-partBlock2');
        $('.main-validWin').hide();
        switch (val) {

            case '1': {
                cBlock.show();
                rBlock.hide();
                $('.main-fieldWrapper_2country').show();
                $('h3', cBlock).text('Страны в составе федерации');
                $('.main-fieldWrapper_1country').removeClass('main-valid_error');
                $('.federation-error').remove();
                break;
            }
            case '2': {
                cBlock.show();
                rBlock.hide();
                $('.main-fieldWrapper_2country').hide();
                $('.federation-partitem_ctr').remove();
                $('h3', cBlock).text('Страна, которую представляет федерация');
                $('.main-fieldWrapper_1country').removeClass('main-valid_error');
                $('.federation-error').remove();
                break;
            }
            case '3': {
                rBlock.show();
                cBlock.hide();
                $('.main-fieldWrapper_2region').show();
                $('h3', rBlock).text('Регионы в составе федерации');
                $('.main-fieldWrapper_1region').removeClass('main-valid_error');
                $('.federation-error').remove();
                break;
            }
            case '4': {
                rBlock.show();
                cBlock.hide();
                $('.main-fieldWrapper_2region').hide();
                $('.federation-partitem_reg').remove();
                $('h3', rBlock).text('Регион, который представляет федерация');
                $('.main-fieldWrapper_1region').removeClass('main-valid_error');
                $('.federation-error').remove();
                break;
            }
        }
    });

    $('.federation-add_country').click(function(){
        var
            id = $('.federation-2countryid'),
            text = $('.federation-2country');
        if (id.val()) {
            var ctrl = $('<div class="listview-item federation-partitem_ctr">\
                <input class="federation-1countryid" name="geo_countryP[]" type="hidden"/>\
                <input class="federation-1country" name="geo_countryTitleP[]" type="hidden"/>\
                <span class="federation-partTitle federation-1countryTitle"></span>\
                <a href="javascript: void(0)" class="federation-delete_part">[x]</a>\
                </div>');
            $('.main-fieldWrapper_1country').append(ctrl);
            $('.federation-1countryid', ctrl).val(id.val());
            $('.federation-1country', ctrl).val(text.val());
            $('.federation-1countryTitle', ctrl).text(text.val());
            $('.federation-delete_part', ctrl).click(function(){
                ctrl.remove();
            });
            id.val('');
            text.val('');
            $('.main-fieldWrapper_1country').removeClass('main-valid_error');
            $('.federation-error').remove();
        }
        else {
            alert('Выберите результат из списка');
        }
    });

    $('.federation-add_region').click(function(){
        var
            id = $('.federation-2regionid'),
            text = $('.federation-2region');
        if (id.val()) {
            var ctrl = $('<div class="listview-item federation-partitem_reg">\
                <input class="federation-1regionid" name="geo_regionP[]" type="hidden"/>\
                <input class="federation-1region" name="geo_regionTitleP[]" type="hidden"/>\
                <span class="federation-partTitle federation-1regionTitle"></span>\
                <a href="javascript: void(0)" class="federation-delete_part">[x]</a>\
                </div>');
            $('.main-fieldWrapper_1region').append(ctrl);
            $('.federation-1regionid', ctrl).val(id.val());
            $('.federation-1region', ctrl).val(text.val());
            $('.federation-1regionTitle', ctrl).text(text.val());
            $('.federation-delete_part', ctrl).click(function(){
                ctrl.remove();
            });
            id.val('');
            text.val('');
            $('.main-fieldWrapper_1region').removeClass('main-valid_error');
            $('.federation-error').remove();
        }
        else {
            alert('Выберите результат из списка');
        }
    });

    $('.federation-step4').click(function(){
        var
            val = $('.federation-type').val(),
            ctries = $('.federation-1countryid'),
            regs = $('.federation-1regionid'), errorC = '', errorR = '', i;
        $('.main-validWin').hide();

        switch (val) {

            case '1': {
                errorC = 'Выберите более 2х стран';
                if (ctries.length >= 2) {
                    errorC = '';
                }
                break;
            }
            case '2': {
                errorC = 'Выберите страну';
                for (i = 0; i < ctries.length; i++) {
                    if ($(ctries[i]).val()) {
                        errorC = '';
                    }
                }
                break;
            }
            case '3': {
                errorR = 'Выберите более 2х регионов';
                if (regs.length >= 2) {
                    errorR = '';
                }
                break;
            }
            case '4': {
                errorR = 'Выберите регион';
                for (i = 0; i < regs.length; i++) {
                    if ($(regs[i]).val()) {
                        errorR = '';
                    }
                }
                break;
            }
        }
        if (errorC) {
            $('.main-fieldWrapper_1country').addClass('main-valid_error').append('<div class="federation-error">'+errorC+'</div>');
        }
        else if (errorR) {
            $('.main-fieldWrapper_1region').addClass('main-valid_error').append('<div class="federation-error">'+errorR+'</div>');
        }
        else {
            var code, txt;
            if (val > 2) {
               code = $(regs.get(0)).val();
               txt = 'В этом регионе уже есть региональная федерация';
            }
            else {
                code = $(ctries.get(0)).val();
                txt = 'В этой стране уже есть национальная федерация';
            }
            var self = this;
            $.get('/?r=federation/check', {
                type: val,
                code: code
            }, function(res){
                var ans = res['answer'];
                if (ans) {
                    $('.federation-type').addClass('main-valid_error').attr('data-validmsg', txt);
                }
                else {
                    $(self).closest('.main-editBlock').hide();
                    $('.main-editBlock[data-block="4"]').show();
                }
            });
        }

        function fillPerson(person, suf) {
            $('.federation-surname_'+suf).val(person.surname).attr('disabled', 'disabled');
            $('.federation-name_'+suf).val(person.name).attr('disabled', 'disabled');
            $('.federation-patr_'+suf).val(person.patronymic).attr('disabled', 'disabled');
            $('.federation-date_'+suf).val(person.birthdate).attr('disabled', 'disabled');
            $('.federation-phone_'+suf).val(person.phone);
            $('.federation-id_'+suf).val(person.id);
            $('.federation-person_clear'+suf).show();
        }
        $('.federation-surname_d').blur(function(){
            $amf.fioSuggest($(this).val(), function(person) {
                fillPerson(person ,'d');
            });
        });
        $('.federation-surname_a').blur(function(){
            $amf.fioSuggest($(this).val(), function(person) {
                fillPerson(person ,'a');
            });
        });
        $('.federation-person_clear').click(function(){
            var container = $(this).closest('.main-fieldWrapper');
            $('input', container).val('').removeAttr('disabled');
            $(this).hide();
        })
    });

    $('.federation-partAddLink').click(function(){
        $(this).hide();
        $(this).closest('.federation-listPart').find('.federation-partAddForm').show()
    });
})();