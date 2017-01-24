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
    function fillPerson(person, suf) {
        $('.federation-surname_'+suf).val(person.surname).attr('disabled', 'disabled');
        $('.federation-name_'+suf).val(person.name).attr('disabled', 'disabled');
        $('.federation-patr_'+suf).val(person.patronymic).attr('disabled', 'disabled');
        $('.federation-date_'+suf).val(person.birthdate).attr('disabled', 'disabled');
        $('.federation-phone_'+suf).val(person.phone);
        $('.federation-id_'+suf).val(person.id);
        $('.federation-person_clear'+suf).show();
        if (person.avatar) {
            var photo = $('.roster-photo');
            photo.attr('disabled', 'disabled');
            photo.find('.main-file_label').remove();
            photo.find('.main-file_miniature').remove();
            photo.find('.main-file_input').val('');
            photo.append('<img src="//' + getHost() + '/upload/' + person.avatar + '" class="main-file_miniature">');
        }
    }
    $('.federation-surname_d').blur(function(){
        $amf.fioSuggest($(this).val(), function(person) {
            fillPerson(person ,'d');
        });
    });
    $('.federation-person_clear').click(function(){
        var container = $(this).closest('.federation-formPerson');
        $('input', container).val('').removeAttr('disabled');
        $(this).hide();
    });

    $('.federation-empFlag').change(function(){
        if ($(this).prop('checked')) {
            $('.federation-fieldWork').val('');
            $('.federation-workField').show();
        }
        else {
            $('.federation-fieldWork').val(' ');
            $('.federation-workField').hide();
        }
    });
})();