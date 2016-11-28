(function(){
    var getHost = function() {
        var host = location.host;

        if (host.indexOf('amfoot.net') >= 0) {
            host = 'amfoot.net';
        }
        else if (host.indexOf('amfoot.ru') >= 0) {
            host = 'amfoot.ru';
        }
        return host;
    };
    /*Авто заполнение ростера*/
    $(".roster-surname").blur(function(){

        $amf.fioSuggest($(this).val(), function(person) {
            $('.roster-surname').val(person.surname).attr('disabled', 'disabled');
            $('.roster-name').val(person.name).attr('disabled', 'disabled');
            $('.roster-patronymic').val(person.patronymic).attr('disabled', 'disabled');
            $('.roster-birthdate').val(person.birthdate).attr('disabled', 'disabled');
            $('.roster-person').val(person.id);
            $('.roster-phone').val(person.phone);
            $('.roster-weight').val(person.weight);
            $('.roster-growth').val(person.growth);
            $('.roster-citizenship_code').val(person.geo_country);
            $('.roster-citizenship').val(person.geo_countryTitle);

            if (person.avatar) {
                var photo = $('.roster-photo');
                photo.find('.main-file_label').remove();
                photo.find('.main-file_miniature').remove();
                photo.find('.main-file_input').val('');
                photo.append('<img src="//' + getHost() + '/upload/' + person.avatar + '" class="main-file_miniature">');
            }
            $('.roster-clear').show();
        });
    });

    /*Авто заполнение ростера*/
    $(".roster-surname_face").blur(function(){

        $amf.fioSuggest($(this).val(), function(person) {
            $('.roster-surname_face').val(person.surname).attr('disabled', 'disabled');
            $('.roster-name_face').val(person.name).attr('disabled', 'disabled');
            $('.roster-patronymic_face').val(person.patronymic).attr('disabled', 'disabled');
            $('.roster-birthdate_face').val(person.birthdate).attr('disabled', 'disabled');
            $('.roster-person_face').val(person.id);
            $('.roster-phone_face').val(person.phone);
            $('.roster-citizenship_face_code').val(person.geo_country);
            $('.roster-citizenship_face').val(person.geo_countryTitle);

            if (person.avatar) {
                var photo = $('.roster-photo_face');
                photo.find('.main-file_label').remove();
                photo.find('.main-file_miniature').remove();
                photo.find('.main-file_input').val('');
                photo.append('<img src="//' + getHost() + '/upload/' + person.avatar + '" class="main-file_miniature">');
            }
            $('.roster-clear_face').show();
        });
    });

    function rosterClearPlayer() {
        $('.roster-surname').val('').removeAttr('disabled');
        $('.roster-name').val('').removeAttr('disabled');
        $('.roster-patronymic').val('').removeAttr('disabled');
        $('.roster-birthdate').val('').removeAttr('disabled');
        $('.roster-person').val('');
        $('.roster-phone').val('');
        $('.roster-weight').val('');
        $('.roster-growth').val('');
        $('.roster-citizenship').val('');
        $('.roster-citizenship_code').val('');
        var photo = $('.roster-photo');
        photo.append('<div class="main-file_label">Добавить<br/>фотографию<br/>(формат jpeg)</div>');
        photo.find('.main-file_miniature').remove();
        photo.find('.main-file_input').val('');
        $('.roster-clear').hide();
    }

    function rosterClearFace() {
        $('.roster-surname_face').val('').removeAttr('disabled');
        $('.roster-name_face').val('').removeAttr('disabled');
        $('.roster-patronymic_face').val('').removeAttr('disabled');
        $('.roster-birthdate_face').val('').removeAttr('disabled');
        $('.roster-person_face').val('');
        $('.roster-phone_face').val('');
        $('.roster-citizenship_face').val('');
        $('.roster-citizenship_face_code').val('');
        var photo = $('.roster-photo_face');
        photo.append('<div class="main-file_label">Добавить<br/>фотографию<br/>(формат jpeg)</div>');
        photo.find('.main-file_miniature').remove();
        photo.find('.main-file_input').val('');
        $('.roster-clear_face').hide();
    }

    $('.roster-clear').click(rosterClearPlayer);

    $('.roster-clear_face').click(rosterClearFace);

    $('.roster-addLink').click(function(){
        if (!$(this).hasClass('roster-addLink_active')) {
            $('.roster-addLink_active').removeClass('roster-addLink_active');
            $(this).addClass('roster-addLink_active');
        }
    });

    $('.roster-addLink_player').click(function(){
        $('.roster-addPerson').show();
        $('.roster-addFace').hide();
        rosterClearFace();
    });

    $('.roster-addLink_face').click(function(){
        $('.roster-addPerson').hide();
        $('.roster-addFace').show();
        rosterClearPlayer();
    });

    $('.roster-confirm').click(function(){
        var
            $self = $(this),
            item = $self.closest('.roster-item'),
            id = item.data('id');

        $.post("/?r=roster/confirm", {
            roster: id
        }, function (ans) {
            var
                tdEdit = $('.roster-editTD', item),
                tdDel = $('.roster-delTD', item);
            if (parseInt(ans, 10)) {
                item.addClass('roster-row_confirm1').removeClass('roster-row_confirm0');
                $self.addClass('roster-confirm_1');
                tdDel.empty('&nbsp;');
            }
            else {
                item.addClass('roster-row_confirm0').removeClass('roster-row_confirm1');
                $self.removeClass('roster-confirm_1');
                tdDel.html('<a title="Редактировать" href="/?r=roster/edit&roster='+id+'">[X]</a>');
            }
        })
    });

    $('.roster-choose_checkbox').change(function(){
        var idArr = [];
        $('.roster-choose_checkbox').each(function(i, item) {
            if ($(item).prop('checked')) {
                var
                    tr = $(item).closest('tr'),
                    id = tr.data('id');
                idArr.push(id);
            }
        });
        var link = $('.roster-printChooseLink');
        link.toggleClass('main-hidden', !idArr.length);
        var
            href = link.attr('href'),
            index = href.indexOf('&ids=');
        if (index >= 0) {
            href = href.substring(0, index);
        }
        if (idArr.length) {
            href += '&ids=' + idArr.join(',');
            link.attr('href', href);
            $('.roster-choose_mainCheckbox').prop('checked', true);
        }
        else {
            $('.roster-choose_mainCheckbox').prop('checked', false);
        }
    });

    $('.roster-choose_mainCheckbox').change(function(){
       if ($(this).prop('checked')) {
           $('.roster-choose_checkbox').each(function(i, item) {
               $(item).prop('checked', true)
           });
       }
       else {
           $('.roster-choose_checkbox').each(function(i, item) {
               $(item).prop('checked', false)
           });
       }
    });
})();