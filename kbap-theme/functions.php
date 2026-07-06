<?php
/**
 * K-BAP theme core.
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;

define( 'KBAP_VERSION', '1.0.0' );

function kbap_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 96, 'width' => 260, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary', 'kbap' ),
			'footer'  => __( 'Footer', 'kbap' ),
		)
	);

	add_image_size( 'kbap-card', 720, 520, true );
	add_image_size( 'kbap-hero', 1440, 960, true );
	load_theme_textdomain( 'kbap', get_theme_file_path( 'languages' ) );
}
add_action( 'after_setup_theme', 'kbap_setup' );

function kbap_wc_active() {
	return class_exists( 'WooCommerce' );
}

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function kbap_enqueue() {
	wp_enqueue_style(
		'kbap-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600..800&family=Manrope:wght@400..900&family=Noto+Sans+KR:wght@500;700;900&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'kbap-style', get_stylesheet_uri(), array( 'kbap-fonts' ), KBAP_VERSION );

	if ( kbap_wc_active() ) {
		wp_enqueue_style( 'kbap-woocommerce', get_theme_file_uri( 'css/woocommerce.css' ), array( 'kbap-style' ), KBAP_VERSION );
	}

	wp_enqueue_script( 'kbap-main', get_theme_file_uri( 'js/main.js' ), array(), KBAP_VERSION, true );
	wp_localize_script(
		'kbap-main',
		'kbapData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'kbap_nonce' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'kbap_enqueue' );

function kbap_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type && wp_style_is( 'kbap-fonts', 'enqueued' ) ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'kbap_resource_hints', 10, 2 );

function kbap_js_flag() {
	echo "<script>document.documentElement.classList.add('js');</script>\n";
}
add_action( 'wp_head', 'kbap_js_flag', 0 );

function kbap_logo() {
	?>
	<span class="site-logo__mark" aria-hidden="true">KB</span>
	<span class="site-logo__word">K-BAP</span>
	<?php
}

function kbap_nav_items() {
	$shop = kbap_wc_active() && function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
	return array(
		array( 'label' => __( 'Menu', 'kbap' ), 'url' => home_url( '/menu/' ) ),
		array( 'label' => __( 'Catering', 'kbap' ), 'url' => home_url( '/catering/' ) ),
		array( 'label' => __( 'Shop', 'kbap' ), 'url' => $shop ),
		array( 'label' => __( 'About', 'kbap' ), 'url' => home_url( '/about/' ) ),
		array( 'label' => __( 'Contact', 'kbap' ), 'url' => home_url( '/contact/' ) ),
	);
}

function kbap_menu_sections() {
	return array(
		'chicken' => array(
			'title' => __( 'Korean Fried Chicken', 'kbap' ),
			'kicker' => 'chimaek',
			'intro' => __( 'Crisp, glossy, and built for sharing at events or Friday night tables.', 'kbap' ),
			'items' => array(
				array( 'name' => __( 'Original Crunch Chicken', 'kbap' ), 'desc' => __( 'Double-fried chicken with sea salt, garlic, and pickled radish.', 'kbap' ), 'price' => 'from R145', 'tags' => array( 'mild', 'party tray' ) ),
				array( 'name' => __( 'Yangnyeom Glazed Chicken', 'kbap' ), 'desc' => __( 'Sticky gochujang glaze, sesame, and spring onion.', 'kbap' ), 'price' => 'from R165', 'tags' => array( 'medium heat' ) ),
				array( 'name' => __( 'Soy Garlic Wings', 'kbap' ), 'desc' => __( 'Balanced soy, garlic, ginger, and crisp skin.', 'kbap' ), 'price' => 'from R155', 'tags' => array( 'crowd favourite' ) ),
			),
		),
		'gimbap' => array(
			'title' => __( 'Gimbap And Samgak', 'kbap' ),
			'kicker' => 'bap',
			'intro' => __( 'Portable rice, seaweed, and fillings for catering tables, markets, and lunch boxes.', 'kbap' ),
			'items' => array(
				array( 'name' => __( 'Classic Gimbap', 'kbap' ), 'desc' => __( 'Rice, egg, pickled radish, carrot, spinach, and savoury protein.', 'kbap' ), 'price' => 'from R88', 'tags' => array( 'lunch', 'platter' ) ),
				array( 'name' => __( 'Kimchi Tuna Samgak Gimbap', 'kbap' ), 'desc' => __( 'Triangle rice pocket with kimchi tuna filling and crisp seaweed.', 'kbap' ), 'price' => 'from R48', 'tags' => array( 'new hit' ) ),
				array( 'name' => __( 'Bulgogi Gimbap', 'kbap' ), 'desc' => __( 'Marinated beef, vegetables, sesame rice, and house sauce.', 'kbap' ), 'price' => 'from R105', 'tags' => array( 'premium' ) ),
			),
		),
		'street' => array(
			'title' => __( 'Tteokbokki And Street Food', 'kbap' ),
			'kicker' => 'pojangmacha',
			'intro' => __( 'Korean market comfort, adapted for South African events without losing the point.', 'kbap' ),
			'items' => array(
				array( 'name' => __( 'Classic Tteokbokki', 'kbap' ), 'desc' => __( 'Chewy rice cakes in gochujang sauce with fish cake and spring onion.', 'kbap' ), 'price' => 'from R92', 'tags' => array( 'medium heat' ) ),
				array( 'name' => __( 'Cheese Tteokbokki Tray', 'kbap' ), 'desc' => __( 'Event tray with melted cheese and sesame finish.', 'kbap' ), 'price' => 'quote', 'tags' => array( 'catering' ) ),
				array( 'name' => __( 'Kimchi Fried Rice Cups', 'kbap' ), 'desc' => __( 'Market-ready portions with fried egg option.', 'kbap' ), 'price' => 'from R78', 'tags' => array( 'market' ) ),
			),
		),
		'mains' => array(
			'title' => __( 'Mains And Stews', 'kbap' ),
			'kicker' => 'hansik',
			'intro' => __( 'The dishes that made recent events ask for seconds.', 'kbap' ),
			'items' => array(
				array( 'name' => __( 'Bulgogi Beef', 'kbap' ), 'desc' => __( 'Thin-sliced beef, pear-soy marinade, onion, spring onion, sesame.', 'kbap' ), 'price' => 'from R165', 'tags' => array( 'signature' ) ),
				array( 'name' => __( 'Japchae', 'kbap' ), 'desc' => __( 'Sweet potato noodles, vegetables, sesame oil, and optional beef.', 'kbap' ), 'price' => 'from R118', 'tags' => array( 'vegetarian option' ) ),
				array( 'name' => __( 'Korean Short Rib Stew', 'kbap' ), 'desc' => __( 'Slow-braised short rib, radish, potato, soy broth, and rice.', 'kbap' ), 'price' => 'quote', 'tags' => array( 'event special' ) ),
			),
		),
		'kimchi' => array(
			'title' => __( 'Kimchi And Banchan', 'kbap' ),
			'kicker' => 'banchan',
			'intro' => __( 'Small-batch ferments and sides for tables, markets, and future online orders.', 'kbap' ),
			'items' => array(
				array( 'name' => __( 'K-BAP Kimchi', 'kbap' ), 'desc' => __( 'House napa cabbage kimchi, loved by regulars and event guests.', 'kbap' ), 'price' => 'from R75', 'tags' => array( 'future online' ) ),
				array( 'name' => __( 'Cucumber Kimchi', 'kbap' ), 'desc' => __( 'Fresh, crisp, spicy cucumber banchan.', 'kbap' ), 'price' => 'from R55', 'tags' => array( 'seasonal' ) ),
				array( 'name' => __( 'Banchan Set', 'kbap' ), 'desc' => __( 'Rotating set of Korean side dishes for catering tables.', 'kbap' ), 'price' => 'quote', 'tags' => array( 'catering' ) ),
			),
		),
	);
}

function kbap_featured_dishes() {
	return array(
		array( 'title' => __( 'Korean fried chicken', 'kbap' ), 'text' => __( 'Crisp, glossy, event-proof chicken in original, soy garlic, and yangnyeom styles.', 'kbap' ), 'image' => 'images/fried-chicken.png', 'tags' => array( 'signature', 'party trays' ) ),
		array( 'title' => __( 'Samgak gimbap', 'kbap' ), 'text' => __( 'A recent hit: triangular rice pockets for markets, lunch boxes, and private events.', 'kbap' ), 'image' => 'images/event-table.png', 'tags' => array( 'new', 'portable' ) ),
		array( 'title' => __( 'K-BAP Kimchi', 'kbap' ), 'text' => __( 'Loved house kimchi, ready for future online sales and market shelves.', 'kbap' ), 'image' => 'images/kimchi-product.png', 'tags' => array( 'fermented', 'future shop' ) ),
	);
}

function kbap_catering_packages() {
	return array(
		array(
			'name'     => __( 'Office Lunch Table', 'kbap' ),
			'serves'   => __( '15-35 guests', 'kbap' ),
			'price'    => __( 'from R185 pp', 'kbap' ),
			'summary'  => __( 'A generous weekday spread for teams, launches, embassy meetings, and cultural office events.', 'kbap' ),
			'includes' => array( __( 'Gimbap platters', 'kbap' ), __( 'Korean fried chicken', 'kbap' ), __( 'Japchae', 'kbap' ), __( 'Kimchi and banchan', 'kbap' ) ),
		),
		array(
			'name'     => __( 'Festival Market Setup', 'kbap' ),
			'serves'   => __( 'public service', 'kbap' ),
			'price'    => __( 'custom quote', 'kbap' ),
			'summary'  => __( 'Fast-moving menu for food festivals, pop-ups, cultural days, and local markets.', 'kbap' ),
			'includes' => array( __( 'Samgak gimbap', 'kbap' ), __( 'Tteokbokki cups', 'kbap' ), __( 'Kimchi fried rice', 'kbap' ), __( 'K-BAP Kimchi jars' ) ),
		),
		array(
			'name'     => __( 'Private Korean Table', 'kbap' ),
			'serves'   => __( '8-24 guests', 'kbap' ),
			'price'    => __( 'from R320 pp', 'kbap' ),
			'summary'  => __( 'A fuller table for birthdays, family celebrations, and small private dinners.', 'kbap' ),
			'includes' => array( __( 'Bulgogi beef', 'kbap' ), __( 'Short rib stew', 'kbap' ), __( 'Japchae', 'kbap' ), __( 'Banchan set', 'kbap' ) ),
		),
		array(
			'name'     => __( 'Institutional Reception', 'kbap' ),
			'serves'   => __( '40-120 guests', 'kbap' ),
			'price'    => __( 'custom quote', 'kbap' ),
			'summary'  => __( 'A polished catering format for formal receptions, cultural partners, and seated programmes.', 'kbap' ),
			'includes' => array( __( 'Curated buffet', 'kbap' ), __( 'Dietary labelling', 'kbap' ), __( 'Service staff option', 'kbap' ), __( 'Kimchi tasting table', 'kbap' ) ),
		),
	);
}

function kbap_faq_items() {
	return array(
		array( 'q' => __( 'Do you cater corporate and cultural events?', 'kbap' ), 'a' => __( 'Yes. K-BAP is built for catering and has served events connected to Korean institutions in South Africa, food festivals, private functions, and business gatherings.', 'kbap' ) ),
		array( 'q' => __( 'Is the menu only available as a PDF?', 'kbap' ), 'a' => __( 'No. The website includes an SEO-friendly HTML menu so guests can browse dishes, categories, and catering options directly.', 'kbap' ) ),
		array( 'q' => __( 'Can non-Korean guests enjoy the food?', 'kbap' ), 'a' => __( 'Yes. The menu is authentic Korean food, but it is designed for mixed South African audiences. Heat levels and familiar entry points are clearly labelled.', 'kbap' ) ),
		array( 'q' => __( 'Will K-BAP sell kimchi and meal kits online?', 'kbap' ), 'a' => __( 'The theme is ready for that. WooCommerce is enabled for future K-BAP Kimchi, meal kits, sauces, and market products.', 'kbap' ) ),
	);
}

function kbap_meta_definitions() {
	return array(
		'_kbap_serves'  => array( 'type' => 'string' ),
		'_kbap_heat'    => array( 'type' => 'string' ),
		'_kbap_storage' => array( 'type' => 'string' ),
		'_kbap_prep'    => array( 'type' => 'string' ),
		'_kbap_dietary' => array( 'type' => 'string' ),
		'_kbap_menu_family' => array( 'type' => 'string' ),
	);
}

function kbap_register_meta() {
	foreach ( kbap_meta_definitions() as $key => $args ) {
		register_post_meta(
			'product',
			$key,
			array(
				'type'              => $args['type'],
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => '__return_true',
			)
		);
	}
}
add_action( 'init', 'kbap_register_meta' );

function kbap_meta( $post_id, $key, $default = '' ) {
	$value = get_post_meta( $post_id, $key, true );
	return '' === $value ? $default : $value;
}

function kbap_cart_count_fragment( $fragments ) {
	ob_start();
	?>
	<span class="cart-count" data-cart-count aria-live="polite"><?php echo function_exists( 'WC' ) ? absint( WC()->cart->get_cart_contents_count() ) : 0; ?></span>
	<?php
	$fragments['[data-cart-count]'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'kbap_cart_count_fragment' );

function kbap_ajax_enquiry() {
	check_ajax_referer( 'kbap_nonce', 'nonce' );
	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$topic   = sanitize_text_field( wp_unslash( $_POST['topic'] ?? 'catering' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( '' === $name || '' === $email || '' === $message || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please complete your name, email, and message.', 'kbap' ) ), 400 );
	}

	$subject = sprintf( __( 'K-BAP %1$s enquiry from %2$s', 'kbap' ), $topic, $name );
	$body    = "Name: {$name}\nEmail: {$email}\nTopic: {$topic}\n\n{$message}";
	wp_mail( get_option( 'admin_email' ), $subject, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

	wp_send_json_success( array( 'message' => __( 'Thanks. K-BAP will reply within one working day.', 'kbap' ) ) );
}
add_action( 'wp_ajax_kbap_enquiry', 'kbap_ajax_enquiry' );
add_action( 'wp_ajax_nopriv_kbap_enquiry', 'kbap_ajax_enquiry' );

function kbap_woocommerce_setup() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	add_filter( 'woocommerce_show_page_title', '__return_false' );
}
add_action( 'after_setup_theme', 'kbap_woocommerce_setup' );

require_once get_theme_file_path( 'inc/seo.php' );
require_once get_theme_file_path( 'inc/admin-import.php' );
