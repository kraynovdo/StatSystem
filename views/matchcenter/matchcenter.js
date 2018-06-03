/**
 * Created with JetBrains PhpStorm.
 * User: Пользователь
 * Date: 22.04.18
 * Time: 19:16
 * To change this template use File | Settings | File Templates.
 */
$('.match-videoEdit').click(function(){
    $('.match-videoForm').toggleClass('fafr-hidden');
});

$('.match-navig_link').click(function(){
    var scrollTop = $(window).scrollTop();
    var href = $(this).attr('href');
    href += '&sc=' + scrollTop + '#nav';
    $(this).attr('href', href);
});