$(document).ready(function() {


    /* ======= Fixed header when scrolled ======= */

    $(window).bind('scroll', function() {
         if ($(window).scrollTop() > 0) {
             $('#header').addClass('header-scrolled');
         }
         else {
             $('#header').removeClass('header-scrolled');
         }
    });

    /* ======= Scrollspy ======= */
    $('body').scrollspy({ target: '#header', offset: 100});

    /* ======= ScrollTo ======= */
    $('a.scrollto').on('click', function(e){

        //store hash
        var target = this.hash;

        e.preventDefault();

		$('body').scrollTo(target, 800, {offset: -50, 'axis':'y'});
        //Collapse mobile menu after clicking
		if ($('.navbar-collapse').hasClass('show')){
			$('.navbar-collapse').removeClass('show');
		}

	});

  $(function() {
  var owl = $(".owl-carousel");
  owl.owlCarousel({
    items: 2,
    margin: 10,
    loop: true,
    nav: true,
    dots: true,
    navText: [
  '<a class="carousel-control-prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a>',
  '<a class="carousel-control-next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a>'
],
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            dots:true
        },
        900:{
            items:2,

            dots:true
        }
    }
  });
});

});
