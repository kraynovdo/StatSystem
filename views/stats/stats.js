(function(){
   function RosterSelector() {
      this.team = undefined;
      this.type = undefined;
      this.chooseCallback = undefined;
   }

   RosterSelector.prototype.show = function(team, type, chooseCallback) {
      $('.stats-screen_screenRoster[data-id="' + team + '"]').show();
      $('.stats-screen_screenMain').hide();

      this.team = team;
      this.type = type;
      this.chooseCallback = chooseCallback;
   };

   RosterSelector.prototype.hide = function() {
      $('.stats-screen_screenRoster').hide();
      $('.stats-screen_screenMain').show();

      this.team = undefined;
      this.type = undefined;
      this.chooseCallback = undefined;
   };

   RosterSelector.prototype.choose = function(id, number) {
      this.chooseCallback(this.team, id, number);
      this.hide();
   };

   var myRosterSelector = new RosterSelector();

   $('[name="team"]').change(function(){
      var value = $(this).val();
      var match = $('.stats-matchId').val();
      $.cookie('stats-' + match + '-team', value, {path : '/', expires : 1});

      $('.stats-screen_QBChoose').hide();
      $('.stats-screen_QBChoose[data-id="' + value + '"]').show();
   });

   $('.stats-screen_QBChoose').on('click', '.stats-screen_QBRadio' ,function(){
      var team = $(this).closest('.stats-screen_QBChoose').attr('data-id');
      var qb = $(this).val();
      var match = $('.stats-matchId').val();
      $.cookie('stats-' + match + '-team-' + team + '-qb', qb, {path : '/', expires : 1});
   });

   $('.stats-screen_qbAdd').click(function(){
      var match = $('.stats-matchId').val();
      var team = $.cookie('stats-' + 234 + '-team');
      myRosterSelector.show(team, 1, function(team, id, number){
         var curQbAdd = $.cookie('stats-' + match + '-team-' + team + '-qbArr');
         var curQbAddArray = [];
         if (curQbAdd) {
            curQbAddArray = JSON.parse(curQbAdd);
         }
         curQbAddArray.push({
            'id' : id,
            'number' : number
         });
         $.cookie('stats-' + match + '-team-' + team + '-qbArr', JSON.stringify(curQbAddArray), {path : '/', expires : 1});
         $('.stats-screen_QBChoose[data-id="' + team + '"]').append('\
            <span class="main-tile_rb">\
               <input type="radio" name="qb' + team +'" value="' + id + '" \
                  id="qb' + team + '_'+ id + '" class="main-hidden stats-screen_QBRadio"> \
               <label for="qb' + team + '_'+ id + '" class="main-tile">'+number+'</label>\
            </span>')
      });
   });

   $('.stats-screen_rosterOk').click(function(){
      var radio = $('[name="player' + myRosterSelector.team + '"]:checked');
      myRosterSelector.choose(radio.val(), radio.attr('data-number'));
      myRosterSelector.hide();
   });

   $('.stats-screen_rosterCancel').click(function(){
      myRosterSelector.hide();
   })
})();
