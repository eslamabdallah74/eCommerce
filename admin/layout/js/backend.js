$(function() {
    //Dashbored toggle
    $('.toggle-info').click(function () {
     $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
     if ($(this).hasClass('selected')) {
       $(this).html('<i class="far fa-plus-square"></i>')
     } else {
       $(this).html('<i class="far fa-minus-square"></i>')
     }
    });

    // hide placeholder on focus
    $('[placeholder]').focus(function() {
      $(this).attr('data-text' , $(this).attr('placeholder'));
      $(this).attr('placeholder', '');

    }).blur(function() {
      $(this).attr('placeholder' ,  $(this).attr('data-text'));
    });

  //convert pass to text
  function mouseoverPass(obj) {
    var obj = document.getElementById('password');
    obj.type = "text";
  }
  function mouseoutPass(obj) {
    var obj = document.getElementById('password');
    obj.type = "password";
  }
  //confrimation buttton on delete
  $('.confrim').click(function () {
    return confirm('Are you sure deleting this?');
  });
});
