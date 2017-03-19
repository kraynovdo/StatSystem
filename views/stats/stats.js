(function(){
   $('[name="team"]').change(function(){
      var value = $(this).val();
      var match = $('.stats-matchId').val();
      $.cookie('stats-' + match + '-team', value, {path : '/', expires : 1});
   })
})();
