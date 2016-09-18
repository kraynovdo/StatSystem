if (typeof($amf) == 'undefined') {
    $amf = {};
}
$(function () {
    $amf.toggleNavig = function() {
        $('.main-navigation').toggleClass('main-hidden');
    };
    $('.main-navShowPanel').click(function(){
        $amf.toggleNavig();
    });
    $('.main-overlay').click(function(){
        $amf.toggleNavig();
    });

    /*Даты*/
    $.datepicker.setDefaults({
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
            'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
            'Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Не',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    });

    $(".main-date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd.mm.yy',
        yearRange: "1940:2017"
    });

    /*Автодополнение*/
    function MainPopup(clickHandler) {
        this._container = $('<div class="main-popup"></div>').appendTo('body');
        var
            that = this,
            click = clickHandler;
        $('body').click(function(){
            that._container.hide();
        });
        this._container.click(function(e){
            e.stopPropagation();
            if (click && click instanceof Function) {
                click(e);
            }
        })
    }
    MainPopup.prototype.move = function(field, coords) {
        if (field) {
            this._container.css({
                left : parseInt(field.offset().left) - (window.mobile ? $(window).scrollLeft() : 0) + 'px',
                top: parseInt(field.offset().top) + parseInt(field.outerHeight()) - (window.mobile ? $(window).scrollTop() : 0) + 'px'
            });
        }
        this._container.show();
    };
    MainPopup.prototype.addClass = function(className) {
        this._container.addClass(className);
    };
    MainPopup.prototype.hide = function() {
        this._container.hide();
    }
    MainPopup.prototype.setContent = function(content) {
        this._container.html(content);
    };

    function Autocomplete (field, url, paramName, onSelect, optionsCallback, render){
        var that = this;
        var callSearch = function(u, pName, v) {
            var params = (optionsCallback instanceof Function) ? optionsCallback() :  {};
            params[pName] = v;
            $.get(u, params, function(res){
                if (!that._popup) {
                    that._popup = new MainPopup(function (e) {
                        var item = $(e.target).closest('.ac-item');
                        if (item.data('id')) {
                            onSelect({
                                id: item.data('id'),
                                title: item.hasClass('ac-value') ? item.text() : item.find('.ac-value').text()
                            });
                            $(field).removeClass('main-valid_error').removeAttr('data-validmsg');
                            $amf.validWin.hideWin();
                            that._popup.hide();
                        }
                    });
                    that._popup.addClass('main-autocomplete');
                }
                that._popup.move(field);
                var rows = '';
                if (res instanceof Array) {
                    for (var i = 0; i < res.length; i++) {
                        if (render && render instanceof Function) {
                            rows += render(res[i]);
                        }
                        else {
                            rows += '<div class="listview-item ac-item ac-value" data-id="' + res[i].id + '">' + res[i].title + '</div>'
                        }

                    }
                }
                that._popup.setContent(rows)
            });
        };
        field.keyup(function(){
            var value = $(this).val();
            window.setTimeout(function(){
                if (field.val() == value) {
                    callSearch(url, paramName, value);
                }
            }, 500);
        });
        field.focusin(function(){
            var value = $(this).val();
            if (!value) {
                callSearch(url, paramName, value);
            }
        });
        field.focusout(function(){
            window.setTimeout(function(){
                if (that._popup)
                    that._popup.hide();
            }, 200)
        });
        field.click(function(e) {
        	e.stopPropagation();
        })

    };

    /*ГЕО*/
    $('.geo-country').each(function(i, item) {
        var self = item;
        new Autocomplete($(item), '/?r=geolocation/countries', 'search', function(rec){
            $(self).val(rec.title);
            var geo = $(self).attr('data-geo');
            $('[type=hidden][data-geo="'+geo+'"]').val(rec.id);
            var linkedField = $('[data-geo-country="'+geo+'"]');
            linkedField.each(function(i, item){
                var geo = $(item).data('geo');
                $('[data-geo="'+geo+'"]').val('');
            });

        });
        $(self).change(function(){
            var geo = $(this).attr('data-geo');
            $('[type=hidden][data-geo="'+geo+'"]').val('');
        });
    });

    $('.geo-region').each(function(i, item) {
        var
            self = item,
            country = $(item).data('geo-country'),
        paramsCallback = function() {
            var result = {};
            if (country) {
                var $input = $('[data-geo="' + country +'"][type=hidden]');
                if ($input.val()) {
                    result.country_id = $input.val();
                }
            }
            return result;
        };
        new Autocomplete($(item), '/?r=geolocation/regions', 'search', function(rec){
            $(self).val(rec.title);
            var geo = $(self).attr('data-geo');
            $('[type=hidden][data-geo="'+geo+'"]').val(rec.id);
            var linkedField = $('[data-geo-region="'+geo+'"]');
            linkedField.each(function(i, item){
                var geo = $(item).data('geo');
                $('[data-geo="'+geo+'"]').val('');
            })
        }, paramsCallback);
        $(self).change(function(){
            var geo = $(this).attr('data-geo');
            $('[type=hidden][data-geo="'+geo+'"]').val('');
        });
    });

    $('.geo-city').each(function(i, item) {
        var
            self = item,
            country = $(item).data('geo-country'),
            region = $(item).data('geo-region'),
            paramsCallback = function() {
                var result = {}, $input;
                if (country) {
                    $input = $('[data-geo="' + country +'"][type=hidden]');
                    if ($input.val()) {
                        result.country_id = $input.val();
                    }
                }
                if (region) {
                    $input = $('[data-geo="' + region +'"][type=hidden]');
                    if ($input.val()) {
                        result.region_id = $input.val();
                    }
                }
                return result;
            };
        new Autocomplete($(item), '/?r=geolocation/cities', 'search', function(rec){
            $(self).val(rec.title);
            var geo = $(self).attr('data-geo');
            $('[type=hidden][data-geo="'+geo+'"]').val(rec.id);
        }, paramsCallback, function(row) {
            var desc = [];
            if (row.region) {
                desc.push(row.region)
            }
            if (row.area) {
                desc.push(row.area)
            }
            var descTxt = '';
            if (desc.length) {
                descTxt = '<div class="geocity-desc">(' + desc.join(', ') + ')</div>';
            }
            return '<div class="listview-item ac-item" data-id="'+row.id+'"><div class="ac-value">'+row.title+
                '</div>' + descTxt +
            '</div>'
        });
        $(self).change(function(){
            var geo = $(this).attr('data-geo');
            $('[type=hidden][data-geo="'+geo+'"]').val('');
        });
    });
    /*ГЕО*/


    $(".main-delLink").click(function(e){
        e.preventDefault();
        if (confirm('Действительно удалить')) {
            document.location = $(this).attr('href');
        }
    });

    $('.team-compSelector').change(function(){
        var id, location, newComp, newLocation;
        id = $(this).val();
        newComp = 'comp=' + id;
        location = document.location.toString();
        if (location.indexOf('comp=') < 0) {
            newLocation = location + '&' + newComp;
        }
        else {
            newLocation = location.replace(/comp=[0-9]+/g,newComp);
        }
        document.location = newLocation;

    });

    var myValidate = function(container) {
        var error, offset;
        $("[data-validate]", container.get(0)).each(function(i, item){
            var validator = $(item).attr('data-validate');
            if ($amf.validators[validator] instanceof Function) {
                var result = $amf.validators[validator]($(item).val(), $(item));
                if (result != true) {
                    $(item).addClass('main-valid_error').attr('data-validmsg', result);
                    error = true;
                    offset = $(this).offset();
                }
                else {
                    $(item).removeClass('main-valid_error').removeAttr('data-validmsg');
                    $amf.validWin.hideWin();
                }
            }
        });
        return {
            error : error,
            offset: offset
        }
    };

    //Валидация
    $("[data-validate]").change(function(){
        $(this).removeClass('main-valid_error').removeAttr('data-validmsg');
        $amf.validWin.hideWin();
    }).hover(function(){
        if ($(this).hasClass('main-valid_error')) {
            $amf.validWin.showWin($(this), $(this).attr('data-validmsg'));
        }
    }).click(function(){
        if ($(this).hasClass('main-valid_error')) {
            $amf.validWin.showWin($(this), $(this).attr('data-validmsg'))
        }
    });

    $amf.validators = {
        req : function (value) {
            var res = true;
            if (!value) {
                res = 'Поле должно быть заполнено';
            }
            return res;
        },
        eng : function (value) {
            var res = true;
            if (!(/^[A-Za-z0-9\s]+$/).test(value) || !value) {
                res = 'Разрешены латинские буквы и цифры';
            }
            return res;
        },
        rus : function (value) {
            var res = true;
            if (!(/^[А-Яа-я0-9\s]+$/).test(value) || !value) {
                res = 'Разрешены русские буквы и цифры';
            }
            return res;
        },
        email : function (value) {
            var res = true;
            if (!(/^(.+)@(.+)$/.test(value))) {
                res = 'Введите корректный адрес почты';
            }
            return res;
        },
        phone: function (value) {
            var res = true;
            if (!(/^\+[0-9]+$/).test(value)) {
                res = 'Формат телефона + и набор цифр';
            }
            return res;
        },
        date: function (value) {
            var res = true;
            if (!(/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/).test(value)) {
                res = 'Выберите корректную дату дд.мм.гггг';
            }
            return res;
        },
        time: function (value) {
            var res = true;
            if (!(/^[0-9]{2}:[0-9]{2}$/).test(value)) {
                res = 'Выберите корректное время. Формат - чч:мм';
            }
            return res;
        },
        password: function(value) {
            var res = true;
            var valPass = $(".main-password").val();
            if (valPass != value) {
                res = 'Пароли не совпадают'
            }
            return res;
        },
        geo: function(value, item) {
            var geo = item.attr('data-geo');
            var val = $('[type=hidden][data-geo="'+geo+'"]').val();
            if (!val) {
                return 'Выберите результат из списка'
            }
            else {
                return true;
            }
        },
        geo2: function(value, item) {
            if (!value) {
                return true;
            }
            else {
                return this.geo(value, item)
            }
        }
    };

    $amf.validWin = {
        inst: null,
        showWin: function (container, text) {
            if (!this.inst) {
                this.inst = $("<div></div>").addClass('main-validWin').appendTo('body');
            }

            var
                offset = container.offset(),
                left = offset.left - (window.mobile ? $(window).scrollLeft() : 0),
                top = offset.top - 40 - (window.mobile ? $(window).scrollTop() : 0);
            this.inst.css({
                left: left - 10,
                top: top
            });

            this.inst.html(text);

            this.inst.show();
        },
        hideWin: function () {
            if (this.inst) this.inst.hide();
        }
    };

    /*Мастер*/
    $('.main-editButton_b').click(function(){
        var
            block = $(this).data('block'),
            container = $(this).closest('.main-editBlock');
            container.hide();
            $('.main-editBlock[data-block="' + block + '"]').show();
    });

    $('.main-editButton_f').click(function(){
        var
            block = $(this).data('block'),
            container = $(this).closest('.main-editBlock'),
            result = myValidate(container);
        if (!result.error) {
            container.hide();
            $('.main-editBlock[data-block="' + block + '"]').show();
        }
    });

    $(".main-submit").click(function(){

        var
            form = $(this).closest('form'),
            error = false,
            offset;

        var result = myValidate(form);

        if (!result.error) {
            form.submit();
        }
        else {
            window.scrollTo(0, result.offset.top - 60);
        }
    });


    //Файлы
    $('.main-file').each(function(i, item){
        var
            fileField = $(item),
            fileInput = $('.main-file_input', fileField);

        fileInput.click(function(e){
            e.stopPropagation();
        });

        fileField.click(function(){
            fileInput.click();
        });

        fileInput.change(function () {
            var fileField = $(this).closest('.main-file'), loader, type;
            if (fileField.hasClass('main-file_simple')) {
                type = 'simple'
            }
            else {
                type = 'image';
            }
            loader = new $amf.FileLoader({
                container : fileField,
                type : type
            });
            loader.load(this.files);
        });

    });

    $amf.FileLoader = function(cfg) {
        this._type = cfg.type;
        this._container = cfg.container;
        this._name = $('.main-file_input', this._container.get(0)).attr('name');
        this._reader = new FileReader();
        this._picture = {
            coef : 1
        };

    };
    $amf.FileLoader.prototype._loadedCallbackSimple = function(e) {
        var label = $('.main-file_label', this._container);
        label.text('Файл загружен');
        label.addClass('main-file_simple_loaded')
    };
    $amf.FileLoader.prototype._loadedCallbackImage = function(e) {
        var
            self = this,
            imgPopup = new MainPopup(),
            img, w, h, coef;
        imgPopup.addClass('main-crop');
        imgPopup.move();
        imgPopup.setContent('<div class="main-crop_imgWrapper"><img class="main-crop_img"/></div><button class="main-btn main-crop_ok roster-submit">Готово</button><button class="main-btn main-crop_cancel">Отмена</button>');
        $('.main-crop_cancel', imgPopup._container).click(function(){
            imgPopup.hide();
        });
        $('.main-crop_ok', imgPopup._container).click(function(){
            imgPopup.hide();
            self._createMiniature();
        });

        img = $('.main-crop_img', imgPopup._container).attr('src', e.target.result);

        window.setTimeout(function(){
	        w = parseInt(img.width(), 10);
	        h = parseInt(img.height(), 10);
	        self._picture.pic = img;
	        self._picture.initW = w;
	        self._picture.initH = h;
	        if (w > h) {
	            coef = 1;
	            if (w > 600) {
	                coef = 600 / w;
	            }
	        }
	        else {
	            coef = 1;
	            if (h > 600) {
	                coef = 600 / h;
	            }
	        }
	        self._picture.coef = coef;
	        self._picture.pic = img;
	        console.log(Math.round(w * coef) + ' ' + Math.round(h * coef));
	        img.Jcrop({
	            aspectRatio: 1,
	            minSize: 50,
	            setSelect: [30, 30, 180, 180],
	            boxWidth : Math.round(w * coef),
	            boxHeight : Math.round(h * coef),
	            onSelect : $amf.FileLoader.prototype._cropCallback.bind(self)
	        });
        }, 100)

    };
    $amf.FileLoader.prototype._cropCallback = function(params) {
        function _createMetaInputs (name, fileContainer) {
            var metaInp = $('[name=' + name +'_cropWidth]');
            if (metaInp.length) {
                return 1;
            }
            else {
                var coords = ['cropWidth', 'cropHeight', 'cropX', 'cropY'];
                coords.forEach(function(elem){
                    fileContainer.after($('<input type="hidden"/>').attr('name', name + '_' + elem));
                });

                return 1;
            }
        }

        _createMetaInputs(this._name, this._container);
        $('[name=' + this._name +'_cropWidth]').val(parseInt(params.w, 10));
        $('[name=' + this._name +'_cropHeight]').val(parseInt(params.h, 10));
        $('[name=' + this._name +'_cropX]').val(parseInt(params.x, 10));
        $('[name=' + this._name +'_cropY]').val(parseInt(params.y, 10));
    };
    $amf.FileLoader.prototype._createMiniature = function() {
        var
            width = $('[name=' + this._name + '_cropWidth]').val(),
            height = $('[name=' + this._name + '_cropHeight]').val(),
            x = $('[name=' + this._name + '_cropX]').val(),
            y = $('[name=' + this._name + '_cropY]').val(),
            fileWidth = parseInt(this._container.width(), 10),
            fileHeight = parseInt(this._container.width(), 10),
            coef = (fileWidth / width);

        $('.main-file_label', this._container).remove();
        $('.main-crop_img', this._container).remove();

        this._container.append(
            this._picture.pic.addClass('main-fileMiniature')
                .width(parseInt(this._picture.initW * coef, 10))
                .height(parseInt(this._picture.initH * coef, 10))
                .css('left', parseInt(-x * coef, 10))
                .css('top', parseInt(-y * coef, 10))
        );

    };
    $amf.FileLoader.prototype.load = function(files) {
        var file = files[0];
        if (this._type == 'simple') {
            this._reader.onload = this._loadedCallbackSimple.bind(this);
        } else if (this._type == 'image'){
            this._reader.onload = this._loadedCallbackImage.bind(this);
        }

        if ((this._type != 'image') || ((this._type == 'image') && file.type.match(/image.*/))) {
            this._reader.readAsDataURL(files[0]);
        }
    };

    $amf.fioSuggest = function(value, callback) {
        if (value) {
            $.post("/?r=person/autocomplete", {
                surname: value
            }, function (ans) {
                if (ans && ans.answer && ans.answer.length) {
                    var person = ans.answer;

                    var win = $('<div class="main-window roster-playerWin">\
                <h3>В системе найдены следующие персоны:</h3>\
                <div class="roster-windowRows"></div>\
                <a class="roster-windowClose" href="javascript:void(0)">Нужного нет в списке</a>\
                </div>').appendTo($('body'));
                    win.show();
                    $(".roster-windowRows").empty();
                    for (var i = 0; i < person.length; i++) {
                        if (person[i].birthdate) {
                            var date = person[i].birthdate.split('-');
                            person[i].birthdate = date[2] + "." + date[1] + "." + date[0];
                        }
                        $('<div>' +
                        '<span class="roster-surname_fio">' + person[i]['surname'] + ' ' + person[i]['name'] + ' ' + person[i]['patronymic'] + ' ' + person[i].birthdate + '</span>\n' +
                        '<a href="javascript:void(0)" class="roster-surname_choose" data-id="' + person[i]['id'] + '">выбрать</a>' +
                        '</div>').appendTo($(".roster-windowRows"));
                    }
                    $(".roster-windowClose").click(function () {
                        $(".main-window").hide();
                        $(".roster-person").val('');
                        $(".roster-windowRows").empty();
                    });
                    $(".roster-surname_choose").click(function () {
                        var id = $(this).data('id');
                        for (var j = 0; j < person.length; j++) {
                            if (parseInt(person[j].id, 10) == id) {
                                callback(person[j]);
                                $(".main-window").hide();
                                $(".main-window-rows").empty();
                                break;
                            }
                        }

                    });
                }
            });
        }
    };
    $('.main-auth_inplink').click(function(){
        $(this).closest('.main-auth').toggleClass('main-auth_expanded')
    });

    if (!window.mobile) {
    	$('.main-textEditor').ckeditor();
    }
    else {
        $('.main-textEditor').each(function(i, item){
            item.outerHTML = '<h2>Функционал ограничен для мобильных устройств</h1>';
        })
    }
});