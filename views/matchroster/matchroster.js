$(function () {
    $('.refcheck-change').click(function () {
        var itemCont = $(this).closest('.refcheck-item');
        $('.refcheck-number', itemCont).addClass('main-hidden');
        $('.refcheck-inputCont', itemCont).removeClass('main-hidden');
        $('.refcheck-change', itemCont).addClass('main-hidden');
        $('.refcheck-ok', itemCont).removeClass('main-hidden');
    });

    $('.refcheck-ok').click(function(){
        var
            itemCont = $(this).closest('.refcheck-item'),
            mr = itemCont.attr('data-mr'),
            number = $('.refcheck-input', itemCont).val();

        $.post("/?r=matchroster/update", {
            matchroster: mr,
            number: number
        }, function (res) {
            $('.refcheck-number', itemCont).removeClass('main-hidden').html('#' + number);
            $('.refcheck-inputCont', itemCont).addClass('main-hidden');
            $('.refcheck-change', itemCont).removeClass('main-hidden');
            $('.refcheck-ok', itemCont).addClass('main-hidden');
        });


    });

    $('.refcheck_confirm').click(function(){
        var id = $(this).attr('data-id');
        $.post('/?r=match/confirm', {match : id}, function(res){
            var code = parseInt(res, 10);
            if (code == 1) {
                $('.refcheck_confirm').text('Открыть на изменение');
                $('.refcheck-change').addClass('main-hidden');
                $('.refcheck-number').removeClass('main-hidden');
                $('.refcheck-inputCont').addClass('main-hidden');
                $('.refcheck-ok').addClass('main-hidden');
                $('.refcheck-auto').addClass('main-hidden');
                $('.refcheck_addLink').addClass('main-hidden');
                $('.refcheck-delete').addClass('main-hidden');
            }
            else if (code == 0) {
                $('.refcheck_confirm').text('Закрыть от изменений');
                $('.refcheck-change').removeClass('main-hidden');
                $('.refcheck-auto').removeClass('main-hidden');
                $('.refcheck_addLink').removeClass('main-hidden');
                $('.refcheck-delete').removeClass('main-hidden');
            }
        })
    });

    $('.refcheck_addLink').click(function(){
        var
            team = $(this).data('team'),
            match = $(this).data('match');

        $('.refcheck-number').removeClass('main-hidden');
        $('.refcheck-inputCont').addClass('main-hidden');

        $('.refcheck-add').removeClass('main-hidden');
        $.get('/?r=matchroster/full', {
            team : team,
            match : match
        }, function(ans){
            var select = $('.refcheck-add_player');
            select.empty();
            for (var i = 0; i < ans.length; i++) {
                var option = $('<option></option>').attr('value', ans[i]['id'])
                    .text(ans[i]['surname'] + ' ' + ans[i]['name'] + ' ' + ans[i]['patronymic']).appendTo(select);
            }
        })
    });

    $('.refcheck_okAdd').click(function(){
        var number = $('.refcheck-numberAdd').val();
        if (!number) {
            $('.refcheck-numberAdd').addClass('main-valid_error').attr('data-validmsg', 'Заполните номер');
        }
        else {
            var

                team = $('.refcheck-hTeam').val(),
                match = $('.refcheck-hMatch').val(),
                roster = $('.refcheck-add_player').val();

            $.post("/?r=matchroster/insert", {
                team : team,
                number : number,
                roster : roster,
                match : match
            }, function (res) {
                location.reload();
            });
        }
    });

    $('.refcheck-delete').click(function(){
        if (confirm('Вы уверены ?')) {
            var
                self = $(this),
                id = $(this).data('mr');

            $.post("/?r=matchroster/delete", {
                matchroster: id
            }, function (res) {
                self.closest('.refcheck-item').remove();
            });
        }

    });
});


