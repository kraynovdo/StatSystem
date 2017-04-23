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
        var self = this;
        $.post('/?r=match/confirm', {match : id}, function(res){
            var code = parseInt(res, 10);
            if (code == 1) {
                $(self).text('Открыть на изменение');
                $('.refcheck-change').addClass('main-hidden');
                $('.refcheck-number').removeClass('main-hidden');
                $('.refcheck-inputCont').addClass('main-hidden');
                $('.refcheck-ok').addClass('main-hidden');
            }
            else if (code == 0) {
                $(self).text('Закрыть от изменений');
                $('.refcheck-change').removeClass('main-hidden');
            }
        })
    })
});


