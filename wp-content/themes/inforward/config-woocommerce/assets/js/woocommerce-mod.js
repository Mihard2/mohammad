(function ($) {
	"use strict"; 

	/*	LOAD READY
	/* --------------------------------------------- */

	$(window).load(function () {

	});

	/*	DOM READY
	/* --------------------------------------------- */

	$(function () {
		
	$('body').on('added_to_cart', function (e, fragments, cart_hash) {

		var sum = 0;
		$("#header:not([class*='clone-']) .woocommerce-mini-cart").find(".woocommerce-mini-cart-item").each(function(){
			sum += 1;
		});
		
		$('.sc-cart-btn .icon-ecommerce-basket').attr('data-amount', sum);

	});
	
$(document).on('click', '.mini_cart_item a.remove', function (e)
{
    e.preventDefault();
	
	var sum = 0;
		$("#header:not([class*='clone-']) .woocommerce-mini-cart").find(".woocommerce-mini-cart-item").each(function(){
			sum += 1;
		});
		
		$('.sc-cart-btn .icon-ecommerce-basket').attr('data-amount', sum-1);
	
});
		/* ---------------------------------------------------- */
        /*	Quantity											*/
        /* ---------------------------------------------------- */

		var q = $('.quantity');

		q.each(function(){
			var $this = $(this),
				button = $this.children('button'),
				input = $this.children('input[type="number"]'),
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

	});

})(jQuery);

