(function(){
   $('.request-status').change(function(e, val){
      var value = $(this).val();
      if (value) {
         $('.request-statusField').removeClass('main-hidden');
         $('.request-ogrn').attr('data-validate', 'ogrn');
         $('.request-egrulFile').attr('data-validate', 'req');
      }
      else {
         $('.request-statusField').addClass('main-hidden');
         $('.request-ogrn').removeAttr('data-validate');
         $('.request-egrulFile').removeAttr('data-validate');
      }

   })
})();
