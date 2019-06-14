(function($) {

  // Navigation scrolls
  $(".navbar-nav li a").on('click', function(event) {
    $('.navbar-nav li').removeClass('active');
    $(this).closest('li').addClass('active');
    var $anchor = $(this);
    var nav = $($anchor.attr('href'));
    if (nav.length) {
      $('html, body').stop().animate({
        scrollTop: $($anchor.attr('href')).offset().top
      }, 1500, 'easeInOutExpo');

      event.preventDefault();
    }
  });
  $(".navbar-collapse a").on('click', function() {
    $(".navbar-collapse.collapse").removeClass('in');
  });

  // Add smooth scrolling to all links in navbar
  $("a.mouse-hover, a.get-quote").on('click', function(event) {
    var hash = this.hash;
    if (hash) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 1500, 'easeInOutExpo');
    }
  });
  
 // enabling or disabling school choice on the login form
 $('#type').on('change',function() {
	 var type = $('#type').val();
	 if (type=='enseignants' || type=='eleves' || type=='parents') {
		 $('#ecole').removeAttr('disabled');
	 }else{
		 $('#ecole').attr('disabled','disabled');
	 }
 });
 
 // validate the login form
  $(".btn").on('click',function(){
	  var frm = $("#loginForm");
	  var $type=$('#type').val();
	  frm.attr('action','connexion.php?type=' + $type);
	  frm.submit();
  });
  
})(jQuery);

