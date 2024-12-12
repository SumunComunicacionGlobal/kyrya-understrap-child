
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
        autoplaySpeed: 4000,
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
    
    $('.aparecer').each(function(index) {
      var i = index + 1;
      var delay = 0.04;
      $(this).css('animation-delay', delay * i + 's');
    });
  
    $('.aparecer').addClass("hidden").viewportChecker({
        classToAdd: 'visible animated fadeInUp',
        offset: 100,
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
  
      $(document).click(function (event) {
          var clickover = $(event.target);
          var _expanded = $("#navbar-toggler").attr("aria-expanded");
          // alert(_closed);
          if (_expanded === 'true' && !clickover.hasClass("navbar-toggler") && !clickover.hasClass("nav-link")  && !clickover.hasClass("form-control") ) {
              $("#navbar-toggler").click();
          }
      });
  
    // Close modal 
    $('.close-modal').click(function() {
      $('.modal').toggleClass('show');
    });
  
    // Detect windows width function
    var $window = $(window);
  
    function checkWidth() {
      var windowsize = $window.width();
      if (windowsize > 767) {
        // alert(windowsize);
        // if the window is greater than 767px wide then do below. we don't want the modal to show on mobile devices and instead the link will be followed.
  
        $(".modal-link").click(function(e) {
  
          $("#modal-ajax-post").modal("show");
          var modalContent = $("#modal-ajax-post .modal-body");
          // var modalContent = $("#modal-body");
  
  
          // var post_link = $('.show-in-modal').html(); // get content to show in modal
          var post_link = $(this).attr("href"); // this can be used in WordPress and it will pull the content of the page in the href
          
          e.preventDefault(); // prevent link from being followed
          
          $('.modal').addClass('show', 1000, "easeOutSine"); // show class to display the previously hidden modal
          modalContent.html("loading..."); // display loading animation or in this case static content
          // modalContent.html(post_link); // for dynamic content, change this to use the load() function instead of html() -- like this: modalContent.load(post_link + ' #modal-ready')
          modalContent.load(post_link + ' #modal-ready', function() {
          // modalContent.load(post_link, function() {
  
            var base_url = window.location.origin;
            if ( base_url.includes("localhost") || base_url.includes("viral.sumun.net")) {
              base_url += "/kyrya";
            }
            // $.getScript( base_url + "/wp-content/themes/kyrya/js/carousel-thumbnails.js");
            $.getScript( base_url + "/wp-content/themes/kyrya-understrap-child/js/child-theme.min.js");
          });
  
        });
      }
    };
  
    checkWidth(); // excute function to check width on load
    $(window).resize(checkWidth); // execute function to check width on resize
  });
  