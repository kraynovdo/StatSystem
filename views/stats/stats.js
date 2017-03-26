(function(){
   $('[name="team"]').change(function(){
      var value = $(this).val();
      var match = $('.stats-matchId').val();
      $.cookie('stats-' + match + '-team', value, {path : '/', expires : 1});
   });

   $('[name="qb"]').change(function(){
      var team = $('[name="team"]:checked').val();
      var qb = $(this).val();
      var match = $('.stats-matchId').val();
      $.cookie('stats-' + match + '-team-' + team + '-qb', qb, {path : '/', expires : 1});
   })
})();
