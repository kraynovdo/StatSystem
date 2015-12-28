(function(){
    $('.statconfig-charbtn').click(function(){
        $('.statconfig-charform').removeClass('main-hidden');
        $('.statconfig-fieldChar').focus();
    });

    $('.statconfig-personbtn').click(function(){
        $('.statconfig-personform').removeClass('main-hidden');
        $('.statconfig-fieldPerson').focus();
    });

    $('.statconfig-pointbtn').click(function(){
        $('.statconfig-pointform').removeClass('main-hidden');
    });
})();