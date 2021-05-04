$(function() {
    // hide placeholder on focus
    $('[placeholder]').focus(function() {
      $(this).attr('data-text' , $(this).attr('placeholder'));
      $(this).attr('placeholder', '');

    }).blur(function() {
      $(this).attr('placeholder' ,  $(this).attr('data-text'));
    });

// swtich between login & sginup
$(".login-page h1 span").click(function () {
 $(this).addClass("selected").siblings().removeClass("selected");
 $(".login-page form").hide();
 $("." + $(this).data("class")).show();
  })


  // add item live view
  $(".live").keyup(function (){
    $($(this).data('class')).text($(this).val());
  });
//price tag toggle
// $(".thumbnail").mouseover(function(){
//   $(".price-tag").css('left' , '0');
// });
// $(".thumbnail").mouseleave(function(){
//   $(".price-tag ").css('left' , '-80px');
// });

});
