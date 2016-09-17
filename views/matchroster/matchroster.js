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
});


