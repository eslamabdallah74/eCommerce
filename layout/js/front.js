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


 $("." + $(this).data("class")).fadeIn(200);
  })

  $(".live").keyup(function (){
    $($(this).data('class')).text($(this).val());
  });


});
