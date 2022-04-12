(function ($) {
   "use strict";
  
   //------- OWL carousle init  ---------------
  jQuery(document).ready(function(){
    function init_carousel_owl(){
      $('.init-carousel-owl').each(function(){
        var items = $(this).data('items') ? $(this).data('items') : 5;
        var items_lg = $(this).data('items_lg') ? $(this).data('items_lg') : 4;
        var items_md = $(this).data('items_md') ? $(this).data('items_md') : 3;
        var items_sm = $(this).data('items_sm') ? $(this).data('items_sm') : 2;
        var items_xs = $(this).data('items_xs') ? $(this).data('items_xs') : 1;
        var loop = $(this).data('loop') ? $(this).data('loop') : false;
        var speed = $(this).data('speed') ? $(this).data('speed') : 200;
        var auto_play = $(this).data('auto_play') ? $(this).data('auto_play') : false;
        var auto_play_speed = $(this).data('auto_play_speed') ? $(this).data('auto_play_speed') : false;
        var auto_play_timeout = $(this).data('auto_play_timeout') ? $(this).data('auto_play_timeout') : 1000;
        var auto_play_hover = $(this).data('auto_play_hover') ? $(this).data('auto_play_hover') : false;
        var navigation = $(this).data('navigation') ? $(this).data('navigation') : false;
        var rewind_nav = $(this).data('rewind_nav') ? $(this).data('rewind_nav') : false;
        var pagination = $(this).data('pagination') ? $(this).data('pagination') : false;
        var mouse_drag = $(this).data('mouse_drag') ? $(this).data('mouse_drag') : false;
        var touch_drag = $(this).data('touch_drag') ? $(this).data('touch_drag') : false;
        if(items == 1 ) items_lg = items_md = items_sm = items_xs = 1;
        $(this).owlCarousel({
            nav: navigation,
            autoplay: auto_play,
            autoplayTimeout: auto_play_timeout,
            autoplaySpeed: auto_play_speed,
            autoplayHoverPause: auto_play_hover,
            navText: [ '<i class="gv-icon-164"></i>', '<i class="gv-icon-165"></i>' ],
            autoHeight: false,
            loop: loop, 
            dots: pagination,
            rewind: rewind_nav,
            smartSpeed: speed,
            mouseDrag: mouse_drag,
            touchDrag: touch_drag,
            responsive : {
                0 : {
                  items: 1,
                  nav: false
                },
                480 : {
                  items : items_xs
                },
                768 : {
                  items : items_sm
                },
                992: {
                  items : items_md
                },
                1200: {
                  items: items_lg
                },
                1400: {
                  items: items
                }
            }
        });
     }); 
  }

  init_carousel_owl();

  $('.init-carousel-owl.nav-center-image').each(function(){
    var height_thumbnail = $(this).find('.post-thumbnail').first().height();
    $(this).find('.owl-nav .owl-prev, .owl-nav .owl-next').css("top", height_thumbnail/2);
  })

  $('.gsc-tabs-views-ajax ul[data-load="ajax"] a').on('click', function(){
      var $href = $(this).data('panel');
      var self = $(this);
      var main = $($href);
      var main_elements = $($href);
      self.parents('.nav-tabs').find('li').removeClass('active');
      self.parent('li').addClass('active');
      if ( main.length > 0 ) {
        if(main_elements.data('loaded') == false){
          self.parents('.gsc-tabs-views-ajax').addClass('ajaxloadding');
          $.ajax({
              url: drupalSettings.gavias_load_ajax_view,
              type:'POST',
              dataType: 'html',
              data:  'view=' + main.data('view')
          }).done(function(reponse) {
            main_elements.html( reponse );
            main.data('loaded', 'true');
            self.parents('.gsc-tabs-views-ajax').find('.tab-pane').removeClass('active');
            $($href).addClass('active');
            init_carousel_owl();
            Drupal.attachBehaviors(document);
            self.parents('.gsc-tabs-views-ajax').removeClass('ajaxloadding');
          });
          return true;
        }else{
          self.parents('.gsc-tabs-views-ajax').find('.tab-pane').removeClass('active');
          $($href).addClass('active');
        }
      }
    });

/* ============ Isotope ==============*/
  if ( $.fn.isotope ) {
    if($('.isotope-items').length){
      $( '.isotope-items' ).each(function() {
        var _pid = $(this).data('pid');
        var $el = $( this ),
            $filter = $( '.portfolio-filter a.' + _pid ),
            $loop =  $( this );

        $loop.isotope();

        $loop.imagesLoaded(function() {
          $loop.isotope( 'layout' );
        });
        var i = 0;

        function reloay(){
          var e = $(document).scrollTop();
          //console.log($(window).height());
          $loop.each(function(){
            var o = $loop.parents('.gva-portfolio-items');
            if(o.length){
              if(o.offset().top <= (e + $(window).height())  && o.offset().top + $(window).height() > e){
                $loop.isotope( 'layout' );
              } 
            }
          });
        }

        $(window).load(function(){
          setTimeout(function() {
            reloay();
          }, 1000);
        });  

        $(document).scroll(function() {
          reloay();
        });

        if ( $filter.length > 0 ) {
          $filter.on( 'click', function( e ) {
            e.preventDefault();
            var $a = $(this);
            $filter.removeClass( 'active' );
            $a.addClass( 'active' );
            $loop.isotope({ filter: $a.data( 'filter' ) });
          });
        };
      });
    }
  };

  function scrolltop() {
    var offset = 300;
    var duration = 500;
    jQuery(window).scroll(function() {
      if (jQuery(this).scrollTop() > offset) {
        jQuery('.return-top').fadeIn(duration);
      } else {
        jQuery('.return-top').fadeOut(duration);
      }
    });

    jQuery('.return-top').click(function(event) {
      event.preventDefault();
      jQuery('html, body').animate({scrollTop: 0}, duration);
      return false;
    });
  }
  scrolltop();

  if ($(window).width() > 780) {
    if ( $.fn.jpreLoader ) {
      var $preloader = $( '.js-preloader' );
      $preloader.jpreLoader({
        autoClose: true,
      }, function() {
        $preloader.addClass( 'preloader-done' );
        $( 'body' ).trigger( 'preloader-done' );
        $( window ).trigger( 'resize' );
      });
    }
  }else{
    $('body').removeClass('js-preloader');
  };

  $('#gva-offcanvas-inner').perfectScrollbar();
  
  // ==================================================================================
  // Offcavas
  // ==================================================================================
  $('#menu-bar').on('click',function(e){
    if($('.gva-offcanvas-inner').hasClass('show-view')){
        $(this).removeClass('show-view');
        $('.gva-offcanvas-inner').removeClass('show-view');
        $('body').removeClass('enable-offcanvas');
    }else{
        $(this).addClass('show-view');
        $('.gva-offcanvas-inner').addClass('show-view'); 
        $('body').addClass('enable-offcanvas');
    }
    e.stopPropagation();
  })

  $('#menu-bar-another').on('click',function(e){
    if($(this).hasClass('show-view')){
      $(this).removeClass('show-view');
      $(this).parent().find('.content-inner').removeClass('show-view');
    }else{
      $(this).addClass('show-view');
      $(this).parent().find('.content-inner').addClass('show-view'); 
    }
    e.stopPropagation();
  })

  $('.close-offcanvas a').on('click', function(e){
    if($('.gva-offcanvas-inner').hasClass('show-view')){
      $('body').removeClass('enable-offcanvas');
      $('.gva-offcanvas-inner').removeClass('show-view');
      $('#menu-bar').removeClass('show-view');
    }
    e.stopPropagation();
  });


  $('.sidebar').theiaStickySidebar({
		additionalMarginTop: 30,
    minWidth: 992
  });

  var $container = $('.post-masonry-style');
  $container.imagesLoaded( function(){
      $container.masonry({
          itemSelector : '.item-masory',
          gutterWidth: 0,
          columnWidth: 1,
      }); 
  });

  $('.gva-search-region .icon').on('click',function(e){
    if($(this).parent().hasClass('show')){
        $(this).parent().removeClass('show');
    }else{
        $(this).parent().addClass('show');
    }
    e.stopPropagation();
  })

  $('.gva-search-region .close').on('click',function(e){
    $(this).parents('.gva-search-region').removeClass('show');
  });

  $('.gva-account-region .icon').on('click',function(e){
    if($(this).parent().hasClass('show')){
        $(this).parent().removeClass('show');
    }else{
        $(this).parent().addClass('show');
    }
    e.stopPropagation();
  })

  function load_lazy(){
    if(drupalSettings.layzy_load=='on'){
      $(window).off('scroll.unveil resize.unveil lookup.unveil');
      setTimeout(function(){
        $("img.unveil-image").unveil(100, function() {
          $(this).addClass('image-loaded');
            var $container = $('.post-masonry-style');
            $container.imagesLoaded( function(){
                $container.masonry({
                    itemSelector : '.item-masory',
                    gutterWidth: 0,
                    columnWidth: 1,
                }); 
            });
        });
      }, 200);
    }
    return false;
  }
  load_lazy();

  /*========== Click Show Sub Menu ==========*/
  $('.gva-navigation a').on('click','.nav-plus',function(){
    if($(this).hasClass('nav-minus') == false){
      $(this).parent('a').parent('li').find('> ul').slideDown();
      $(this).addClass('nav-minus');
    }else{
      $(this).parent('a').parent('li').find('> ul').slideUp();
      $(this).removeClass('nav-minus');
    }
    return false;
  });

 //==== Customize =====
  $('.gavias-skins-panel .control-panel').click(function(){
      if($(this).parents('.gavias-skins-panel').hasClass('active')){
          $(this).parents('.gavias-skins-panel').removeClass('active');
      }else $(this).parents('.gavias-skins-panel').addClass('active');
  });

  $('.gavias-skins-panel .layout').click(function(){
      $('body').removeClass('wide-layout').removeClass('boxed');
      $('body').addClass($(this).data('layout'));
      $('.gavias-skins-panel .layout').removeClass('active');
      $(this).addClass('active');
      var $container = $('.post-masonry-style');
      $container.imagesLoaded( function(){
          $container.masonry({
              itemSelector : '.item-masory',
              gutterWidth: 0,
              columnWidth: 1,
          }); 
      });
  });
  
  /*-------------Milestone Counter----------*/
  jQuery('.milestone-block').each(function() {
    jQuery(this).appear(function() {
      var $endNum = parseInt(jQuery(this).find('.milestone-number').text());
      jQuery(this).find('.milestone-number').countTo({
        from: 0,
        to: $endNum,
        speed: 4000,
        refreshInterval: 60,
        formatter: function (value, options) {
          value = value.toFixed(options.decimals);
          value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
          return value;
        }
      });
    },{accX: 0, accY: 0});
  });
  
  /*----------- Animation Progress Bars --------------------*/
  $("[data-progress-animation]").each(function() {
    var $this = $(this);
    $this.appear(function() {
      var delay = ($this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1);
      if(delay > 1) $this.css("animation-delay", delay + "ms");
      setTimeout(function() { $this.animate({width: $this.attr("data-progress-animation")}, 800);}, delay);
    }, {accX: 0, accY: -50});
  });
  
  /*----------------------------------------------------*/
  /*  Pie Charts
  /*----------------------------------------------------*/
  var pieChartClass = 'pieChart',
        pieChartLoadedClass = 'pie-chart-loaded';
    
  function initPieCharts() {
    var chart = $('.' + pieChartClass);
    chart.each(function() {
      $(this).appear(function() {
        var $this = $(this),
          chartBarColor = ($this.data('bar-color')) ? $this.data('bar-color') : "#F54F36",
          chartBarWidth = ($this.data('bar-width')) ? ($this.data('bar-width')) : 150
        if( !$this.hasClass(pieChartLoadedClass) ) {
          $this.easyPieChart({
            animate: 2000,
            size: chartBarWidth,
            lineWidth: 8,
            scaleColor: false,
            trackColor: "#eee",
            barColor: chartBarColor,
          }).addClass(pieChartLoadedClass);
        }
      });
    });
  }
  initPieCharts();
    //===== Gallery ============
    $(".lightGallery").lightGallery({
      selector: '.image-item .zoomGallery'
    });
  //===== Popup video ============
    $('.popup-video').magnificPopup({
      type: 'iframe',
      fixedContentPos: false
    });

  // ============================================================================
  // Fixed top Menu Bar
  // ============================================================================
  if($('.gv-sticky-menu').length > 0){
    var sticky = new Waypoint.Sticky({
      element: $('.gv-sticky-menu')[0]
    });
  }  

  //Fix caption image for gallery post 
  $('.article-detail .post-thumbnail.post-gallery .owl-item .item img').each(function(){
    var $title = $(this).attr('title');
    if($title && $title != undefined){
      $(this).parent().append('<div class="caption">'+$title+'</div>');
    }
  })

  $('.newsticker').newsTicker({
    max_rows: 1,
    duration: 4000,
    speed: 800,
    autostart: 1,
  });

  setTimeout(function() {
    AOS.init({
      offset: 150,
      disable: window.innerWidth < 1024,
      delay: 100,
      duration: 600,
      once: true
    });
  }, 100);

    $('.menu-hover .navigation .gva_menu li').hoverIntent({
      over: function () {
        $(this).parent().find('li').removeClass('menu-hover-intent');
        $(this).addClass('menu-hover-intent');
      },
      out: function () {
        $(this).removeClass('menu-hover-intent');
      },
      timeout: 250
    });

    // Make the toolbar menu navigable with keyboard.
    $('.menu-hover .navigation .gva_menu li a').on('focusin', function () {
      $('li.menu-item--expanded').removeClass('menu-hover-intent');
      $(this).parents('li.menu-item--expanded').addClass('menu-hover-intent');
    });

    $('.menu-hover .navigation .gva_menu li a').keydown(function (e) {
      if ((e.shiftKey && (e.keyCode || e.which) == 9)) {
        if ($(this).parent('.menu-item').prev().hasClass('menu-item--expanded')) {
          $(this).parent('.menu-item').prev().addClass('menu-hover-intent');
        }
      }
    });


});

  $(window).load(function(){
    if($('.block-gavias-sliderlayer, .before-help-region').length > 0){
      var html_help = $('div.help').html();
      $('.gav-help-region').remove();
      html_help = '<div class="gav-help-region">' + html_help + '</div>';
      if($('.before-help-region').length > 0){
        $('.before-help-region').first().append(html_help);
      }else{
        $('.block-gavias-sliderlayer').first().after(html_help);
      }
      $('.gav-help-region').show();
    }else{
      var html_help = $('div.help').html();
      $('.gav-help-region').remove();
      html_help = '<div class="gav-help-region">' + html_help + '</div>';
      $('#page-main-content').first().before(html_help);
      $('.gav-help-region').show();
    }
  })
  
})(jQuery);
