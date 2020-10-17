;(function($){

	'use strict';

	$.mad_core = $.mad_core || {};

	$.mad_core = {

		setUp: function (options) {
			var base = this;

			var animEndEventNames = {
				'WebkitAnimation' : 'webkitAnimationEnd',
				'OAnimation' : 'oAnimationEnd',
				'msAnimation' : 'MSAnimationEnd',
				'animation' : 'animationend'
			},
			transEndEventNames = {
				'WebkitTransition': 'webkitTransitionEnd',
				'MozTransition': 'transitionend',
				'OTransition': 'oTransitionEnd',
				'msTransition': 'MSTransitionEnd',
				'transition': 'transitionend'
			}

			base.$window = $(window);
			base.ANIMATIONEND = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
			base.TRANSITIONEND = "webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend";
			base.SUPPORT = {
				animations : Modernizr.csstransitions && Modernizr.cssanimations,
				ANIMATIONSUPPORTED: Modernizr.cssanimations,
				TRANSITIONSUPPORTED: Modernizr.csstransitions,
				ISRTL: getComputedStyle(document.body).direction === 'rtl',
				ISTOUCH: Modernizr.touch
			};
			base.XHRLEVEL2 = !!window.FormData;
			base.event = base.SUPPORT.ISTOUCH ? 'touchstart' : 'click';

			// Refresh elements
			base.refresh();
		},

		DOMLoaded: function(options) {

			var base = this;

			// set up
			base.setUp(options);

			// counters
			if($('.counter').length) base.counters();
			
			// responsive menu
			if($('#header').length) base.navInit.init(this);

			// search
			if($('.search-holder').length) base.searchHolder();

			// background load
			if($('[data-bg]').length) base.bg();

			// sync carousel
			if($('.owl-carousel[data-sync]').length) base.syncOwlCarousel.init();

			// init view types (product boxes)
			if($('[data-view]').length) base.viewTypes();

			// dropdown elements init
			if($('.dropdown-invoker').length) base.dropdown();

			// close btn init
			if($('.item-close').length) base.closeBtn();
			if($('.shopping-cart-full').length) base.removeProduct();

			// hidden elements init
			if($('.hidden-section').length) base.hiddenSections();

			// prealoader init
			if($('#loader').length) base.preloader({
				waitAfterLoad: 1500
			});

		},

		elements: {
			'.main-navigation, .topbar:not(.no-mobile-advanced)': 'navMain',
			'#mobile-advanced': 'navMobile',
			'#wrapper': 'wrapper',
			'#header' : 'header'
		},

		/*
		Plugin Name: 	Refresh
		*/
		$: function (selector) {
			return $(selector);
		},

		refresh: function() {
			for (var key in this.elements) {
				this[this.elements[key]] = this.$(key);
			}
		},

		/*
		Plugin Name: 	SearchHolder
		*/
		searchHolder : function () {

		    $.searchClick = function (el, options) {
				this.el = $(el);
				this.init(options);
			}

			$.searchClick.DEFAULTS = {
				key_esc: 27
			}

			$.searchClick.prototype = {
				init: function (options) {
					var base = this;
					base.o = $.extend({}, $.searchClick.DEFAULTS, options);
					base.key_esc = base.o.key_esc;
					base.searchWrap = $('.searchform-wrap');
					base.searchBtn = $('.search-button', base.el);
					base.searchClose = $('.close-search-form', base.el);
					base.searchField = $('#s', base.el);
					base.event = Modernizr.touch ? 'touchstart' : 'click';

					base.set();
					base.bind();
				},
				set: function () {
					var transEndEventNames = {
						'WebkitTransition': 'webkitTransitionEnd',
						'MozTransition': 'transitionend',
						'OTransition': 'oTransitionEnd',
						'msTransition': 'MSTransitionEnd',
						'transition': 'transitionend'
					};
					this.transEndEventName = "webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend";
					this.animations = Modernizr.csstransitions;
				},
				hide: function () {
				    var base = this;
				    base.searchWrap.addClass('closed').removeClass('opened');
				    var onEndTransitionFn = function () {
				      base.searchWrap.removeClass('closed');
				    };
				    if (base.animations) {
				      base.searchWrap.on(base.transEndEventName, onEndTransitionFn);
				    } else {
				      onEndAnimationFn();
				    }

				    var $body = $(document.body),
				    $popup = $(".searchform-wrap");

				},
				bind: function () {
					this.searchBtn.on(this.event, $.proxy(this.display_show, this));
					this.searchClose.on(this.event, $.proxy(function (e) {
						this.display_hide(e, this.key_esc);
					}, this));
					this.keyDownHandler(this.key_esc);

					$(window).on("load",function(){

				        var $win = $('.wrapper-container'); // or $box parent container
						var $box = $(".searchform-wrap");
						var $sb = $(".search-button");
						
					 	$win.on("click.Bst", function(event){		
							if ( 
				            $box.has(event.target).length === 0 //checks if descendants of $box was clicked
				            &&
				            !$box.is(event.target) //checks if the $box itself was clicked
				            &&
				            !$sb.is(event.target) //checks if the $box itself was clicked
					        ){
								$('.searchform-wrap').removeClass('opened');
							}
						});

						$('.close-search-form').on( "click", function() {
						  $('.searchform-wrap').removeClass('opened');
						});
						  
					});
				},
				display_show: function (e) {
					e.preventDefault();
					if (!this.searchWrap.hasClass('opened')) {
						this.searchWrap.addClass('opened');
						this.searchField.focus();
					}
				},
				display_hide: function (e, key) {
					var base = this;
					if (base.searchWrap.hasClass('opened')) {
						if (e.type == base.event || e.type == 'keydown' && e.keyCode === key) {
							e.preventDefault();
							base.hide();
							base.searchField.blur();
						}
					}
				},
				keyDownHandler: function (key) {
					$(window).on('keydown', $.proxy(function (e) {
						this.display_hide(e, key);
					}, this));
				}
			}

			$.fn.extend({
				searchClick: function (option) {
					if (!this.length) return this;
					return this.each(function () {
						var $this = $(this), data = $this.data('searchClick'),
							options = typeof option == 'object' && option;
						if (!data) {
							$this.data('searchClick', new $.searchClick(this, options));
						}
					});
				}
			});

			var searchHolder = $('.search-holder');

			if (searchHolder.length) {
				searchHolder.searchClick();

				$("#search-btn").on('click',function() {
					$(this).toggleClass('active');
		            $('.join-us').toggleClass('open-search');
		            return false;
		        });

			}

		},

		/**
		 * Emulates single accordion item
		 * @param Function callback
		 * @return jQuery collection;
		 **/
		hiddenSections: function(callback){

			var collection = $('.hidden-section');
			if(!collection.length) return;

			collection.each(function(i, el){
				$(el).find('.content').hide();
			});

			collection.on('click.hidden', '.invoker', function(e){

				e.preventDefault();

				var content = $(this).closest('.hidden-section').find('.content');

				content.slideToggle({
					duration: 500,
					easing: 'easeOutQuint',
					complete: callback ? callback : function(){}
				});

			});

			return collection;

		},

		/**
		 * Initializes dropdown module
		 * @return Object Core;
		 **/
		dropdown: function(){

			var dropdown = {

				init: function(){

					this.bindEvents();

				},

				bindEvents: function(){

					var self = this;

					$('body').on('click', '.dropdown-invoker', function(e){

						e.preventDefault();
						e.stopPropagation();

						var invoker = $(this),
							dropdown = invoker.next('.dropdown-window');

						self.smartPosition(dropdown);
						
						invoker.add(dropdown).toggleClass('opened');
						dropdown.parent().toggleClass('dropdown-over');

					});

					$(document).on('click', function(e){

						var dropdown = $('.dropdown-window');

						if(!$(e.target).closest(dropdown).length){

							dropdown.add(dropdown.prev('.dropdown-invoker')).removeClass('opened');
							dropdown.parent().removeClass('dropdown-over');

						}

					});

				},

				smartPosition: function(dropdown){

					var dWidth = dropdown.outerWidth(),
						dOfsset = dropdown.offset().left,
						$wW = $(window).width();

					if(dOfsset + dWidth > $wW) dropdown.addClass('reverse');

				}

			}

			dropdown.init();

			return this;

		},

		/**
		 * Initialize global close event
		 * @return Object Core;
		 **/
		closeBtn: function(){

			$('body').on('click.globalclose', '.item-close:not(.shopping-cart-full .item-close)', function(e){

				e.preventDefault();

				$(this).parent().stop().animate({
					opacity: 0
				}, function(){

					$(this).stop().slideUp(function(){

						$(this).remove();

					});

				});

			});

			return this;

		},

		/**
		Remove item
		**/
		removeProduct: function(collection){

			var c = $('.shopping-cart-full');

			c.on('click.removeProduct', '.item-close', function(e){

				e.preventDefault();

				$(this).closest('tr').stop().fadeOut(function(){
					$(this).remove();
				});

			});

		},

		/**
		 * Changes view type (product boxes)
		 * @return jQuery collection;
		**/
		viewTypes: function(){

			var collection = $('[data-view]');
			if(!collection.length) return;

			collection.on('click', function(e){

				e.preventDefault();
				var $this = $(this),
					target = $($this.data('target'));

				$this
					.addClass('active')
					.siblings()
					.removeClass('active');

				target
					.removeClass('view-list view-grid')
					.addClass('view-' + $this.data('view'));

			});

			return collection;

		},

		/**
		Counters
		**/
		counters : function(){

			var counter = $('.counter');

			counter.each(function(){

				var $this = $(this),
				offset = $this.offset().top - 3000;

				$(window).on('scroll',function(){
					if($this.hasClass('counted')) return false;

					if($(this).scrollTop() >= offset){

						$this.addClass('counted');
						
						(function ($) {
							$.fn.countTo = function (options) {
								options = options || {};
								
								return $(this).each(function () {
									// set options for current element
									var settings = $.extend({}, $.fn.countTo.defaults, {
										from:            $(this).data('from'),
										to:              $(this).data('to'),
										speed:           $(this).data('speed'),
										refreshInterval: $(this).data('refresh-interval'),
										decimals:        $(this).data('decimals')
									}, options);
									
									// how many times to update the value, and how much to increment the value on each update
									var loops = Math.ceil(settings.speed / settings.refreshInterval),
										increment = (settings.to - settings.from) / loops;
									
									// references & variables that will change with each update
									var self = this,
										$self = $(this),
										loopCount = 0,
										value = settings.from,
										data = $self.data('countTo') || {};
									
									$self.data('countTo', data);
									
									// if an existing interval can be found, clear it first
									if (data.interval) {
										clearInterval(data.interval);
									}
									data.interval = setInterval(updateTimer, settings.refreshInterval);
									
									// initialize the element with the starting value
									render(value);
									
									function updateTimer() {
										value += increment;
										loopCount++;
										
										render(value);
										
										if (typeof(settings.onUpdate) == 'function') {
											settings.onUpdate.call(self, value);
										}
										
										if (loopCount >= loops) {
											// remove the interval
											$self.removeData('countTo');
											clearInterval(data.interval);
											value = settings.to;
											
											if (typeof(settings.onComplete) == 'function') {
												settings.onComplete.call(self, value);
											}
										}
									}
									
									function render(value) {
										var formattedValue = settings.formatter.call(self, value, settings);
										$self.html(formattedValue);
									}
								});
							};
							
							$.fn.countTo.defaults = {
								from: 0,               // the number the element should start at
								to: 0,                 // the number the element should end at
								speed: 1000,           // how long it should take to count between the target numbers
								refreshInterval: 100,  // how often the element should be updated
								decimals: 0,           // the number of decimal places to show
								formatter: formatter,  // handler for formatting the value before rendering
								onUpdate: null,        // callback method for every time the element is updated
								onComplete: null       // callback method for when the element finishes updating
							};
							
							function formatter(value, settings) {
								return value.toFixed(settings.decimals);
							}
						}(jQuery));

						jQuery(function ($) {
						  // custom formatting example
						  $('.count-number').data('countToOptions', {
							formatter: function (value, options) {
							  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, '');
							}
						  });
						  
						  // start all the timers
						  $('.timer').each(count);  
						  
						  function count(options) {
							var $this = $(this);
							options = $.extend({}, options || {}, $this.data('countToOptions') || {});
							$this.countTo(options);
						  }
						});
						
					}

				});

			});

		},

		/**
		Isotope
		**/
		isotope : function(){
			var cthis = this;
			$('[data-isotope-options]').each(function(){

				var self = $(this),
				options = self.data('isotope-options');

				self.isotope(options);

			});
		},

		/**
		Sync Owl Carousel
		**/
		syncOwlCarousel: {

			init: function(){

				this.collection = $('.owl-carousel[data-sync]');
				if(!this.collection.length) return false;

				this.bindEvents();

			},

			bindEvents: function(){

				var self = this;

				this.collection.each(function(i, el){

					var $this = $(el),
						sync = $($this.data('sync'));

					if(!sync.length){
						console.log('Not found carousel with selector ' + $this.data('sync'));
						return;
					}

					// nav
					$this.on('click', '.owl-prev', function(e){
						sync.trigger('prev.owl.carousel');
					});
					$this.on('click', '.owl-next', function(e){
						sync.trigger('next.owl.carousel');
					});

					sync.on('click', '.owl-prev', function(e){
						$this.trigger('prev.owl.carousel');
					});
					sync.on('click', '.owl-next', function(e){
						$this.trigger('next.owl.carousel');
					});

					// // drag 
					$this.on('dragged.owl.carousel', function(e){

				        if(e.relatedTarget.state.direction == 'left'){
				            sync.trigger('next.owl.carousel');
				        }
				        else{
				            sync.trigger('prev.owl.carousel');
				        }
				        
					});

					sync.on('dragged.owl.carousel', function(e){

						if(e.relatedTarget.state.direction == 'left'){
				            $this.trigger('next.owl.carousel');
				        }
				        else{
				            $this.trigger('prev.owl.carousel');
				        }

					});

				});

			}

		},

		/**
		* Page preloader
		* @return Object modules;
		**/
		preloader: function(options){

			var config = {
				waitAfterLoad: 1000,
				duration: 1000
			},
			loader = $('#loader');

			$.extend(config, options);

			$('body').gatsbyImagesLoaded().then(function(){

				setTimeout(function(){

					loader.fadeOut(config.duration, function(){
						$(this).remove();
					});

				}, config.waitAfterLoad);

			});

			return this;

		},

		jQueryExtend: function(){

			$.fn.extend({

				gatsbyImagesLoaded : function () {

				    var $imgs = this.find('img[src!=""]');

				    if (!$imgs.length) {return $.Deferred().resolve().promise();}

				    var dfds = [];

				    $imgs.each(function(){
				        var dfd = $.Deferred();
				        dfds.push(dfd);
				        var img = new Image();
				        img.onload = function(){dfd.resolve();}
				        img.onerror = function(){dfd.resolve();}
				        img.src = this.src;
				    });

				    return $.when.apply($,dfds);

				}

			});

		},

		/**
		 Adds background image
		 * @return undefined;
		**/
		bg: function(collection){

			var collection = collection ? collection : $('[data-bg]');

			collection.each(function(){

				var $this = $(this),
					bg = $this.data('bg');

				if(bg) $this.css('background-image', 'url('+bg+')');

			});

		},

		navInit : {

			init : function (base) {

				this.createResponsiveButtons.call(base);
				this.navProcess(base);

				if ( base.SUPPORT.ISTOUCH ) {
					this.touchNavEvent(base);
				}
			},

			touchNavEvent: function (base) {
				var clicked = false;

				$("li.menu-item-has-children > a, li.cat-parent > a, li.page-item-has-children > a").on(base.event, function (e) {
					if (clicked != this) {
						e.preventDefault();
						clicked = this;
					}
				});
			},

			navProcess: function (base) {

				base.navInit.touchNav(base, base.$window);

				$(window).resize(function (e) {
					setTimeout(function () {
						base.navInit.touchNav(base, e.currentTarget);
					}, 30);
				});

			},

			touchNav: function (base, target) {

				if (base.SUPPORT.ISTOUCH || $(target).width() < 992) {

					if (!base.navMobile.children('ul').length) {
						base.navMobile.append(base.navMain.html());
					}

					base.navButton.on(base.event, function (e) {
						e.preventDefault();

						if (!base.wrapper.is('.active')) {
							$('html, body').animate({ scrollTop: 0 }, 0, function () {
								base.wrapper.css({
									height: base.navMobile.children('ul').outerHeight(true)
								}).addClass('active');
							});
						}
					});

					base.navHide.on(base.event, function (e) {
						e.preventDefault();
						if (base.wrapper.is('.active')) {
							base.wrapper.css({ height: 'auto' }).removeClass('active');
						}
					});

				} else {
					base.navMobile.children('ul').remove();
				}
			},

			createResponsiveButtons : function () {

				this.navButton = $('<button></button>', {
					type: 'button',
					id: 'responsive-nav-button',
					'class': 'responsive-nav-button'
				}).insertBefore(this.navMain);

				this.navHide = $('<a></a>', {
					id: 'advanced-menu-hide',
					'href' : '#'
				}).insertBefore(this.navMobile); 

			},

		}

	}

	$(function(){

		$.mad_core.DOMLoaded();

	});

})(jQuery);

(function($) {
	'use strict';
/**
Custom select
**/
$.fn.madCustomSelect = function () {

	return this.each(function(){

		var list = $(this).children('ul'),
			select = $(this).find('select'),
			title = $(this).find('.select-title');
	 

		// select items to list items

		if($(this).find('[data-filter]').length){
			for(var i = 0,len = select.children('option').length;i < len;i++){
				list.append('<li data-filter="'+select.children('option').eq(i).data('filter')+'">'+select.children('option').eq(i).text()+'</li>')
			}
		}
		else{
			for(var i = 0,len = select.children('option').length;i < len;i++){
				list.append('<li>'+select.children('option').eq(i).text()+'</li>')
			}
		}
		select.hide();

		// open list
		
		title.on('click',function(){
			list.slideToggle(400);
			$(this).toggleClass('active');
		});

		// selected option

		list.on('click','li',function(){
			var val = $(this).text();
			title.text(val);
			list.slideUp(400);
			select.val(val);
			title.toggleClass('active');
			//return false;
		});
		
		// Orderby
		if ($('.woocommerce-ordering').length) {
			$('.woocommerce-ordering').on('click', 'li', function() {
				var $index = $(this).index();
				$(this).parent().next().children('option').eq($index).attr("selected", "selected");
				$(this).closest('form').submit();
			});
		}

	});

}

})(jQuery);


// Sticky and Go-top

(function ($, window) {

	function Temp(el, options) {
		this.el = $(el);
		this.init(options);
	}

	Temp.DEFAULTS = {
		sticky: true
	}

	Temp.prototype = {
		init: function (options) {
			var base = this;
				base.window = $(window);
				base.options = $.extend({}, Temp.DEFAULTS, options);
				base.stickyWrap = $('.sticky-header');
				base.goTop = $('<button class="go-to-top" id="go-to-top"></button>').appendTo(base.el);

			// Sticky
			if (base.options.sticky) {
				base.sticky.stickySet.call(base, base.window);
				base.stickyWrap.before($(".sticky-header").clone().addClass("clone-fixed"));
				
				$( window ).on('load', function() {

				  	$(".sticky-header.clone-fixed").css('top', '-' + $('#header').outerHeight() + 'px');
				     
				});
				
			}
			
			// Scroll Event
			base.window.on('scroll', function (e) {
				if (base.options.sticky) {
					base.sticky.stickyInit.call(base, e.currentTarget);
				}
				base.gotoTop.scrollHandler.call(base, e.currentTarget);
			});

			// Click Handler Button GotoTop
			base.gotoTop.clickHandler(base);
		},

		sticky: {

			stickySet: function () {
				var stickyWrap = this.stickyWrap, offset;
				if (stickyWrap.length) {
					offset = stickyWrap.outerHeight();
					$.data(stickyWrap, 'data', {
						offset: offset,
						height: stickyWrap.outerHeight(true)
					});
					 
				}
			},
			stickyInit: function (win) {
				var base = this, data;
				if (base.stickyWrap.length) {
					data = $.data(base.stickyWrap, 'data');
					base.sticky.stickyAction(data, win, base);
				}
			},
			stickyAction: function (data, win, base) {
				var scrollTop = $(win).scrollTop();
				if (scrollTop > data.offset && $(document).height() > 1500)  {
					if (!base.stickyWrap.hasClass('sticky')) {
						base.stickyWrap.addClass('sticky');
						$('.sticky-header.clone-fixed').addClass('slideDown');
					}
				} else {
					if (base.stickyWrap.hasClass('sticky')) {
						base.stickyWrap.removeClass('sticky');
						$('.sticky-header.clone-fixed').removeClass('slideDown');
					}
				}
			}
		},
		gotoTop: {
			scrollHandler: function (win) {
				$(win).scrollTop() > 200 ?
					this.goTop.addClass('go-top-visible'):
					this.goTop.removeClass('go-top-visible');
					$('.fb-link').addClass('fb-visible');
			},
			clickHandler: function (self) {
				self.goTop.on('click', function (e) {
					e.preventDefault();
					$('html, body').animate({ scrollTop: 0 }, 800);
				});
			}
		}
	}

	/* Temp Plugin
	 * ================================== */

	$.fn.Temp = function (option) {
		return this.each(function () {
			var $this = $(this), data = $this.data('Temp'),
				options = typeof option == 'object' && option;
			if (!data) {
				$this.data('Temp', new Temp(this, options));
			}
		});
	}

})(jQuery, window);