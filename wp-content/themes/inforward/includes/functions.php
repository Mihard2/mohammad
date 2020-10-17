<?php

/*	Post ID
/* ---------------------------------------------------------------------- */

if (!function_exists('inforward_post_id')) {

	function inforward_post_id() {
		$object_id = get_queried_object_id();

		$post_id = false;

		if ( get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) && is_home() ) {
			$post_id = get_option( 'page_for_posts' );
		} else {
			// Use the $object_id if available.
			if ( isset( $object_id ) ) {
				$post_id = $object_id;
			}
			// If we're not on a singular post, set to false.
			if ( ! is_singular() ) {
				$post_id = false;
			}
			// Front page is the posts page.
			if ( isset( $object_id ) && 'posts' == get_option( 'show_on_front' ) && is_home() ) {
				$post_id = $object_id;
			}
			// The woocommerce shop page.
			if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
				$post_id = get_option( 'woocommerce_shop_page_id' );
			}
		}

		return $post_id;
	}
}

/*	Blog alias
/* ---------------------------------------------------------------------- */

if ( !function_exists('inforward_blog_alias') ) {

	function inforward_blog_alias ( $format = 'standard', $layout = '' ) {
		global $inforward_config;
		$sidebar_position = $inforward_config['sidebar_position'];

		if ( $layout == 'cp-type-1' ) {

			switch ( $format ) {
				case 'standard':
				case 'gallery':
					$alias = ( $sidebar_position == 'cp-no-sidebar' ) ? array(750, 450) : array(750, 450);
				break;
				default:
					$alias = ( $sidebar_position == 'cp-no-sidebar' ) ? array(750, 450) : array(750, 450);
					break;
			}

			return $alias;

		} elseif ( $layout == 'cp-type-2' ) {

			switch ( $format ) {
				case 'standard':
				case 'gallery':
					$alias = ( $sidebar_position == 'cp-no-sidebar' ) ? array(1140, 600) : array(750, 450);
				break;
				default:
					$alias = ( $sidebar_position == 'cp-no-sidebar' ) ? array(1140, 600) : array(750, 450);
					break;
			}

			return $alias;

		}

	}
}

/*	Debug function print_r
/* ---------------------------------------------------------------------- */

if (!function_exists('t_print_r')) {
	function t_print_r( $arr ) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}

/*  Is shop installed
/* ---------------------------------------------------------------------- */

if (!function_exists('inforward_is_shop_installed')) {
	function inforward_is_shop_installed() {
		global $woocommerce;
		if ( isset( $woocommerce ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/*  Is product
/* ---------------------------------------------------------------------- */

if ( ! function_exists('inforward_is_product') ) {
	function inforward_is_product() {
		return is_singular( array( 'product' ) );
	}
}

/*  Get WC page id
/* ---------------------------------------------------------------------- */

if ( ! function_exists('inforward_wc_get_page_id') ) {
	function inforward_wc_get_page_id( $page ) {

		if ( $page == 'pay' || $page == 'thanks' ) {
			_deprecated_argument( __FUNCTION__, '2.1', 'The "pay" and "thanks" pages are no-longer used - an endpoint is added to the checkout instead. To get a valid link use the WC_Order::get_checkout_payment_url() or WC_Order::get_checkout_order_received_url() methods instead.' );

			$page = 'checkout';
		}
		if ( $page == 'change_password' || $page == 'edit_address' || $page == 'lost_password' ) {
			_deprecated_argument( __FUNCTION__, '2.1', 'The "change_password", "edit_address" and "lost_password" pages are no-longer used - an endpoint is added to the my-account instead. To get a valid link use the wc_customer_edit_account_url() function instead.' );

			$page = 'myaccount';
		}

		$page = apply_filters( 'woocommerce_get_' . $page . '_page_id', get_option('woocommerce_' . $page . '_page_id' ) );

		return $page ? absint( $page ) : -1;
	}
}

/*  Is shop
/* ---------------------------------------------------------------------- */

if ( ! function_exists('inforward_is_shop') ) {
	function inforward_is_shop() {
		return is_post_type_archive( 'product' ) || is_page( inforward_wc_get_page_id( 'shop' ) );
	}
}

/*  Is product tax
/* ---------------------------------------------------------------------- */

if ( ! function_exists('inforward_is_product_tax') ) {
	function inforward_is_product_tax() {
		return is_tax( get_object_taxonomies( 'product' ) );
	}
}

/*  Is product category
/* ---------------------------------------------------------------------- */

if ( ! function_exists('inforward_is_product_category') ) {
	function inforward_is_product_category( $term = '' ) {
		return is_tax( 'product_cat', $term );
	}
}

/*  Is product tag
/* ---------------------------------------------------------------------- */

if ( ! function_exists('inforward_is_product_tag') ) {
	function inforward_is_product_tag( $term = '' ) {
		return is_tax( 'product_tag', $term );
	}
}

/*  Is really woocommerce pages
/* ---------------------------------------------------------------------- */

if ( ! function_exists('inforward_is_realy_woocommerce_page') ) {
	function inforward_is_realy_woocommerce_page( $archive = true ) {

		if ( is_search() ) { return false; }

		if ( $archive ) {
			if ( inforward_is_shop() || inforward_is_product_tax() || inforward_is_product() ) {
				return true;
			}
		}

		$woocommerce_keys = array("inforward_woocommerce_shop_page_id",
			"woocommerce_terms_page_id",
			"woocommerce_cart_page_id",
			"woocommerce_checkout_page_id",
			"woocommerce_pay_page_id",
			"woocommerce_thanks_page_id",
			"woocommerce_myaccount_page_id",
			"woocommerce_edit_address_page_id",
			"woocommerce_view_order_page_id",
			"woocommerce_change_password_page_id",
			"woocommerce_logout_page_id",
			"woocommerce_lost_password_page_id");

		foreach ( $woocommerce_keys as $wc_page_id ) {

			if ( get_the_ID() == get_option($wc_page_id, 0 ) ) {
				return true;
			}
		}
		return false;
	}
}

/* 	Pagination
/* ---------------------------------------------------------------------- */

if( !function_exists( 'inforward_pagination' ) ) {

	function inforward_pagination( $entries = '', $args = array(), $range = 10 ) {

		global $wp_query;

		$paged = (get_query_var('paged')) ? get_query_var('paged') : false;

		if ( $paged === false ) $paged = (get_query_var('page')) ? get_query_var('page') : false;
		if ( $paged === false ) $paged = 1;

		if ($entries == '') {

			if ( isset( $wp_query->max_num_pages ) )
				$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		} else {
			$pages = $entries->max_num_pages;
		}

		if ( 1 != $pages ) { ob_start(); ?>

			<ul class="cp-pagination pagination">

				<?php if( $paged > 1 ):  ?>
					<li><a class='prev-page' href='<?php echo esc_url(get_pagenum_link( $paged - 1 )) ?>'></a></li>
				<?php endif; ?>

				<?php for( $i=1; $i <= $pages; $i++ ): ?>
					<?php if ( 1 != $pages &&( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $range ) ): ?>
						<?php $class = ( $paged == $i ) ? " cp-active" : ''; ?>
						<li><a class="<?php echo sanitize_html_class($class) ?>" href='<?php echo esc_url(get_pagenum_link( $i )) ?>'><?php echo esc_html($i) ?></a></li>
					<?php endif; ?>
				<?php endfor; ?>

				<?php if ( $paged < $pages ):  ?>
					<li><a class='next-page' href='<?php echo esc_url(get_pagenum_link( $paged + 1 )) ?>'></a></li>
				<?php endif; ?>

			</ul>

		<?php return ob_get_clean(); }
	}
}

if ( !function_exists('inforward_content_share') ) {

	function inforward_content_share() {

		global $inforward_settings;
		$image = wp_get_attachment_url( get_post_thumbnail_id() );
		$permalink = apply_filters('the_permalink', get_the_permalink());
		$title = get_the_title();
		$extra_attr = 'target="_blank"';
		?>

		<div class="share-wrap"><span class="share-title"><?php echo esc_html__('Share this:', 'inforward') ?></span>

			<ul class="social-icons share">

				<?php if ( $inforward_settings['post-share-facebook'] ): ?>
					<li><a class="sh-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($permalink) ?>&amp;p&#091;images&#093;&#091;0&#093;=<?php echo esc_url($image) ?>&amp;p&#091;title&#093;=<?php echo esc_attr($title) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-facebook"></i><?php echo esc_html__('Facebook', 'inforward') ?></a></li>
				<?php endif; ?>

				<?php if ( $inforward_settings['post-share-twitter'] ): ?>
					<li><a class="sh-twitter" href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($title) ?>&amp;url=<?php echo esc_url($permalink) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-twitter"></i><?php echo esc_html__('Twitter', 'inforward') ?></a></li>
				<?php endif; ?>

				<?php if ( $inforward_settings['post-share-googleplus'] ): ?>
					<li><a class="sh-google"" href="https://plus.google.com/share?url=<?php echo esc_url($permalink) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-gplus-3"></i><?php echo esc_html__('Google Plus', 'inforward') ?></a></li>
				<?php endif; ?>

				<?php if ( $inforward_settings['post-share-pinterest'] ) : ?>
					<li><a class="sh-pinterest" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url($permalink) ?>&amp;media=<?php echo esc_url($image) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-pinterest"></i><?php echo esc_html__('Pinterest', 'inforward') ?></a></li>
				<?php endif; ?>

				<?php if ( $inforward_settings['post-share-email'] ) : ?>
					<li><a class="sh-mail" href="mailto:?subject=<?php echo esc_attr($title) ?>&amp;body=<?php echo esc_url($permalink) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-mail"></i><?php echo esc_html__('Email to a Friend', 'inforward') ?></a></li>
				<?php endif; ?>

			</ul>

		</div>

	<?php
	}
}

/*  Get Blog ID
/* ---------------------------------------------------------------------- */

if ( ! function_exists('inforward_get_blog_id') ) {
	function inforward_get_blog_id()
	{
		return apply_filters( 'inforward_get_blog_id', get_current_blog_id() );
	}
}

if ( ! function_exists('inforward_lnr_icons_list') ) {
	function inforward_lnr_icons_list($type='type1'){		
		$fontIcons = 'icon-basic-calendar icon-basic-heart icon-basic-message-txt icon-basic-mail-open-text icon-basic-case icon-ecommerce-wallet icon-basic-todo-txt icon-ecommerce-megaphone licon-home licon-home2 licon-home3 licon-home4 licon-home5 licon-home6 licon-bathtub licon-toothbrush licon-bed licon-couch licon-chair licon-city licon-apartment licon-pencil licon-pencil2 licon-pen licon-pencil3 licon-eraser licon-pencil4 licon-pencil5 licon-feather licon-feather2 licon-feather3 licon-pen2 licon-pen-add licon-pen-remove licon-vector licon-pen3 licon-blog licon-brush licon-brush2 licon-spray licon-paint-roller licon-stamp licon-tape licon-desk-tape licon-texture licon-eye-dropper licon-palette licon-color-sampler licon-bucket licon-gradient licon-gradient2 licon-magic-wand licon-magnet licon-pencil-ruler licon-pencil-ruler2 licon-compass licon-aim licon-gun licon-bottle licon-drop licon-drop-crossed licon-drop2 licon-snow licon-snow2 licon-fire licon-lighter licon-knife licon-dagger licon-tissue licon-toilet-paper licon-poop licon-umbrella licon-umbrella2 licon-rain licon-tornado licon-wind licon-fan licon-contrast licon-sun-small licon-sun licon-sun2 licon-moon licon-cloud licon-cloud-upload licon-cloud-download licon-cloud-rain licon-cloud-hailstones licon-cloud-snow licon-cloud-windy licon-sun-wind licon-cloud-fog licon-cloud-sun licon-cloud-lightning licon-cloud-sync licon-cloud-lock licon-cloud-gear licon-cloud-alert licon-cloud-check licon-cloud-cross licon-cloud-crossed licon-cloud-database licon-database licon-database-add licon-database-remove licon-database-lock licon-database-refresh licon-database-check licon-database-history licon-database-upload licon-database-download licon-server licon-shield licon-shield-check licon-shield-alert licon-shield-cross licon-lock licon-rotation-lock licon-unlock licon-key licon-key-hole licon-toggle-off licon-toggle-on licon-cog licon-cog2 licon-wrench licon-screwdriver licon-hammer-wrench licon-hammer licon-saw licon-axe licon-axe2 licon-shovel licon-pickaxe licon-factory licon-factory2 licon-recycle licon-trash licon-trash2 licon-trash3 licon-broom licon-game licon-gamepad licon-joystick licon-dice licon-spades licon-diamonds licon-clubs licon-hearts licon-heart licon-star licon-star-half licon-star-empty licon-flag licon-flag2 licon-flag3 licon-mailbox-full licon-mailbox-empty licon-at-sign licon-envelope licon-envelope-open licon-paperclip licon-paper-plan licon-reply licon-reply-all licon-inbox licon-inbox2 licon-outbox licon-box licon-archive licon-archive2 licon-drawers licon-drawers2 licon-drawers3 licon-eye licon-eye-crossed licon-eye-plus licon-eye-minus licon-binoculars licon-binoculars2 licon-question-circle licon-quote-open licon-copyright licon-hdd licon-hdd-down licon-hdd-up licon-floppy-disk licon-disc licon-tape2 licon-printer licon-shredder licon-file-empty licon-file-add licon-file-check licon-file-lock licon-files licon-copy licon-compare licon-folder licon-folder-search licon-folder-plus licon-folder-minus licon-folder-download licon-folder-upload licon-folder-star licon-folder-heart licon-folder-user licon-folder-shared licon-folder-music licon-folder-picture licon-folder-film licon-scissors licon-paste licon-clipboard-empty licon-clipboard-pencil licon-clipboard-text licon-clipboard-check licon-clipboard-down licon-clipboard-left licon-clipboard-alert licon-clipboard-user licon-register licon-enter licon-exit licon-papers licon-news licon-reading licon-typewriter licon-document licon-document2 licon-graduation-hat licon-license licon-license2 licon-medal-empty licon-medal-first licon-medal-second licon-medal-third licon-podium licon-trophy licon-trophy2 licon-music-note licon-music-note2 licon-music-note3 licon-playlist licon-playlist-add licon-guitar licon-trumpet licon-album licon-shuffle licon-repeat-one licon-repeat licon-headphones licon-headset licon-loudspeaker licon-equalizer licon-theater licon-3d-glasses licon-ticket licon-presentation licon-play licon-film-play licon-clapboard-play licon-media licon-film licon-film2 licon-surveillance licon-surveillance2 licon-camera licon-camera-crossed licon-camera-play licon-time-lapse licon-record licon-camera2 licon-camera-flip licon-panorama licon-time-lapse2 licon-shutter licon-shutter2 licon-face-detection licon-flare licon-convex licon-concave licon-picture licon-picture2 licon-picture3 licon-pictures licon-book licon-audio-book licon-book2 licon-bookmark licon-bookmark2 licon-label licon-library licon-library2 licon-contacts licon-profile licon-portrait licon-portrait2 licon-user licon-user-plus licon-user-minus licon-user-lock licon-users licon-users2 licon-users-plus licon-users-minus licon-group-work licon-woman licon-man licon-baby licon-baby2 licon-baby3 licon-baby-bottle licon-walk licon-hand-waving licon-jump licon-run licon-woman2 licon-man2 licon-man-woman licon-height licon-weight licon-scale licon-button licon-bow-tie licon-tie licon-socks licon-shoe licon-shoes licon-hat licon-pants licon-shorts licon-flip-flops licon-shirt licon-hanger licon-laundry licon-store licon-haircut licon-store-24 licon-barcode licon-barcode2 licon-barcode3 licon-cashier licon-bag licon-bag2 licon-cart licon-cart-empty licon-cart-full licon-cart-plus licon-cart-plus2 licon-cart-add licon-cart-remove licon-cart-exchange licon-tag licon-tags licon-receipt licon-wallet licon-credit-card licon-cash-dollar licon-cash-euro licon-cash-pound licon-cash-yen licon-bag-dollar licon-bag-euro licon-bag-pound licon-bag-yen licon-coin-dollar licon-coin-euro licon-coin-pound licon-coin-yen licon-calculator licon-calculator2 licon-abacus licon-vault licon-telephone licon-phone-lock licon-phone-wave licon-phone-pause licon-phone-outgoing licon-phone-incoming licon-phone-in-out licon-phone-error licon-phone-sip licon-phone-plus licon-phone-minus licon-voicemail licon-dial licon-telephone2 licon-pushpin licon-pushpin2 licon-map-marker licon-map-marker-user licon-map-marker-down licon-map-marker-check licon-map-marker-crossed licon-radar licon-compass2 licon-map licon-map2 licon-location licon-road-sign licon-calendar-empty licon-calendar-check licon-calendar-cross licon-calendar-31 licon-calendar-full licon-calendar-insert licon-calendar-text licon-calendar-user licon-mouse licon-mouse-left licon-mouse-right licon-mouse-both licon-keyboard licon-keyboard-up licon-keyboard-down licon-delete licon-spell-check licon-escape licon-enter2 licon-screen licon-aspect-ratio licon-signal licon-signal-lock licon-signal-80 licon-signal-60 licon-signal-40 licon-signal-20 licon-signal-0 licon-signal-blocked licon-sim licon-flash-memory licon-usb-drive licon-phone licon-smartphone licon-smartphone-notification licon-smartphone-vibration licon-smartphone-embed licon-smartphone-waves licon-tablet licon-tablet2 licon-laptop licon-laptop-phone licon-desktop licon-launch licon-new-tab licon-window licon-cable licon-cable2 licon-tv licon-radio licon-remote-control licon-power-switch licon-power licon-power-crossed licon-flash-auto licon-lamp licon-flashlight licon-lampshade licon-cord licon-outlet licon-battery-power licon-battery-empty licon-battery-alert licon-battery-error licon-battery-low1 licon-battery-low2 licon-battery-low3 licon-battery-mid1 licon-battery-mid2 licon-battery-mid3 licon-battery-full licon-battery-charging licon-battery-charging2 licon-battery-charging3 licon-battery-charging4 licon-battery-charging5 licon-battery-charging6 licon-battery-charging7 licon-chip licon-chip-x64 licon-chip-x86 licon-bubble licon-bubbles licon-bubble-dots licon-bubble-alert licon-bubble-question licon-bubble-text licon-bubble-pencil licon-bubble-picture licon-bubble-video licon-bubble-user licon-bubble-quote licon-bubble-heart licon-bubble-emoticon licon-bubble-attachment licon-phone-bubble licon-quote-open licon-quote-close licon-dna licon-heart-pulse licon-pulse licon-syringe licon-pills licon-first-aid licon-lifebuoy licon-bandage licon-bandages licon-thermometer licon-microscope licon-brain licon-beaker licon-skull licon-bone licon-construction licon-construction-cone licon-pie-chart licon-pie-chart2 licon-graph licon-chart-growth licon-chart-bars licon-chart-settings licon-cake licon-gift licon-balloon licon-rank licon-rank2 licon-rank3 licon-crown licon-lotus licon-diamond licon-diamond2 licon-diamond3 licon-diamond4 licon-linearicons licon-teacup licon-teapot licon-glass licon-bottle2 licon-glass-cocktail licon-glass2 licon-dinner licon-dinner2 licon-chef licon-scale2 licon-egg licon-egg2 licon-eggs licon-platter licon-steak licon-hamburger licon-hotdog licon-pizza licon-sausage licon-chicken licon-fish licon-carrot licon-cheese licon-bread licon-ice-cream licon-ice-cream2 licon-candy licon-lollipop licon-coffee-bean licon-coffee-cup licon-cherry licon-grapes licon-citrus licon-apple licon-leaf licon-landscape licon-pine-tree licon-tree licon-cactus licon-paw licon-footprint licon-speed-slow licon-speed-medium licon-speed-fast licon-rocket licon-hammer2 licon-balance licon-briefcase licon-luggage-weight licon-dolly licon-engine licon-plane licon-plane-crossed licon-helicopter licon-traffic-lights licon-siren licon-road licon-oil-pressure licon-coolant-temperature licon-car-battery licon-gas licon-gallon licon-transmission licon-car licon-car-wash licon-car-wash2 licon-bus licon-bus2 licon-car2 licon-parking licon-car-lock licon-taxi licon-car-siren licon-car-wash3 licon-car-wash4 licon-ambulance licon-truck licon-trailer licon-scale-truck licon-train licon-ship licon-ship2 licon-anchor licon-boat licon-bicycle licon-bicycle2 licon-dumbbell licon-bench-press licon-swim licon-football licon-baseball-bat licon-baseball licon-tennis licon-tennis2 licon-ping-pong licon-hockey licon-8ball licon-bowling licon-bowling-pins licon-golf licon-golf2 licon-archery licon-slingshot licon-soccer licon-basketball licon-cube licon-3d-rotate licon-puzzle licon-glasses licon-glasses2 licon-accessibility licon-wheelchair licon-wall licon-fence licon-wall2 licon-icons licon-resize-handle licon-icons2 licon-select licon-select2 licon-site-map licon-earth licon-earth-lock licon-network licon-network-lock licon-planet licon-happy licon-smile licon-grin licon-checkmark-circle licon-sync-crossed licon-sync2 licon-repeat-one3 licon-sync-crossed2 licon-return licon-return2 licon-refund licon-history licon-history2 licon-self-timer licon-clock licon-clock2 licon-clock3 licon-watch licon-alarm2 licon-alarm-add2 licon-alarm-remove licon-alarm-check licon-alarm-error licon-timer licon-timer-crossed licon-timer2 licon-timer-crossed2 licon-download licon-upload licon-download2 licon-upload2 licon-enter-up licon-enter-down licon-enter-left licon-enter-right licon-exit-up licon-exit-down licon-exit-left licon-exit-right licon-enter-up2 licon-enter-down2 licon-enter-vertical licon-enter-left2 licon-enter-right2 licon-enter-horizontal licon-exit-up2 licon-exit-down2 licon-exit-left2 licon-exit-right2 licon-cli licon-bug licon-code licon-file-code licon-file-image licon-file-zip licon-file-audio licon-file-video licon-file-preview licon-file-charts licon-file-stats licon-file-spreadsheet licon-link licon-unlink licon-link2 licon-unlink2 licon-thumbs-up licon-thumbs-down licon-thumbs-up2 licon-thumbs-down2 licon-thumbs-up3 licon-thumbs-down3 licon-share licon-share2 licon-share3 licon-magnifier licon-file-search';

	$fontIcons       = explode( ' ', $fontIcons );
	$lnrIcons = array();
	$lnrIcons['none'] = esc_html__( '- select icon -', 'inforward' );
	    foreach ( $fontIcons as $icon ) {
			$lnrIcons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 5 ) ) );
		}
	
	$lnrIcons2 = array();
	$lnrIcons2['none'] = esc_html__( '- select icon -', 'inforward' );
	$lnrIcons2 = $fontIcons;

		if($type == 'type1') {
		return $lnrIcons;
		}else{
			return $lnrIcons2;
		}
	
	}
}