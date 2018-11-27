$(document).ready(function(){
 $(".down").click(function() {
      $("html, body").animate({
         scrollTop: $($(this).attr("href")).offset().top + "px"
      }, {
         duration: 500,
         easing: "swing"
      });
      return false;
   });

   $('.btn-order').click(function() {
   	var name = $(this).parent().find('.stock-right-title').html();
   		$('.bg-modal').fadeIn(200);
   		$('.modal-order').fadeIn(500);
   		$('.modal-order').find('.name_prod').val('Заказать '+name);
   });
   $('.btn-order2').click(function() {
   	var name = $(this).parent().parent().find('.prod__title').html();
   		$('.bg-modal').fadeIn(200);
   		$('.modal-order2').fadeIn(500);
   		$('.modal-order2').find('.name_prod2').val('Заказ '+name);
   });   
   $('.btn-price').click(function() {
   		$('.bg-modal').fadeIn(200);
   		$('.modal-price').fadeIn(500);
   });   
   $('.btn-q').click(function() {
   		$('.bg-modal').fadeIn(200);
   		$('.modal-q').fadeIn(500);
   });
   $('.bg-modal, .modal__close').click(function() {
   		$('.bg-modal').fadeOut(500);
   		$('.modal').fadeOut(200);
   });

	$(function() {
      $('form').submit(function(e) {
        var $form = $(this);
        $.ajax({
          type: 'POST',
          url: '/mail.php',
          data: $form.serialize(),
          success: function(mess) {
          	if(mess == 1) {
          		window.location.href = "/thanks.html";
          	}
          }
        });
        e.preventDefault(); 
      });
    });




});
