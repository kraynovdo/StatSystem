$('.action-team').change(function(){
    var val = $(this).val();
    $('.action-person').empty();
    if (val) {
        $.get('/?r=matchroster/index', {
            'team' : val,
            'match' : $('.action-match').val()
        }, function(ans){
            var answer = ans.answer;
            if (answer.length == 0) {
                alert('Состав не заполнен!')
            }
            else {
                $('.action-person').append('<option value="0">Выберите игрока</option>');
                for (var i = 0; i < answer.length; i++) {
                    $('.action-person').append('<option value="' + answer[i]['personID'] + '">#' + answer[i]['number'] + ' - ' + answer[i]['surname'] + '</option>')
                }
            }
        })
    }
});