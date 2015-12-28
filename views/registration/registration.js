(function(){
    $('.reg-referree').change(function(e, val) {
        $('.reg-block_referree').toggle(val)
    });

    $('.reg-surname').blur(function(){
        $amf.fioSuggest($(this).val(), function(person) {
            $(".reg-person").val(person.id);
            $(".reg-list_main").remove();
            $(".reg-block_main").append('<span class="reg-autofio">' + person.surname + ' ' + person.name + ' ' + person.patronymic + '</span>');
            if (person.email) {
                $(".reg-email").remove();
                $(".reg-block_enter").find('.reg-firstList').append('<span class="reg-autofio">' + person.email + '</span>');
                $(".reg-personEmail").val(person.email);
            }
            else {
                $(".reg-newEmail").val(1);
            }
            $(".reg-block_antr").remove();

        });
    });

    //TODO копипаст с валидаторов
    $(".reg-submit").click(function(){
        var
            form = $(this).closest('form'),
            error = false;
        $(this).removeClass('main-valid_error').removeAttr('data-validmsg');
        $amf.validWin.hideWin();
        $("[data-validate]", form.get(0)).each(function(i, item){
            var validator = $(item).attr('data-validate');
            if ($amf.validators[validator] instanceof Function) {
                var result = $amf.validators[validator]($(item).val(), $(item));
                if (result != true) {
                    $(item).addClass('main-valid_error').attr('data-validmsg', result);
                    error = true;
                }
                else {
                    $(item).removeClass('main-valid_error').removeAttr('data-validmsg');
                    $amf.validWin.hideWin();
                }
            }
        });

        if ($(".reg-email", form).length) {
            var email = $(".reg-email", form).val();
            $.post("/?r=person/checkemail", {
                email: email
            }, function (ans) {
                if (ans.answer && ans.answer.length) {
                    $(".reg-email", form).addClass('main-valid_error').attr('data-validmsg', 'Данный e-mail уже используется');
                }
                else {
                    if (!error) {
                        form.submit();
                    }
                }
            })
        }
        else {
            if (!error) {
                form.submit();
            }
        }
    });
})();
