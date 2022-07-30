// ------------step-wizard-------------
$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();

    //Wizard
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var target = $(e.target);

        if (target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        active.next().removeClass('disabled');
        nextTab(active);

    });
    $(".prev-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        prevTab(active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}


$('.nav-tabs').on('click', 'li', function() {
    $('.nav-tabs li.active').removeClass('active');
    $(this).addClass('active');
});


/*******************************slick slider****************************************/

$(document).ready(function(){
  $('.featured-slider').slick({
    infinite: true,
    autoplay: true,
    nextArrow: '.cus-arrow-left',
    prevArrow: '.cus-arrow-right',
  });

  $('.review-slider').slick({
    infinite: true,
    autoplay: true,
    dots: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    nextArrow: '.cus-arrow-left',
    prevArrow: '.cus-arrow-right',
    responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
  });
});




//-----JS for Price Range slider-----

$(function() {
	$( "#slider-range1" ).slider({
	  range: true,
	  min: 150,
	  max: 15000000,
	  values: [ 150, 9900000 ],
	  slide: function( event, ui ) {
		$( "#amount1" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
	  }
	});
	$( "#amount1" ).val( "$" + $( "#slider-range1" ).slider( "values", 0 ) +
	  " to   $" + $( "#slider-range1" ).slider( "values", 1 ) );
});


$(function() {
	$( "#slider-range2" ).slider({
	  range: true,
	  min: 150,
	  max: 15000000,
	  values: [ 150, 9900000 ],
	  slide: function( event, ui ) {
		$( "#amount2" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
	  }
	});
	$( "#amount2" ).val( "$" + $( "#slider-range2" ).slider( "values", 0 ) +
	  " to   $" + $( "#slider-range2" ).slider( "values", 1 ) );
});


/***************************************************** */
$(document).ready(function(){
  $('.cus-profile-nav .nav-item .nav-link').click(function(){
    $('.cus-profile-nav .nav-item .nav-link.active').removeClass('active');
    $(this).addClass('active');
  });
});

$(document).ready(function (){
  $(".scroll-offset").click(function (){

      var scrollsId = $(this).attr('data-section');
      $('.scroll-offset').removeClass('active');
      $(this).addClass('active');

      if ('#'+scrollsId.length) {
          $('html, body').animate({
              scrollTop: $('#'+scrollsId).offset().top
          }, 600);
      }
  });
});


