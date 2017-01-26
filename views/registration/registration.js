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
           emailField = $(".reg-email", form);

        if (emailField.length) {
            var email = emailField.val();
            if (!email) {
                emailField.addClass('main-valid_error').attr('data-validmsg', 'Заполните e-mail');
            }
            else {
                $.post("/?r=person/checkemail", {
                    email: email
                }, function (ans) {
                    if (ans.answer && ans.answer.length) {
                        emailField.addClass('main-valid_error').attr('data-validmsg', 'Данный e-mail уже используется');
                    }
                    else {
                        form.submit();
                    }
                })
            }
        }
        else {
            form.submit();
        }
    });
})();
