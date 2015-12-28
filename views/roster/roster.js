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
        $('.roster-date').val('');
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
        $('.roster-date_face').val('');
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
            id = $(this).data('id'),
            $self = $(this);

        $.post("/?r=roster/confirm", {
            roster: id
        }, function (ans) {
            var
                tr = $self.closest('tr'),
                tdEdit = $('.roster-editTD', tr),
                tdDel = $('.roster-delTD', tr);
            if (parseInt(ans, 10)) {
                $self.addClass('roster-confirm_1');
                tdEdit.html('&nbsp;');
                tdDel.empty('&nbsp;');
            }
            else {
                $self.removeClass('roster-confirm_1');
                tdEdit.html('<a title="Редактировать" href="/?r=roster/edit&roster='+id+'">[Ред]</a>');
                tdDel.html('<a title="Редактировать" href="/?r=roster/edit&roster='+id+'">[X]</a>');
            }
        })
    });
})();