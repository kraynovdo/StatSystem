(function(){
    $('.match-eventBtn').click(function(){
        $(this).addClass('main-hidden');
        $('.match-eventWrapper').removeClass('main-hidden');
    });
    $('.match-statsType').change(function(){
        $('.match-statsContainer').empty();
        var type = $(this).val();
        if (type) {
            $.get('/?r=stats/add', {
                type : type,
                xhrView : true
            }, function(htmlRes){
                $('.match-statsContainer').html(htmlRes);
                $('.stats-team').each(function(i, item){
                    for (var j in $amf.team) {
                        if ($amf.team.hasOwnProperty(j)) {
                            $(item).append('<option value="' + j + '">' + $amf.team[j] + '</option>')
                        }
                    }
                    $(item).change(function (k, itemInt) {
                        var
                            team = $(this).val(),
                            cont = this.closest('.main-fieldWrapper'),
                            select = $('.stats-persontype', cont);
                        select.html('<option value="">Игрок</option>');
                        for (var l in $amf.teamroster[team]) {
                            if ($amf.teamroster[team].hasOwnProperty(l)) {
                                var fio = $amf.teamroster[team][l]['number'] + ' - ' +
                                    $amf.teamroster[team][l]['surname'] + ' ' + $amf.teamroster[team][l]['name'];
                                $(select).append('<option value="' + $amf.teamroster[team][l]['personID'] + '">' + fio + '</option>')
                            }
                        }
                    });
                });
            });
        }
    });

    $('.match-matchroster_del').click(function(){
        if (confirm('Вы уверены ?')) {
            var
                self = $(this),
                id = $(this).data('mr');

            $.post("/?r=matchroster/delete", {
                matchroster: id
            }, function (res) {
                self.closest('tr').remove();
            });
        }

    });

    $('.match-matchroster_edit').click(function(){

        var
            tr = $(this).closest('tr'),
            number = $(".match-matchroster_number", tr).text().substr(1),
            fio = $(".match-matchroster_fio", tr).text();
        $('.match-matchroster_add').hide();
        var editWin = $(".match-matchroster-edit");
        editWin.css({
            left: tr.position().left - (window.mobile ? $(window).scrollLeft() : 0),
            top: tr.position().top - (window.mobile ? $(window).scrollTop() : 0),
            width: tr.width(),
            height: tr.height()
        }).show();
        $(".match-matchroster_numberinput", editWin).val(number);
        $(".match-matchroster_fioinput", editWin).text(fio);
        editWin.attr('data-mr', $(this).data('mr'));
    });

    $(".match-matchroster_cancel").click(function(){
        $(".match-matchroster-edit").hide();
    });

    $(".match-matchroster_ok").click(function(){
        var
            editWin = $(".match-matchroster-edit"),
            mr = parseInt(editWin.attr('data-mr')),
            number = $(".match-matchroster_numberinput").val();
        $.post("/?r=matchroster/update", {
            matchroster: mr,
            number: number
        }, function (res) {
            $(".match-matchroster-edit").hide();
            var
                editLink = $('.match-matchroster_edit[data-mr="' + mr + '"]'),
                tr = editLink.closest('tr');
            $(".match-matchroster_number", tr).text('#' + number);
        });
    });

    $('.match-matchroster_addlink').click(function(){
        var
            team = $(this).data('team'),
            match = $(this).data('match');
        $('.match-matchroster-edit').hide();
        $(this).after($('.match-matchroster_add').show().attr({
            'data-team' : team,
            'data-match' : match
        }));
        $.get('/?r=matchroster/full', {
            team : team,
            match : match
        }, function(ans){
            var select = $('.match-matchroster_player');
            select.empty();
            for (var i = 0; i < ans.length; i++) {
                var option = $('<option></option>').attr('value', ans[i]['id'])
                    .text(ans[i]['surname'] + ' ' + ans[i]['name'] + ' ' + ans[i]['patronymic']).appendTo(select);
            }
        })
    });

    $('.match-matchroster_okAdd').click(function(){
        var number = $('.match-matchroster_numberinputAdd').val();
        if (!number) {
            $('.match-matchroster_numberinputAdd').addClass('main-valid_error').attr('data-validmsg', 'Заполните номер');
        }
        else {
            var
                editWin = $(".match-matchroster_add"),
                team = editWin.data('team'),
                match = editWin.data('match'),
                roster = $('.match-matchroster_player').val();

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
})();
