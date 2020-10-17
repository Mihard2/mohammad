;(function($){

	'use strict';

	$(function(){
	
	$('.current-menu-item').addClass('current');
	$('.current_page_parent').addClass('current');
	$('.cp-navigation>.current_page_ancestor').addClass('current');
	$('.menu-item-has-children').addClass('dropdown');
	$("#main-navigation ul.sub-menu").wrap("<div class='sub-menu-wrap'></div>");
	$("#navbar-menu ul.sub-menu").wrap("<div class='sub-menu-wrap'></div>");
	$("#main-navigation ul.children").wrap("<div class='sub-menu-wrap'></div>");
	$("#navbar-menu ul.children").wrap("<div class='sub-menu-wrap'></div>");
	$('.sub-menu-wrap .sub-menu-wrap').addClass('sub-menu-inner');
	$('.sub-menu-wrap .menu-item-has-children').addClass('sub');
	
	$('#sidebar .widget').addClass('widget-bg');
	$('#sidebar .widget.like_box_facebook').addClass('widget-bg2');
	$('#sidebar .widget_meta ul').addClass('custom-list type-1');
	$('#sidebar .widget_archive ul').addClass('custom-list type-1');
	$('#sidebar .widget_categories ul').addClass('custom-list type-1');
	$('#sidebar .widget_nav_menu ul').addClass('custom-list type-1');
	$('#sidebar .widget_pages ul').addClass('custom-list type-1');
	$('#sidebar .widget_recent_entries ul').addClass('custom-list type-1');
	$('#sidebar .widget_product_categories ul').addClass('custom-list type-1');
	$('.widget_recent_comments ul').addClass('info-links comment-type');
	
	$('#footer .widget_meta ul').addClass('info-links');
	$('#footer .widget_archive ul').addClass('info-links');
	$('#footer .widget_categories ul').addClass('info-links');
	$('#footer .widget_nav_menu ul').addClass('info-links');
	$('#footer .widget_pages ul').addClass('info-links');
	$('#footer .widget_recent_entries ul').addClass('info-links');
	$('#footer .widget_product_categories ul').addClass('info-links');
	$('#footer.footer-4 .container').addClass('extra-size');
	$('#footer.footer-5 .container').addClass('extra-size');
	$('.widget_calendar tbody a').parent('td').addClass('link');

	$('.gform_button').addClass('btn btn-style-4 btn-big');
	
		/* ---------------------------------------------------- */
		/*	Countdown											*/
		/* ---------------------------------------------------- */

		$('.countdown').each(function(){
			var $this = $(this),
				endDate = $this.data(),
				until = new Date(
					endDate.year,
					endDate.month || 0,
					endDate.day || 1,
					endDate.hours || 0,
					endDate.minutes || 0,
					endDate.seconds || 0
				);
			// initialize
			$this.countdown({
				until : until,
				format : 'dHMS',
				labels : inforward_global_vars.countdown_labels,
				labels1 : inforward_global_vars.countdown_labels1
			});
		});

		/* ---------------------------------------------------- */
        /*	Tweets carousel									*/
        /* ---------------------------------------------------- */
		if($(".carousel-twitter").length){
		
		var self = $(this);
		
		var owlConfig = {
					smartSpeed : 450,
				    autoplay : true,
				    autoplayTimeout: 3000,
				    navText : false,
				    lazyLoad: true,
					nav:true,
					loop: true,
					items: 1
				}
				$(".carousel-twitter ul").addClass('owl-carousel');
				$(".carousel-twitter ul").addClass('align-center');
				$(".carousel-twitter").addClass('carousel-type-1');
				$(".carousel-twitter .info-btn").addClass('align-center btn btn-style-2');
				$(".carousel-twitter .info-btn").removeClass('info-btn');
				$(".carousel-twitter .owl-carousel").owlCarousel(owlConfig)
		}

		document.addEventListener("touchstart", function() {},false);

		if ('ontouchstart' in document.documentElement) {
			$('body').css('cursor', 'pointer');
		}

		/* ---------------------------------------------------- */
		/*	Newsletter								    */
		/* ---------------------------------------------------- */
		if ($('.cp_newsletter').length) {
			//$('.message-container-subscribe').fadeOut('slow');
		
			$('.cp_newsletter').each(function(){
				
				$(this).on('submit', function (e) {
					e.preventDefault();

					var $this = $(this);
					var message =  $(this).find('.message-container-subscribe');
					var gdpr =  $(this).find('.comment-form-cookies-consent input');
					
					
					if( !gdpr.length || (gdpr.length && gdpr.is(':checked')) ) {
					
					
					$(this).find('.ajax-loader').show();
					$this.ajaxSubmit({
						type	: 'POST',
						url		: inforward_global_vars.ajaxurl,
						data	: { 
						ajax_nonce : inforward_global_vars.ajax_nonce, 
						action : 'add_to_mailchimp_list' 
						},
						timeout	: 10000,
						dataType: 'json',
						success	: function (responseText) {
							message.html('<div class="alert-box warning"><p>'+responseText.text+'</p></div>')
							.slideDown()
							.delay(4000)
							.slideUp(function(){
							  $(this).html("");
							});
							
							$(this).find('.ajax-loader').hide();

							$this.trigger('reset');
						}
					});
					
					}
					
					
				});
			 
			});  
		}
		
		function facebookShare(){
		
			window.open( 'https://www.facebook.com/sharer/sharer.php?u='+this+'&t='+$(this).attr('title'), "facebookWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0" ) 
			return false;
		}
		
		$('.share-facebook').click(facebookShare);
	
		function twitterShare(){
		
			window.open( 'http://twitter.com/intent/tweet?text='+$(this).attr('title') +' '+this, "twitterWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0" ) 
			return false;
		}
		
		$('.share-twitter').click(twitterShare);
		
		/* ---------------------------------------------------- */
		/*	Items equal height									*/
		/* ---------------------------------------------------- */

		$(window).on('load resize',function() {
			
			 project_equal_height();
		    
		});
		
		$(document).ready(function(){
			 project_equal_height();
		});			


		function project_equal_height(){ 
		    var biggestHeight = 0;   
		    $('.portfolio_des').each(function(){   
		        if($(this).height() > biggestHeight){   
		            biggestHeight = $(this).height();  
		        }  
		    });   
		    $('.portfolio_des').height(biggestHeight); 
		};	

	    /* ---------------------------------------------------- */
		/*	Menu switcher									    */
		/* ---------------------------------------------------- */

			$(document).ready( function() {
				
				$('.cp-header.clone-fixed').css('opacity','1');
				
				if ($('#navbar-menu').length){

				$(".navbar-toggle").on('click',function() {
					 $(this).toggleClass('active');
		             $('#navbar-menu').toggleClass('open-navbar');
		             return false;
		         });
				 
		        var $win = $('.wrapper-container'); 
				var $box = $("#navbar-menu");
				
			 	$win.on("click.Bst", function(event){		
					if ( 
		            $box.has(event.target).length === 0 //checks if descendants of $box was clicked
		            &&
		            !$box.is(event.target) //checks if the $box itself was clicked
			        ){
						$('#navbar-menu').removeClass('open-navbar');
						$(".navbar-toggle").removeClass('active');
					}
				});

				$("#navbar-close").on('click',function() {
		            $('#navbar-menu').removeClass('open-navbar');
		            return false;
		        });

		        $("li.dropdown > a").on('click',function() {
		            $(this).next('.sub-menu-wrap').slideToggle(400);
		            return false;
		        });
				 

				}
			});

	

		/* ---------------------------------------------------- */
		/*	events switcher									    */
		/* ---------------------------------------------------- */

		if ($('.tribe-events-filters').length){

			$('#tribe_events_filters_toggle').on('click', function() {
				$('.tribe-events-filters').addClass('show-filter');
			});

			$('#tribe_events_filters_close_filters').on('click', function() {
				$('.tribe-events-filters').removeClass('show-filter');
			});

			$('.tribe-events-filters-group-heading').on('click', function() {
				$(this).parent('.tribe_events_filter_item').toggleClass('active');
			});

		}

	    /* ---------------------------------------------------- */
        /*	Isotope												*/
        /* ---------------------------------------------------- */

		$( window ).on('load', function() {

		  	var $container = $('.isotope');
		    $('#filters button').on('click', function(){
		    	var $this = $(this);
		        if ( !$this.hasClass('is-checked') ) {
		          $this.parents('#options').find('.is-checked').removeClass('is-checked');
		          $this.addClass('is-checked');
		        }
				var selector = $this.attr('data-filter');
				$container.isotope({  itemSelector: '.item', filter: selector });
				return false;
		    });

		    $.mad_core.isotope();
			 
			/* ---------------------------------------------------- */
			/*	Custom Select										*/
			/* ---------------------------------------------------- */

			if ($('.custom-select').length) {
				$('.custom-select').madCustomSelect();
			} 
 
		});

		/* ---------------------------------------------------- */
        /*	Gallery carousel									*/
        /* ---------------------------------------------------- */


		
	  	$(document).ready( function() {
			
		var pageCarousel = $('.owl-carousel');

		if(pageCarousel.length){

			$('.owl-carousel').not('#thumbnails').each(function(){

				var max_items = $(this).data('max-items');
				var tablet_items = max_items;
				if(max_items > 1){
					tablet_items = max_items - 1;
				}
				var mobile_items = 1;

				var autoplay_carousel = $(this).data('autoplay');
				var autoplay_timeout = $(this).data('timeout');
				if(!autoplay_timeout) {
					autoplay_timeout = 3000;
				}

				var center_carousel = $(this).data('center');

				var item_margin = $(this).data('item-margin');

				var item_dots = $(this).data('dots');

				$(this).owlCarousel({
				    smartSpeed : 450,
				    nav : true,
				    loop  : true,
				    autoplay : autoplay_carousel,
				    center: center_carousel,
				    autoplayTimeout: autoplay_timeout,
				    navText : false,
				    margin: item_margin,
				    lazyLoad: true,
					dots: true,
      				dotsData: item_dots,
				    rtl: $.mad_core.SUPPORT.ISRTL ? true : false,
				    responsiveClass:true,
				    responsive : {
				        0:{
				            items:mobile_items
				        },
				        481:{
				            items:tablet_items
				        },
				        992:{
				            items:max_items
				        }
				    }
				});
			});

			$('.custom-owl-prev').on('click',function(){

				$('.owl-carousel').trigger('prev.owl.carousel');

				return false;

			});

			$('.custom-owl-next').on('click',function(){

				$('.owl-carousel').trigger('next.owl.carousel');

				return false;

			});

			if($('#thumbnails').length){
				$('#thumbnails').each(function(){
					var data = $(this).data();
					var max_items = $(this).data('max-items');
					var tablet_items = max_items;
					if(max_items > 1){
						tablet_items = max_items - 1;
					}
					var mobile_items = 1;

					var autoplay_carousel = $(this).data('autoplay');
					
					$(this).owlCarousel({
						items : max_items,
						URLhashListener : false,
						navSpeed : 800,
						nav : false,
						loop : false,
						margin: 10,
						rtl: $.mad_core.SUPPORT.ISRTL ? true : false,
						navText:false,
						responsive : {
					        0:{
					            items:tablet_items
					        },
					        481:{
					            items:max_items
					        },
					        1200:{
					            items:max_items
					        }
					    }
				    });
				});
			    
			}
		}
		
		});

		/* ---------------------------------------------------- */
		/*	Background size screen								*/
		/* ---------------------------------------------------- */

	    if ($('.media-holder.full-src').length) {

	    	$(window).on('load resize',function(){
		        $('.media-holder').css('height', window.innerHeight+'px');
		    });

	    }

		/* ---------------------------------------------------- */
        /*	Tabs												*/
        /* ---------------------------------------------------- */

        $(window).on("load",function(){

        	var tabs = $('.tabs-section');
			if(tabs.length){
				tabs.tabs({
					beforeActivate: function(event, ui) {
				        var hash = ui.newTab.children("li a").attr("href");
				   	},
					hide : {
						effect : "fadeOut",
						duration : 450
					},
					show : {
						effect : "fadeIn",
						duration : 450
					},
					updateHash : false
				});
			}

			/* ------------------------------------------------
				Tabs - opacity
			------------------------------------------------ */

			var tabs = $('.mad-tabs');

			if(tabs.length){

				tabs.MadTabs({
					easing: 'easeOutQuint',
					speed: 600,
					cssPrefix: 'mad-'
				});

			}

        });

		/* ---------------------------------------------------- */
        /*	Loader												*/
        /* ---------------------------------------------------- */

		if ( $('body').hasClass('loading-overlay-1') && $('.loader').length) {
			$("body").queryLoader2({
				backgroundColor: inforward_global_vars.load_bg_color,
				barColor : inforward_global_vars.load_color,
				barHeight: 4,
				deepSearch:true,
				minimumTime:1000,
				onComplete: function(){
					$(".loader").fadeOut('200');
				}
			});
		}

		/* ---------------------------------------------------- */
        /*	Sticky menu											*/
        /* ---------------------------------------------------- */

		if ( $('header').hasClass('header-sticky-1') ) {
			$('body').Temp({
				sticky: true
			});
		}

		/* ---------------------------------------------------- */
        /*	Price Scale										    */
        /* ---------------------------------------------------- */

		var slider;
		if($('#price').length){
			slider = $('#price').slider({ 
		 		animate: true,
				range: true,
				values: [ 1, 99 ],
				min: 1,
				max: 99,
				slide : function(event ,ui){
					$('.range-values').find('.first-limit').val('$' + ui.values[0] + ',000');
					$('.range-values').find('.last-limit').val('$' + ui.values[1] + ',000');
				}
			});
		}
		if($('#distance').length){
			slider = $( "#distance" ).slider({
				animate: true,
			    value: 0,
			    min: 0,
			    max: 1000,
			    step: 1,
			    slide: function( event, ui ) {
			       $( "#amount" ).val(  ui.value + " km" );
			       $( "#total" ).val(  "Total: $ " + ui.value );
			    }
		    });
		    $( "#amount" ).val( $( "#distance" ).slider( "value" ) + " km" );
		    $( "#total" ).val( "Total: $ " +  $( "#distance" ).slider( "value" ) );
		}

		/* ---------------------------------------------------- */
        /*	Accordion & Toggle									*/
        /* ---------------------------------------------------- */

		var aItem = $('.accordion:not(.toggle) .accordion-item'),
			link = aItem.find('.a-title'),
			$label = aItem.find('label'),
			aToggleItem = $('.accordion.toggle .accordion-item'),
			tLink = aToggleItem.find('.a-title');

			aItem.add(aToggleItem).children('.a-title').not('.active').next().hide();

		function triggerAccordeon($item) {
			$item
			.addClass('active')
			.next().stop().slideDown()
			.parent().siblings()
			.children('.a-title')
			.removeClass('active')
			.next().stop().slideUp();
		}

		if ($label.length) {
			$label.on('click',function(){
				triggerAccordeon($(this).closest('.a-title'))
			});
		} else {
			link.on('click',function(){
				triggerAccordeon($(this))
			});
		}

		tLink.on('click',function(){
			$(this).toggleClass('active')
			.next().stop().slideToggle();

		});

		/* ---------------------------------------------------- */
        /*	Quantity											*/
        /* ---------------------------------------------------- */

		var q = $('.quantity');

		q.each(function(){
			var $this = $(this),
				button = $this.children('button'),
				input = $this.children('input[type="text"]'),
				val = +input.val();

			button.on('click',function(){
				if($(this).hasClass('qty-minus')){
					if(val === 1) return false;
					input.val(--val);
				}
				else{
					input.val(++val);
				}
			});
		});

		/* ---------------------------------------------------- */
		/*	Animate a regular anchor navigation					*/
		/* ---------------------------------------------------- */

	    if ($('a.animated').length) {

	    	$('body').localScroll({
	           hash: true,
	           filter: '.animated',
	           onBefore: function(){
                 this.offset = -200;
               }
	        });

	    }

	    /* ---------------------------------------------------- */
		/*	Elevate zoom										*/
		/* ---------------------------------------------------- */

		if($('[data-zoom-image]').length){

			var button = $('.qv-preview');

			$("#zoom-image").elevateZoom({
				gallery:'thumbnails',
				galleryActiveClass: 'active',
				zoomType: "inner",
				cursor: "crosshair",
				responsive:true,
			    zoomWindowFadeIn: 500,
				zoomWindowFadeOut: 500,
				easing:true,
				lensFadeIn: 500,
				lensFadeOut: 500
			});

		}

	});

})(jQuery);