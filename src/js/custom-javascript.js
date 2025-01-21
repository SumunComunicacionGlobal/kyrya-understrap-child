
jQuery(document).ready(function($) {

  $(function () {
    $('[data-bs-toggle="popover"]').popover().click(function(e) {
      // e.preventDefault();
    });
  });

	var body = $('body');
  var scrolled = false;
  var navbarClasses = $('#main-nav').attr('class');
  var navbarClassesBeforeOffcanvas = navbarClasses;

  // // switch to dark navbar on offcanvas show
  $('#main-nav .offcanvas').on('show.bs.offcanvas', function () {
      navbarClassesBeforeOffcanvas = $('#main-nav').attr('class');
      $('#main-nav').removeClass('navbar-light').addClass('navbar-dark');
  });

  // // switch to light navbar on offcanvas hide
  $('#main-nav .offcanvas').on('hide.bs.offcanvas', function () {
      $('#main-nav').removeClass('navbar-dark').addClass(navbarClassesBeforeOffcanvas);
  });

  jQuery(window).scroll(function() {
  var scroll = $(window).scrollTop();
  if (scroll >= 25) {
    body.addClass("scrolled");
          scrolled = true;
          $('#main-nav').removeClass('navbar-dark').addClass('navbar-light bg-white');
      } else {
          body.removeClass("scrolled");
          scrolled = false;
          $('#main-nav').removeClass('navbar-light bg-white').addClass(navbarClasses);
      }

      if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
          body.addClass("near-bottom");
      } else {
          body.removeClass("near-bottom");
      }
  });

});




(function ($) {
  jQuery('.wpcf7-uacf7_country_dropdown').each(function(){
    var fieldId = jQuery(this).attr('id');
    // var defaultCountry = jQuery(this).attr('country-code');
    var defaultCountry = jQuery('#top-bar .wpml-ls-item-active').text();
    console.log(defaultCountry);

    if ( defaultCountry == 'en' ) {
      defaultCountry = 'gb';
    }

    // alert(defaultCountry);
    
    $("#"+fieldId).countrySelect({
      defaultCountry: defaultCountry,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      responsiveDropdown: true,
      preferredCountries: ['es', 'gb', 'fr', 'it', 'de', 'pt', 'us']
    });
  });
})(jQuery);
  
  
jQuery(document).ready(function($) {

    $(".carrusel-post").carousel('cycle');
    $(".carrusel-post").on("slide.bs.carousel", function (e) {
        var slideFromId = $(this).find(".active").index();
        var slideToId = $(e.relatedTarget).index();
        // console.log(slideFromId+' => '+slideToId);

        $( ".carousel-indicators li.active" ).removeClass("active");
        $( ".carousel-indicators li").eq(slideToId).addClass("active");

    });

    $('.hero-slider').slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 6000,
      arrows: true,
      dots: false,
    });
  
    $('.slick-slider').slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 3000,
      arrows: true,
      dots: false,
    });
  
    $('.slick-product-slider').slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 10000,
      arrows: true,
      dots: true,
      adaptiveHeight: true,
    });

});
  
  
  
  jQuery(document).ready(function($) {
    
    $('.wpcf7-list-item-label, label').each(function(index) {
      var text = $(this).text().trim();
      if ( text.indexOf('/*') >= 0 ) {
        var textArray = text.split('/*');
        var newTextHtml = '';
  
        $.each(textArray, function(indexTextArray,value) {
          if ( 'undefined' != value ) {
            var langElement = value.split('*/');
            newTextHtml += '<span class="show-lang-' + langElement[0] + '">' + langElement[1] + '</span>';
          }
        });
  
        var oldHtml = $(this).html().trim();
  
        newTextHtml += oldHtml.substring(text.length);
        $(this).html(newTextHtml);
  
      }
    });
      
    var campoTipo = $('input[name="kt"]');
    var campoProducto = $('input[name="kn"]');
    if (campoProducto.length) {
      if (campoProducto.val().length > 0) {
        $('#consulta-sobre').html( '+ info: ' + campoTipo.val() + ' ' + campoProducto.val());
        $('#consulta-sobre').show();
      } else {
        $('#consulta-sobre').hide();
      }
    }
      
    // Detect windows width function
    var $window = $(window);
    const spinner = '<div class="text-center my-5"><div class="spinner-grow text-secondary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    
    function checkWidth() {
      var windowsize = $window.width();
      if (windowsize > 767) {
        // if the window is greater than 767px wide then do below. we don't want the modal to show on mobile devices and instead the link will be followed.
  
        $(".modal-link").click( function(e) {
          e.preventDefault();

          $("#modal-ajax-post").modal("show");
          var modalContent = $("#modal-ajax-post .modal-body");
          var post_link = $(this).attr("href"); // this can be used in WordPress and it will pull the content of the page in the href
          
          modalContent.html( spinner ); // display loading animation or in this case static content
          modalContent.load(post_link + ' #modal-ready', function() {
  
            $('.slick-product-slider').slick({
              infinite: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              autoplay: true,
              autoplaySpeed: 10000,
              arrows: true,
              dots: true,
              adaptiveHeight: true,
            });
        
          });
  
        });
      }
    };
  
    checkWidth(); // excute function to check width on load
    $(window).resize(checkWidth); // execute function to check width on resize

  });
  