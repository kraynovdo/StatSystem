(function () {
   function RosterSelector() {
      this.team = undefined;
      this.type = undefined;
      this.chooseCallback = undefined;
   }

   RosterSelector.prototype.show = function (team, type, chooseCallback, chooseErrback) {
      var rosterContainer = $('.stats-screen_screenRoster[data-id="' + team + '"]').show();
      $('.stats-screen_screenMain').hide();
      myCharSelector._hide();
      if (type == 2) {
         $('.stats-screen_screenContent', rosterContainer.get(0)).addClass('stats-screen_screenContent_def')
      }
      else {
         $('.stats-screen_screenContent', rosterContainer.get(0)).removeClass('stats-screen_screenContent_def')
      }

      this.team = team;
      this.type = type;
      this.chooseCallback = chooseCallback;
      this.chooseErrback = chooseErrback;

   };

   RosterSelector.prototype.hide = function () {
      $('.stats-screen_screenRoster').hide();
   };

   RosterSelector.prototype.choose = function (team, id, number) {
      this.hide();
      this.chooseCallback(team, id, number);
   };

   var myRosterSelector = new RosterSelector();

   var Team = {
      match: null,
      curTeam: null,
      otherTeam: null
   };
   var match = $('.stats-matchId').val(),
      team1 = $('.stats-team1Id').val(),
      team2 = $('.stats-team2Id').val(),
      comp = $('.stats-compId').val();
   Team.match = match;
   Team.comp = comp;
   Team.curTeam = $.cookie('stats-' + match + '-team') ? $.cookie('stats-' + match + '-team') : team1;
   Team.otherTeam = Team.curTeam == team1 ? team2 : team1;


   $('[name="team"]').change(function () {
      Team.otherTeam = Team.curTeam;
      var value = $(this).val();
      Team.curTeam = value;
      var match = $('.stats-matchId').val();
      $.cookie('stats-' + match + '-team', value, {path: '/', expires: 1});

      $('.stats-screen_QBChoose').hide();
      $('.stats-screen_QBChoose[data-id="' + value + '"]').show();
   });

   $('.stats-screen_QBChoose').on('click', '.stats-screen_QBRadio', function () {
      var team = Team.curTeam;
      var qb = $(this).val();
      var match = $('.stats-matchId').val();
      $.cookie('stats-' + match + '-team-' + team + '-qb', qb, {path: '/', expires: 1});
   });

   $('.stats-screen_qbAdd').click(function () {
      var match = $('.stats-matchId').val();
      var team = Team.curTeam;
      myRosterSelector.show(team, 1, function (team, id, number) {
         var curQbAdd = $.cookie('stats-' + match + '-team-' + team + '-qbArr');
         var curQbAddArray = [];
         if (curQbAdd) {
            curQbAddArray = JSON.parse(curQbAdd);
         }
         curQbAddArray.push({
            'id': id,
            'number': number
         });
         $.cookie('stats-' + match + '-team-' + team + '-qbArr', JSON.stringify(curQbAddArray), {
            path: '/',
            expires: 1
         });
         $('.stats-screen_QBChoose[data-id="' + team + '"]').append('\
            <span class="main-tile_rb">\
               <input data-number="' + number + '" type="radio" name="qb' + team + '" value="' + id + '" \
                  id="qb' + team + '_' + id + '" class="main-hidden stats-screen_QBRadio"> \
               <label for="qb' + team + '_' + id + '" class="main-tile">' + number + '</label>\
            </span>');
         $('.stats-screen_screenMain').show();
      }, function(){
         $('.stats-screen_screenMain').show();
      });
   });

   $('.stats-screen_rosterOk').click(function () {
      var radio = $('[name="player' + myRosterSelector.team + '"]:checked');
      var team = myRosterSelector.team;
      myRosterSelector.hide();
      myRosterSelector.choose(team, radio.val(), radio.attr('data-number'));
   });

   $('.stats-screen_rosterCancel').click(function () {
      myRosterSelector.hide();
      myRosterSelector.chooseErrback();
   });

   $('.stats-screen_charContent').on('click', '.stats-screenPassRes', function () {
      var id = $(this).attr('data-id');
      switch (id) {
         case '1':
            myCharSelector.incomplete();
            break;
         case '2':
            myRosterSelector.show(myCharSelector.team, 1, function (team, id, number) {
               myCharSelector._clear();
               myCharSelector._showPassChar(team, id, number);
            }, function(){
               $('.stats-screen_screenMain').show();
            });
            break;
         case '3':
            myRosterSelector.show(Team.otherTeam, 2, function (team, id, number) {
               myCharSelector.passknock(team, id, number);
            }, function(){
               $('.stats-screen_screenMain').show();
            });
            break;
         case '4':
            myRosterSelector.show(Team.otherTeam, 2, function (team, id, number) {
               myCharSelector.intercept(team, id, number);
            }, function(){
               $('.stats-screen_screenMain').show();
            });
            break;
      }
   });

   $('.stats-screen_charContent').on('click', '.stats-screen_tackleChoose', function () {
      myRosterSelector.show(Team.otherTeam, 2, function (team, id, number) {
         myCharSelector._show();
         var tacklers = myCharSelector._findTacklers(myCharSelector.def);
         if (myCharSelector.data.tacklers.arr.length < tacklers.length) {
            myCharSelector.data.tacklers.arr.push(id);
            $('.stats-screen_tacklersList').append(' <span class="main-tile">' + number + '</span>')
         }
         if (myCharSelector.data.tacklers.arr.length >= tacklers.length) {
            $('.stats-screen_tackleChoose').hide();
         }
      }, function(){
         $('.stats-screen_char').show();
      })
   });

   $('.stats-screen_charContent').on('click', '.stats-screen_pg', function () {
      function prepareCompletePassData() {
         var def = myCharSelector.def['psstackle'];
         if (def && myCharSelector.data.tacklers) {
            for (var i = 0; i < myCharSelector.data.tacklers.arr.length; i++) {
               myCharSelector.data.person[def[i]] = myCharSelector.data.tacklers.arr[i];
            }
            delete(myCharSelector.data.tacklers);
         }
      }

      function prepareRushData() {
         var def = myCharSelector.def['runtackle'];
         if (def && myCharSelector.data.tacklers) {
            for (var i = 0; i < myCharSelector.data.tacklers.arr.length; i++) {
               myCharSelector.data.person[def[i]] = myCharSelector.data.tacklers.arr[i];
            }
            delete(myCharSelector.data.tacklers);
         }
      }

      var id = $(this).attr('data-id');
      if (typeof id !== 'undefined') {
         myCharSelector.data.point = id;
      }


      if (myCharSelector.actiontype == 'pass') {
         prepareCompletePassData(myCharSelector);
      }
      else if (myCharSelector.actiontype == 'rush') {
         prepareRushData(myCharSelector);
      } else {
         //tacklers
         /*TODO*/
         var def = myCharSelector.def[Object.keys(myCharSelector.def)[0]];
         if (def && myCharSelector.data.tacklers) {
            for (var i = 0; i < myCharSelector.data.tacklers.arr.length; i++) {
               myCharSelector.data.person[def[i]] = myCharSelector.data.tacklers.arr[i];
            }
            delete(myCharSelector.data.tacklers);
         }
         /*TODO--*/
      }
      //char
      $('.stats-screenCharValue').each(function (i, item) {
         var id = $(item).attr('data-id');
         myCharSelector.data.char[id] = $(item).val();
      });


      //main-info
      myCharSelector._fillMainInfo();

      myCharSelector.push();
   });

   $('.stats-screen_charContent').on('click', '.stats-screen_fum', function () {
      myCharSelector._fillMainInfo();
      myCharSelector.push();
   });

   $('.stats-screen_charContent').on('click', '.stats-screen_fumRec', function () {
      myRosterSelector.show(Team.otherTeam, 2, function (team, id, number) {
         myCharSelector.data.person[myCharSelector.def.fumrec] = id;
         myCharSelector._fillMainInfo();
         myCharSelector.push();
      },function(){
         $('.stats-screen_char').show();
      });


   });

   function CharSelector() {

   }

   CharSelector.prototype.push = function () {
      var self = this;
      $.post('/?r=match/createEvent', this.data, function (res) {
         self._clear();
         myRosterSelector.hide();
         $('.stats-screen_screenMain').show();
      });
   };

   CharSelector.prototype._fillMainInfo = function () {
      myCharSelector.data.match = Team.match;
      myCharSelector.data.competition = Team.comp;
      myCharSelector.data.teamSt = [Team.curTeam];
   };

   CharSelector.prototype.passknock = function (team, id) {
      this.data.person = {};
      this.data.person[this.off.passer[0]] = this.qb;
      this.data.person[this.def.passknock[0]] = id;
      this._fillMainInfo();
      this.push();
   };

   CharSelector.prototype.intercept = function (team, id) {
      this.data.person = {};
      this.data.person[this.off.passer[0]] = this.qb;
      this.data.person[this.def.intercept[0]] = id;
      this._fillMainInfo();
      this.push();
   };

   CharSelector.prototype.incomplete = function (team, id) {
      this.data.person = {};
      this.data.person[this.off.passer[0]] = this.qb;

      this._fillMainInfo();
      this.push();
   };

   CharSelector.prototype._hide = function () {
      $('.stats-screen_char').hide()
   };

   CharSelector.prototype._show = function () {
      $('.stats-screen_char').show()
   };

   CharSelector.prototype._clear = function (actionId) {
      $('.stats-screen_screenMain').hide();
      $('.stats-screen_charContent').empty();
      this.content = $('.stats-screen_charContent');
      this._show();
   };

   CharSelector.prototype.show = function (actiontype, actionId, qb, off, def, answer) {
      this.actiontype = actiontype;
      this.off = off;
      this.def = def;
      this.answer = answer;
      this.qb = qb;
      this.team = $('[name="team"]:checked').val();
      this.data = {
         actionType: actionId
      };
      this._clear(actionId);

      if (this.actiontype == 'pass') {
         this._showPassResult();
      }
      else if (this.actiontype == 'fumble') {
         this._showFumbleResult();
      } else {
         myRosterSelector.show(myCharSelector.team, 1, function (team, id, number) {
            myCharSelector._clear();
            myCharSelector._showPersonChar(team, id, number);
         }, function(){
            $('.stats-screen_screenMain').show();
         });
      }
   };

   CharSelector.prototype._setContent = function (markup) {
      this.content.html(markup);
   };

   CharSelector.prototype._findTacklers = function (def) {
      var result = [];
      for (var i in def) if (def.hasOwnProperty(i)) {
         if (i.indexOf('tackle') >= 0) {
            result = def[i];
         }
      }
      return result;
   };

   CharSelector.prototype._showPersonChar = function (team, id, number, addParams) {
      var markup = '';
      this.data.person = {};
      /*TODO*/
      this.data.person[this.off[Object.keys(this.off)[0]][0]] = id;
      if (this.actiontype == 'rush') {
         this.data.person[this.off['runner']] = id;
         this.data.person[this.off['rpasser']] = this.qb;
      }
      /*TODO--*/

      var markupBefore = '';
      if (addParams && addParams.markupBefore) {
         markupBefore = addParams.markupBefore;
      }

      markup += '<div class="stats-screenCharHead">' + markupBefore + '<span class="main-tile">' + this.answer.action.name + '</span>';
      markup += ' <span class="main-tile">' + number + '</span></div>';

      for (var i = 0; i < this.answer.chartype.length; i++) {
         markup += '\
         <div class="main-fieldWrapper">\
            <label class="main-label_top">' + this.answer.chartype[i]['name'] + '</div>\
            <input class="stats-screenCharValue" value="0" type="number" data-id="' + this.answer.chartype[i]['id'] + '"/>\
         </div>';
         this.data.char = {};
         this.data.char[this.answer.chartype[i].id] = 0;
      }


      markup += '</div>';

      if (Object.keys(this.def).length) {
         var tacklers = this._findTacklers(this.def);

         if (Object.keys(tacklers).length) {
            this.data.tacklers = {
               count: tacklers.length,
               arr: []
            };
            markup += '<div>\
               <label class="main-label_top">Захваты</label>\
               <div class="stats-screen_tacklersList"></div>\
               <div><span class="main-tile stats-screen_tackleChoose">+ Захвативший</span></div></div>';
         }
      }

      var point = this.answer.point;
      markup += '<div><label class="main-label_top">Результат</label>';
      markup += '<div class=""><span class="main-tile stats-screen_pg" >Очки не набраны</span></div>';
      for (i = 0; i < point.length; i++) {
         markup += '<div><span class="main-tile stats-screen_pg stats-screen_success" data-id="' + point[i]['id'] + '">' + point[i].name + '</span></div>';
      }

      this._setContent(markup);
   };

   CharSelector.prototype._showPassChar = function (team, id, number) {

      var qb = $('[name=qb' + team + ']:checked').val();
      var qbNumber = $('[name=qb' + team + ']:checked').attr('data-number');
      var markup = '<span class="main-tile">' + qbNumber + '</span> ';
      this._showPersonChar(team, id, number, {
         markupBefore: markup
      });
      this.data.person[this.off['receiver']] = id;
      this.data.person[this.off['passer']] = this.qb;
   };

   CharSelector.prototype._showPassResult = function () {
      var markup = '';
      markup += '<div class="main-tile stats-screenPassRes" data-id="1">Не принят</div>';
      markup += ' <div class="main-tile stats-screenPassRes" data-id="2">Принят</div>';
      markup += ' <div class="main-tile stats-screenPassRes" data-id="3">Сбит</div>';
      markup += ' <div class="main-tile stats-screenPassRes" data-id="4">Перехвачен</div>';
      this._setContent(markup);
   };

   CharSelector.prototype._showFumbleResult = function () {
      myRosterSelector.show(Team.curTeam, 1, function (team, id, number) {
         myCharSelector.data.person = {};
         myCharSelector.data.person[myCharSelector.off.fum] = id;

         var markup = '';
         markup += '<div class="stats-screenCharHead"><span class="main-tile">' + myCharSelector.answer.action.name + '</span>';
         markup += ' <span class="main-tile">' + number + '</span></div>';
         markup += '</div>';

         markup += '<div><label class="main-label_top">Подобран</label>';
         markup += '<div class=""><span class="main-tile stats-screen_fum" >Своей командой</span></div>';
         markup += '<div class=""><span class="main-tile stats-screen_fumRec" >Соперником</span></div>';


         myCharSelector._setContent(markup);
         myCharSelector._show();
      }, function() {
         $('.stats-screen_screenMain').show();
      });
   };

   CharSelector.prototype.choose = function () {

   };

   var myCharSelector = new CharSelector();

   $('.stats-screen_action').click(function () {
      var id = $(this).attr('data-id');
      $.get('/?r=stats/add', {
         type: id
      }, function (res) {
         var answer = res.answer;
         var offperson = {}, defperson = {}, neededObj;
         var pt = answer.persontype;
         for (var i = 0; i < pt.length; i++) {
            neededObj = null;
            if (pt[i].offdef == 1) {
               neededObj = offperson;

            } else if (pt[i].offdef == 2) {
               neededObj = defperson;
            }
            if (neededObj) {
               if (!neededObj[pt[i].code]) {
                  neededObj[pt[i].code] = [pt[i].id]
               }
               else {
                  neededObj[pt[i].code].push(pt[i].id)
               }
            }
         }


         var qb = $('[name="qb' + Team.curTeam + '"]:checked').val();
         switch (answer.action.code) {
            case 'pass':
               myCharSelector.show('pass', id, qb, offperson, defperson, answer);
               break;
            case 'rush':
               myCharSelector.show('rush', id, qb, offperson, defperson, answer);
               break;
            case 'fumble':
               myCharSelector.show('fumble', id, qb, offperson, defperson, answer);
               break;
            default:
               myCharSelector.show('', id, qb, offperson, defperson, answer);
         }
      });
   });
})();
