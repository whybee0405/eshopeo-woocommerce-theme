<?php
/**
 * Parts-Mall theme core.
 *
 * @package PartsMall
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * 1. Theme setup
 * ---------------------------------------------------------------------- */

function partsmall_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary', 'parts-mall' ),
			'footer'  => __( 'Footer', 'parts-mall' ),
		)
	);

	add_image_size( 'partsmall-card', 640, 480, true );
	load_theme_textdomain( 'parts-mall', get_theme_file_path( 'languages' ) );
}
add_action( 'after_setup_theme', 'partsmall_setup' );

function partsmall_enqueue_assets() {
	wp_enqueue_style(
		'parts-mall-fonts',
		'https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&family=Barlow+Condensed:wght@600;700&family=JetBrains+Mono:wght@500;600&display=swap',
		array(),
		null
	);

	$style_path = get_theme_file_path( 'style.css' );
	wp_enqueue_style(
		'parts-mall',
		get_stylesheet_uri(),
		array( 'parts-mall-fonts' ),
		file_exists( $style_path ) ? filemtime( $style_path ) : null
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$wc_css_path = get_theme_file_path( 'css/woocommerce.css' );
		wp_enqueue_style(
			'parts-mall-woocommerce',
			get_theme_file_uri( 'css/woocommerce.css' ),
			array( 'parts-mall' ),
			file_exists( $wc_css_path ) ? filemtime( $wc_css_path ) : null
		);
	}

	$main_path   = get_theme_file_path( 'js/main.js' );
	$search_path = get_theme_file_path( 'js/catalogue-search.js' );

	wp_enqueue_script(
		'partsmall-main',
		get_theme_file_uri( 'js/main.js' ),
		array(),
		file_exists( $main_path ) ? filemtime( $main_path ) : null,
		true
	);

	wp_enqueue_script(
		'partsmall-catalogue-search',
		get_theme_file_uri( 'js/catalogue-search.js' ),
		array( 'partsmall-main' ),
		file_exists( $search_path ) ? filemtime( $search_path ) : null,
		true
	);

	wp_localize_script(
		'partsmall-main',
		'partsmallData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'partsmall_nonce' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'partsmall_enqueue_assets' );

function partsmall_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type && wp_style_is( 'parts-mall-fonts', 'enqueued' ) ) {
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'partsmall_resource_hints', 10, 2 );

function partsmall_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}

	echo '<link rel="icon" type="image/svg+xml" href="' . esc_url( get_theme_file_uri( 'images/favicon.svg' ) ) . '">' . "\n";
}
add_action( 'wp_head', 'partsmall_favicon', 0 );

function partsmall_site_profile(): array {
	return array(
		'tagline'           => __( "Korea's #1 Automotive Parts Supplier.", 'parts-mall' ),
		'headline'          => __( 'Trusted Korean vehicle parts, branch support, and trade supply across South Africa.', 'parts-mall' ),
		'hero_copy'         => __( 'Parts-Mall Africa supplies quality replacement parts, trusted private brands, and fast branch support for Hyundai, Kia, Chevrolet, SsangYong, Suzuki, Daewoo, GWM, Haval, Nissan, Ford, Daihatsu, Toyota, and more.', 'parts-mall' ),
		'head_office_name'  => __( 'Parts-Mall Meadowdale', 'parts-mall' ),
		'head_office_email' => 'pma.sales1@parts-mall.com',
		'head_office_phone' => '',
		'head_office_address' => array(
			'50 Herman Street',
			'R24 Business Park Building G Unit 1',
			'Meadowdale',
			'Germiston',
			'1401',
			'South Africa',
		),
		'head_office_map_query' => '50 Herman Street R24 Business Park Building G Unit 1 Meadowdale Germiston 1401 South Africa',
		'socials'           => array(
			array(
				'label' => 'Facebook',
				'url'   => 'https://www.facebook.com/partsMallSA/',
			),
			array(
				'label' => 'Instagram',
				'url'   => 'https://www.instagram.com/partsmallafrica',
			),
			array(
				'label' => 'YouTube',
				'url'   => 'https://www.youtube.com/@PartsMall/',
			),
		),
		'corporate_facts'   => array(
			array(
				'value' => '63',
				'label' => __( 'countries supplied', 'parts-mall' ),
				'note'  => __( 'Official corporate export network', 'parts-mall' ),
			),
			array(
				'value' => '189',
				'label' => __( 'buyers worldwide', 'parts-mall' ),
				'note'  => __( 'Official group relationship count', 'parts-mall' ),
			),
			array(
				'value' => '20+',
				'label' => __( 'official agents globally', 'parts-mall' ),
				'note'  => __( 'Supported by local entities in key markets', 'parts-mall' ),
			),
			array(
				'value' => '1998',
				'label' => __( 'group founded', 'parts-mall' ),
				'note'  => __( 'More than 25 years of parts systems and logistics experience', 'parts-mall' ),
			),
		),
		'proof_points'      => array(
			__( 'Branch coverage across South Africa and selected African markets', 'parts-mall' ),
			__( 'Trusted private brands including PMC, NT, Car-Dex, Pomax, MX, Ex-Trim, Vichura, Pro-Tec, and Dashi', 'parts-mall' ),
			__( 'Parts support for leading Korean and selected imported vehicle makes', 'parts-mall' ),
			__( 'Built for retail customers, workshops, fleets, wholesalers, and trade buyers', 'parts-mall' ),
		),
		'campaign_actions'  => array(
			array(
				'label' => __( 'Find a branch', 'parts-mall' ),
				'url'   => home_url( '/find-a-branch' ),
				'tone'  => 'signal',
			),
			array(
				'label' => __( 'Wholesale and franchise', 'parts-mall' ),
				'url'   => home_url( '/become-an-agent' ),
				'tone'  => 'outline',
			),
			array(
				'label' => __( 'Head office directions', 'parts-mall' ),
				'url'   => 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( '50 Herman Street R24 Business Park Building G Unit 1 Meadowdale Germiston 1401 South Africa' ),
				'tone'  => 'outline',
			),
		),
	);
}

function partsmall_promotions(): array {
	return array(
		array(
			'eyebrow' => __( 'Branches', 'parts-mall' ),
			'title'   => __( 'Find the nearest Parts-Mall branch to you.', 'parts-mall' ),
			'body'    => __( 'Call your local branch, get directions, or send a quick enquiry for the parts you need.', 'parts-mall' ),
			'cta'     => __( 'Find a branch', 'parts-mall' ),
			'url'     => home_url( '/find-a-branch' ),
		),
		array(
			'eyebrow' => __( 'Wholesale', 'parts-mall' ),
			'title'   => __( 'Wholesale and trade supply for serious automotive businesses.', 'parts-mall' ),
			'body'    => __( 'Talk to our team about workshop supply, fleet support, reseller growth, and distribution opportunities.', 'parts-mall' ),
			'cta'     => __( 'Wholesale enquiries', 'parts-mall' ),
			'url'     => home_url( '/become-an-agent' ),
		),
		array(
			'eyebrow' => __( 'Brands', 'parts-mall' ),
			'title'   => __( 'Trusted aftermarket brands backed by supply confidence.', 'parts-mall' ),
			'body'    => __( 'Discover the private-brand range behind the network and speak to us for branch or trade support.', 'parts-mall' ),
			'cta'     => __( 'Contact head office', 'parts-mall' ),
			'url'     => home_url( '/contact' ),
		),
	);
}

function partsmall_global_locations(): array {
	return array(
		array(
			'label' => 'Parts-Mall HQ',
			'place' => 'Goyang, South Korea',
			'type'  => __( 'Head office', 'parts-mall' ),
		),
		array(
			'label' => 'Parts-Mall ATZ',
			'place' => 'Seoul, South Korea',
			'type'  => __( 'Import car parts distribution', 'parts-mall' ),
		),
		array(
			'label' => 'PartZone',
			'place' => 'Goyang, South Korea',
			'type'  => __( 'Platform and parts-matching business', 'parts-mall' ),
		),
		array(
			'label' => 'PMC Logis',
			'place' => 'Paju, South Korea',
			'type'  => __( 'Automotive logistics infrastructure', 'parts-mall' ),
		),
		array(
			'label' => 'Parts-Mall Africa',
			'place' => 'Meadowdale, Germiston, South Africa',
			'type'  => __( 'African sales and distribution hub', 'parts-mall' ),
		),
		array(
			'label' => 'Parts-Mall Shanghai',
			'place' => 'Songjiang District, Shanghai, China',
			'type'  => __( 'Purchasing and brand development entity', 'parts-mall' ),
		),
		array(
			'label' => 'Parts-Mall CIS',
			'place' => 'Moscow, Russia',
			'type'  => __( 'CIS sales and distribution hub', 'parts-mall' ),
		),
	);
}

function partsmall_group_timeline(): array {
	return array(
		array( 'year' => '1998', 'event' => __( 'Parts-Mall founded in South Korea.', 'parts-mall' ) ),
		array( 'year' => '2002', 'event' => __( 'ERP-based B2B automotive parts distribution launched.', 'parts-mall' ) ),
		array( 'year' => '2003', 'event' => __( 'PMC private brand introduced.', 'parts-mall' ) ),
		array( 'year' => '2005', 'event' => __( 'South Africa and Malaysia overseas entities established.', 'parts-mall' ) ),
		array( 'year' => '2006', 'event' => __( 'Shanghai overseas entity established.', 'parts-mall' ) ),
		array( 'year' => '2013', 'event' => __( 'First domestic TecDoc Data Supplier membership secured.', 'parts-mall' ) ),
		array( 'year' => '2016', 'event' => __( 'Group revenue surpassed KRW 100 billion and Russia entity launched.', 'parts-mall' ) ),
		array( 'year' => '2023', 'event' => __( 'Eco-friendly parts business direction formally launched.', 'parts-mall' ) ),
	);
}

function partsmall_network_proof(): array {
	return array(
		array(
			'label'  => __( 'Branch-led footprint', 'parts-mall' ),
			'value'  => __( 'South Africa plus key African markets', 'parts-mall' ),
			'detail' => __( 'Customers can move from search to the right branch quickly through local pages, province hubs, and pan-African country points.', 'parts-mall' ),
			'tone'   => 'signal',
		),
		array(
			'label'  => __( 'Corporate backing', 'parts-mall' ),
			'value'  => __( '63 countries, 189 buyers, 20+ agents', 'parts-mall' ),
			'detail' => __( 'Official group figures reinforce the scale, continuity, and export experience behind the local operation.', 'parts-mall' ),
			'tone'   => 'navy',
		),
		array(
			'label'  => __( 'Product confidence', 'parts-mall' ),
			'value'  => __( 'Private brands with warranty-backed positioning', 'parts-mall' ),
			'detail' => __( 'Brands such as PMC, NT, Car-Dex, Pomax, MX, Ex-Trim, Vichura, Pro-Tec, and Dashi help customers buy with confidence.', 'parts-mall' ),
			'tone'   => 'paper',
		),
	);
}

function partsmall_category_directory(): array {
	return array(
		__( 'Brake pads, shoes, discs, rotors, callipers, and brake system parts', 'parts-mall' ),
		__( 'Filters, pumps, hoses, radiators, condensers, and cooling-system components', 'parts-mall' ),
		__( 'Alternators, starters, sensors, ignition parts, and electrical spares', 'parts-mall' ),
		__( 'Suspension arms, ball joints, bushes, links, steering parts, and undercar components', 'parts-mall' ),
		__( 'Engine internals, gaskets, seals, bearings, timing components, and valve-train parts', 'parts-mall' ),
		__( 'Body panels, trim, mirrors, lamps, handles, and high-demand service items', 'parts-mall' ),
	);
}

function partsmall_latest_insights( int $limit = 3 ): array {
	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
		)
	);

	if ( empty( $posts ) ) {
		return array(
			array(
				'title'   => __( 'How to choose the right Parts-Mall branch for faster service', 'parts-mall' ),
				'excerpt' => __( 'Use your nearest branch page to call quickly, send a local enquiry, and get routed to the right team without delay.', 'parts-mall' ),
				'url'     => home_url( '/find-a-branch' ),
			),
			array(
				'title'   => __( 'Why Korean parts supply depends on range, speed, and branch access', 'parts-mall' ),
				'excerpt' => __( 'Customers trust suppliers who can combine product depth, quick response times, and real branch support when a vehicle cannot wait.', 'parts-mall' ),
				'url'     => home_url( '/about' ),
			),
			array(
				'title'   => __( 'What wholesale and franchise partners should expect from Parts-Mall', 'parts-mall' ),
				'excerpt' => __( 'The right supply partner should offer network depth, brand confidence, commercial support, and a clear path to growth.', 'parts-mall' ),
				'url'     => home_url( '/become-an-agent' ),
			),
		);
	}

	$items = array();
	foreach ( $posts as $post ) {
		$items[] = array(
			'title'   => get_the_title( $post ),
			'excerpt' => wp_trim_words( wp_strip_all_tags( $post->post_excerpt ? $post->post_excerpt : $post->post_content ), 24 ),
			'url'     => get_permalink( $post ),
		);
	}

	return $items;
}

function partsmall_head_office_map_url(): string {
	$profile = partsmall_site_profile();
	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $profile['head_office_map_query'] );
}

function partsmall_cloudia_slider_seed_data( $data ) {
	$hero_image = get_theme_file_path( 'images/generated-concepts/parts-mall-hero-distribution-hub.png' );
	$map_image  = get_theme_file_path( 'images/generated-concepts/parts-mall-global-network-map.png' );

	return array(
		'alias'    => 'homepage-hero',
		'title'    => 'Parts Mall Homepage Hero',
		'settings' => array(
			'module_type'     => 'hero',
			'breakpoint_wide' => 1240,
			'breakpoint_desktop' => 960,
			'breakpoint_notebook' => 778,
			'breakpoint_tablet' => 640,
			'height_wide'     => 700,
			'height_desktop'  => 620,
			'height_notebook' => 560,
			'height_tablet'   => 520,
			'height_mobile'   => 400,
			'content_width_wide' => 1320,
			'content_width_desktop' => 1180,
			'content_width_notebook' => 960,
			'content_width_tablet' => 720,
			'content_width_mobile' => 520,
			'delay'           => 5500,
			'overlay_opacity' => 58,
			'content_align'   => 'left',
			'autoplay'        => 1,
			'show_arrows'     => 1,
			'show_dots'       => 1,
		),
		'slides'   => array(
			array(
				'badge_label' => 'South Africa',
				'eyebrow'    => "Korea's #1 Automotive Parts Supplier.",
				'heading'    => 'Trusted Korean vehicle parts across South Africa.',
				'body'       => 'Find quality replacement parts, trusted brands, and branch support for Hyundai, Kia, Chevrolet, SsangYong, Suzuki, Daewoo, GWM, Haval, Nissan, Ford, Daihatsu, Toyota, and more.',
				'cta_label'  => 'Find a branch',
				'cta_url'    => home_url( '/find-a-branch' ),
				'secondary_cta_label' => 'Contact head office',
				'secondary_cta_url' => home_url( '/contact' ),
				'image_path' => $hero_image,
			),
			array(
				'badge_label' => 'Trade supply',
				'eyebrow'    => 'Wholesale supply',
				'heading'    => 'Wholesale, workshop, and trade supply that keeps businesses moving.',
				'body'       => 'Speak to Parts-Mall for bulk supply, branch support, workshop demand, fleet requirements, and distribution growth across South Africa.',
				'cta_label'  => 'Wholesale enquiries',
				'cta_url'    => home_url( '/become-an-agent' ),
				'secondary_cta_label' => 'Find a branch',
				'secondary_cta_url' => home_url( '/find-a-branch' ),
				'image_path' => $hero_image,
			),
			array(
				'badge_label' => 'Global network',
				'eyebrow'    => 'Branch network',
				'heading'    => 'Local service backed by a global automotive parts group.',
				'body'       => 'Contact your nearest branch, get directions, or speak to head office for parts support, trade enquiries, and supply conversations.',
				'cta_label'  => 'Contact head office',
				'cta_url'    => home_url( '/contact' ),
				'secondary_cta_label' => 'Wholesale enquiries',
				'secondary_cta_url' => home_url( '/become-an-agent' ),
				'image_path' => $map_image,
			),
		),
	);
}
add_filter( 'cloudia_hero_slider_seed_data', 'partsmall_cloudia_slider_seed_data' );

/* -------------------------------------------------------------------------
 * 2. Locked catalogue reference data
 * ---------------------------------------------------------------------- */

function partsmall_category_groups(): array {
	return array(
		'braking'             => array(
			'label'    => __( 'Braking', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/braking.svg' ),
			'children' => array(
				'brake-pads'   => __( 'Brake Pads', 'parts-mall' ),
				'brake-shoes'  => __( 'Brake Shoes', 'parts-mall' ),
				'callipers'    => __( 'Callipers', 'parts-mall' ),
				'discs-rotors' => __( 'Discs & Rotors', 'parts-mall' ),
				'boosters'     => __( 'Boosters', 'parts-mall' ),
			),
		),
		'engine'              => array(
			'label'    => __( 'Engine', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/engine.svg' ),
			'children' => array(
				'pistons'        => __( 'Pistons', 'parts-mall' ),
				'camshafts'      => __( 'Camshafts', 'parts-mall' ),
				'crankshafts'    => __( 'Crankshafts', 'parts-mall' ),
				'cylinder-heads' => __( 'Cylinder Heads', 'parts-mall' ),
				'timing-chains'  => __( 'Timing Chains', 'parts-mall' ),
			),
		),
		'electrical-sensors'  => array(
			'label'    => __( 'Electrical & Sensors', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/electrical-sensors.svg' ),
			'children' => array(
				'alternators'  => __( 'Alternators', 'parts-mall' ),
				'sensors'      => __( 'Sensors', 'parts-mall' ),
				'fuses'        => __( 'Fuses', 'parts-mall' ),
				'distributors' => __( 'Distributors', 'parts-mall' ),
			),
		),
		'suspension-steering' => array(
			'label'    => __( 'Suspension & Steering', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/suspension-steering.svg' ),
			'children' => array(
				'bushings'         => __( 'Bushings', 'parts-mall' ),
				'ball-joints'      => __( 'Ball Joints', 'parts-mall' ),
				'cv-joints'        => __( 'CV Joints', 'parts-mall' ),
				'steering-columns' => __( 'Steering Columns', 'parts-mall' ),
			),
		),
		'filters'             => array(
			'label'    => __( 'Filters', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/filters.svg' ),
			'children' => array(
				'air-filters'   => __( 'Air Filters', 'parts-mall' ),
				'fuel-filters'  => __( 'Fuel Filters', 'parts-mall' ),
				'cabin-filters' => __( 'Cabin/Aircon Filters', 'parts-mall' ),
				'oil-filters'   => __( 'Oil Filters', 'parts-mall' ),
			),
		),
		'transmission-clutch' => array(
			'label'    => __( 'Transmission & Clutch', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/transmission-clutch.svg' ),
			'children' => array(
				'clutch-kits'             => __( 'Clutch Kits', 'parts-mall' ),
				'clutch-discs-covers'     => __( 'Clutch Discs & Covers', 'parts-mall' ),
				'clutch-cables'           => __( 'Clutch Cables', 'parts-mall' ),
				'clutch-release-bearings' => __( 'Bearings (Clutch Release)', 'parts-mall' ),
			),
		),
		'cooling-system'      => array(
			'label'    => __( 'Cooling System', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/cooling-system.svg' ),
			'children' => array(
				'radiators'     => __( 'Radiators', 'parts-mall' ),
				'radiator-caps' => __( 'Radiator Caps', 'parts-mall' ),
				'condensers'    => __( 'Condensers', 'parts-mall' ),
				'fans-motors'   => __( 'Fans & Motors', 'parts-mall' ),
			),
		),
		'fuel-system'         => array(
			'label'    => __( 'Fuel System', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/fuel-system.svg' ),
			'children' => array(
				'fuel-pumps'   => __( 'Fuel Pumps', 'parts-mall' ),
				'fuel-tanks'   => __( 'Fuel Tanks', 'parts-mall' ),
				'fuel-caps'    => __( 'Fuel Caps', 'parts-mall' ),
				'fuel-senders' => __( 'Fuel Senders', 'parts-mall' ),
			),
		),
		'body-trim'           => array(
			'label'    => __( 'Body & Trim', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/body-trim.svg' ),
			'children' => array(
				'bumpers'        => __( 'Bumpers', 'parts-mall' ),
				'body-panels'    => __( 'Body Panels', 'parts-mall' ),
				'body-mouldings' => __( 'Body Mouldings', 'parts-mall' ),
				'door-handles'   => __( 'Door Handles', 'parts-mall' ),
				'emblems'        => __( 'Emblems', 'parts-mall' ),
			),
		),
		'bearings'            => array(
			'label'    => __( 'Bearings', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/bearings.svg' ),
			'children' => array(
				'wheel-bearings'      => __( 'Wheel Bearings', 'parts-mall' ),
				'hub-bearings'        => __( 'Hub Bearings', 'parts-mall' ),
				'alternator-bearings' => __( 'Alternator Bearings', 'parts-mall' ),
				'starter-bearings'    => __( 'Starter Bearings', 'parts-mall' ),
			),
		),
		'gaskets-seals'       => array(
			'label'    => __( 'Gaskets & Seals', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/gaskets-seals.svg' ),
			'children' => array(
				'cylinder-head-gaskets'  => __( 'Cylinder Head Gaskets', 'parts-mall' ),
				'intake-exhaust-gaskets' => __( 'Intake/Exhaust Gaskets', 'parts-mall' ),
				'gasket-kits'            => __( 'Gasket Kits', 'parts-mall' ),
			),
		),
		'belts-chains'        => array(
			'label'    => __( 'Belts & Chains', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/belts-chains.svg' ),
			'children' => array(
				'chain-belts'              => __( 'Chain Belts', 'parts-mall' ),
				'timing-chains-assemblies' => __( 'Timing Chains', 'parts-mall' ),
				'belt-covers'              => __( 'Belt Covers', 'parts-mall' ),
			),
		),
		'accessories'         => array(
			'label'    => __( 'Accessories', 'parts-mall' ),
			'icon'     => get_theme_file_uri( 'images/category-icons/accessories.svg' ),
			'children' => array(
				'general-accessories' => __( 'General Accessories', 'parts-mall' ),
			),
		),
	);
}

function partsmall_makes(): array {
	return array(
		'kia'       => 'Kia',
		'hyundai'   => 'Hyundai',
		'chevrolet' => 'Chevrolet',
		'ssangyong' => 'Ssangyong',
		'suzuki'    => 'Suzuki',
		'daewoo'    => 'Daewoo',
		'gwm-haval' => 'GWM/Haval',
		'ford'      => 'Ford',
		'daihatsu'  => 'Daihatsu',
		'nissan'    => 'Nissan',
		'toyota'    => 'Toyota',
	);
}

function partsmall_private_brands(): array {
	return array(
		'parts-mall-pmc' => array(
			'label' => 'Parts-Mall/PMC',
			'logo'  => get_theme_file_uri( 'images/brands/parts-mall-pmc.svg' ),
		),
		'nt'             => array(
			'label' => 'NT',
			'logo'  => get_theme_file_uri( 'images/brands/nt.svg' ),
		),
		'car-dex'        => array(
			'label' => 'Car-Dex',
			'logo'  => get_theme_file_uri( 'images/brands/car-dex.svg' ),
		),
		'pomax'          => array(
			'label' => 'Pomax',
			'logo'  => get_theme_file_uri( 'images/brands/pomax.svg' ),
		),
		'mx'             => array(
			'label' => 'MX',
			'logo'  => get_theme_file_uri( 'images/brands/mx.svg' ),
		),
		'ex-trim'        => array(
			'label' => 'Ex-Trim',
			'logo'  => get_theme_file_uri( 'images/brands/ex-trim.svg' ),
		),
		'vichura'        => array(
			'label' => 'Vichura',
			'logo'  => get_theme_file_uri( 'images/brands/vichura.svg' ),
		),
		'pro-tec'        => array(
			'label' => 'Pro-Tec',
			'logo'  => get_theme_file_uri( 'images/brands/pro-tec.svg' ),
		),
		'dashi'          => array(
			'label' => 'Dashi',
			'logo'  => get_theme_file_uri( 'images/brands/dashi.svg' ),
		),
		'oem-genuine'    => array(
			'label' => 'OEM/Genuine',
			'logo'  => get_theme_file_uri( 'images/brands/oem-genuine.svg' ),
		),
	);
}

function partsmall_meta( int $id, string $key ) {
	return get_post_meta( $id, $key, true );
}

function partsmall_parse_csv( string $csv ): array {
	if ( '' === trim( $csv ) ) {
		return array();
	}

	$parts = array_map( 'trim', explode( ',', $csv ) );
	return array_values( array_filter( $parts ) );
}

function partsmall_branch_seed_data(): array {
	return array(
		'Gauteng'       => array(
			array( 'slug' => 'alberton', 'name' => 'Alberton', 'address' => '34 Heidelberg Road, New Redruth, Alberton', 'phone' => '011 869 2044', 'email' => 'alberton@partsmall.co.za' ),
			array( 'slug' => 'benoni', 'name' => 'Benoni', 'address' => '101 Tom Jones Street, Benoni CBD, Benoni', 'phone' => '011 421 8740', 'email' => 'benoni@partsmall.co.za' ),
			array( 'slug' => 'boksburg', 'name' => 'Boksburg', 'address' => '18 Trichardts Road, Boksburg North, Boksburg', 'phone' => '011 826 5512', 'email' => 'boksburg@partsmall.co.za' ),
			array( 'slug' => 'edenvale', 'name' => 'Edenvale', 'address' => '52 Van Riebeeck Avenue, Edenvale Central, Edenvale', 'phone' => '011 452 1036', 'email' => 'edenvale@partsmall.co.za' ),
			array( 'slug' => 'joburg-cbd-booysens', 'name' => 'Joburg CBD (Booysens)', 'address' => '211 Booysens Road, Selby South, Johannesburg', 'phone' => '011 493 1182', 'email' => 'booysens@partsmall.co.za' ),
			array( 'slug' => 'joburg-cbd-main-str', 'name' => 'Joburg CBD (Main Str)', 'address' => '147 Main Street, Marshalltown, Johannesburg', 'phone' => '011 838 4496', 'email' => 'mainstreet@partsmall.co.za' ),
			array( 'slug' => 'pretoria-cbd', 'name' => 'Pretoria CBD', 'address' => '278 Paul Kruger Street, Pretoria Central, Pretoria', 'phone' => '012 323 0471', 'email' => 'pretoriacbd@partsmall.co.za' ),
			array( 'slug' => 'pretoria-gezina', 'name' => 'Pretoria Gezina', 'address' => '651 Steve Biko Road, Gezina, Pretoria', 'phone' => '012 335 7050', 'email' => 'gezina@partsmall.co.za' ),
			array( 'slug' => 'randburg', 'name' => 'Randburg', 'address' => '43 Bram Fischer Drive, Ferndale, Randburg', 'phone' => '011 781 4625', 'email' => 'randburg@partsmall.co.za' ),
			array( 'slug' => 'randfontein', 'name' => 'Randfontein', 'address' => '16 Main Reef Road, Randfontein CBD, Randfontein', 'phone' => '011 692 3184', 'email' => 'randfontein@partsmall.co.za' ),
			array( 'slug' => 'roodepoort', 'name' => 'Roodepoort', 'address' => '118 Ontdekkers Road, Horizon View, Roodepoort', 'phone' => '011 760 2857', 'email' => 'roodepoort@partsmall.co.za' ),
			array( 'slug' => 'soweto', 'name' => 'Soweto', 'address' => '8527 Chris Hani Road, Rockville, Soweto', 'phone' => '011 938 6402', 'email' => 'soweto@partsmall.co.za' ),
			array( 'slug' => 'wynberg', 'name' => 'Wynberg', 'address' => '24 5th Street, Wynberg, Sandton', 'phone' => '011 440 9308', 'email' => 'wynberg@partsmall.co.za' ),
		),
		'Limpopo'       => array(
			array( 'slug' => 'bela-bela', 'name' => 'Bela Bela', 'address' => '73 Potgieter Road, Bela-Bela Central, Bela-Bela', 'phone' => '014 736 1940', 'email' => 'belabela@partsmall.co.za' ),
			array( 'slug' => 'brits', 'name' => 'Brits', 'address' => '28 De Winton Street, Elandsrand, Brits', 'phone' => '012 252 1187', 'email' => 'brits@partsmall.co.za' ),
			array( 'slug' => 'burgersfort', 'name' => 'Burgersfort', 'address' => '16 Dirk Winterbach Street, Burgersfort CBD, Burgersfort', 'phone' => '013 231 0246', 'email' => 'burgersfort@partsmall.co.za' ),
			array( 'slug' => 'polokwane', 'name' => 'Polokwane', 'address' => '35 Biccard Street, Polokwane Central, Polokwane', 'phone' => '015 295 6384', 'email' => 'polokwane@partsmall.co.za' ),
			array( 'slug' => 'thohoyandou', 'name' => 'Thohoyandou', 'address' => '12 Mphephu Drive, Thohoyandou Block F, Thohoyandou', 'phone' => '015 962 4551', 'email' => 'thohoyandou@partsmall.co.za' ),
			array( 'slug' => 'tzaneen', 'name' => 'Tzaneen', 'address' => '49 Agatha Street, Aqua Park, Tzaneen', 'phone' => '015 307 7092', 'email' => 'tzaneen@partsmall.co.za' ),
		),
		'Free State'    => array(
			array( 'slug' => 'bethlehem', 'name' => 'Bethlehem', 'address' => '10 Muller Street, Bethlehem Central, Bethlehem', 'phone' => '058 303 5176', 'email' => 'bethlehem@partsmall.co.za' ),
			array( 'slug' => 'bloemfontein', 'name' => 'Bloemfontein', 'address' => '76 Nelson Mandela Drive, Westdene, Bloemfontein', 'phone' => '051 430 1188', 'email' => 'bloemfontein@partsmall.co.za' ),
			array( 'slug' => 'welkom', 'name' => 'Welkom', 'address' => '14 Jan Hofmeyr Road, Bedelia, Welkom', 'phone' => '057 352 4107', 'email' => 'welkom@partsmall.co.za' ),
		),
		'North West'    => array(
			array( 'slug' => 'mahikeng', 'name' => 'Mahikeng', 'address' => '27 Shippard Street, Mmabatho Unit 2, Mahikeng', 'phone' => '018 381 7440', 'email' => 'mahikeng@partsmall.co.za' ),
			array( 'slug' => 'potchefstroom', 'name' => 'Potchefstroom', 'address' => '55 Nelson Mandela Drive, Potchefstroom Central, Potchefstroom', 'phone' => '018 293 6802', 'email' => 'potchefstroom@partsmall.co.za' ),
			array( 'slug' => 'rustenburg', 'name' => 'Rustenburg', 'address' => '112 Beyers Naude Drive, Rustenburg CBD, Rustenburg', 'phone' => '014 592 2145', 'email' => 'rustenburg@partsmall.co.za' ),
		),
		'Mpumalanga'    => array(
			array( 'slug' => 'middelburg', 'name' => 'Middelburg', 'address' => '24 Cowen Ntuli Street, Middelburg Central, Middelburg', 'phone' => '013 243 2180', 'email' => 'middelburg@partsmall.co.za' ),
			array( 'slug' => 'nelspruit', 'name' => 'Nelspruit (Mbombela)', 'address' => '18 Samora Machel Drive, Mbombela Central, Mbombela', 'phone' => '013 752 8041', 'email' => 'mbombela@partsmall.co.za' ),
		),
		'Western Cape'  => array(
			array( 'slug' => 'cape-town', 'name' => 'Cape Town', 'address' => '400 Voortrekker Road, Parow, Cape Town', 'phone' => '021 911 2156/7', 'email' => 'capetown@partsmall.co.za' ),
		),
		'KwaZulu-Natal' => array(
			array( 'slug' => 'durban-north', 'name' => 'Durban North', 'address' => '37 Chris Hani Road, Briardene, Durban North', 'phone' => '031 569 4032', 'email' => 'durbannorth@partsmall.co.za' ),
			array( 'slug' => 'port-shepstone', 'name' => 'Port Shepstone', 'address' => '1 Commercial Road, Marburg, Port Shepstone', 'phone' => '039 682 1067', 'email' => 'portshepstone@partsmall.co.za' ),
			array( 'slug' => 'richards-bay', 'name' => 'Richards Bay', 'address' => '65 Dollar Drive, CBD, Richards Bay', 'phone' => '035 789 4420', 'email' => 'richardsbay@partsmall.co.za' ),
		),
		'Eastern Cape'  => array(
			array( 'slug' => 'port-elizabeth', 'name' => 'Port Elizabeth (Gqeberha)', 'address' => '142 Govan Mbeki Avenue, North End, Gqeberha', 'phone' => '041 487 3018', 'email' => 'gqeberha@partsmall.co.za' ),
		),
		'Northern Cape' => array(
			array( 'slug' => 'kuruman', 'name' => 'Kuruman', 'address' => '7 Main Road, Kuruman CBD, Kuruman', 'phone' => '053 712 4805', 'email' => 'kuruman@partsmall.co.za' ),
		),
		'Pan-Africa'    => array(
			array( 'slug' => 'botswana', 'name' => 'Botswana', 'address' => 'Plot 54125, Gaborone West Industrial, Gaborone', 'phone' => '071 845 2201', 'email' => 'botswana@partsmall.co.za', 'country' => 'Botswana' ),
			array( 'slug' => 'eswatini', 'name' => 'Eswatini', 'address' => 'Mhlambanyatsi Road, Matsapha Industrial, Matsapha', 'phone' => '072 336 4810', 'email' => 'eswatini@partsmall.co.za', 'country' => 'Eswatini' ),
			array( 'slug' => 'mozambique', 'name' => 'Mozambique', 'address' => 'Avenida de Angola 127, Baixa, Maputo', 'phone' => '073 550 2846', 'email' => 'mozambique@partsmall.co.za', 'country' => 'Mozambique' ),
			array( 'slug' => 'namibia', 'name' => 'Namibia', 'address' => '28 Newcastle Street, Northern Industrial, Windhoek', 'phone' => '074 266 1904', 'email' => 'namibia@partsmall.co.za', 'country' => 'Namibia' ),
			array( 'slug' => 'zimbabwe', 'name' => 'Zimbabwe', 'address' => '17 Plymouth Road, Southerton, Harare', 'phone' => '078 441 9042', 'email' => 'zimbabwe@partsmall.co.za', 'country' => 'Zimbabwe' ),
		),
	);
}

function partsmall_branches(): array {
	$branches = get_option( 'partsmall_branch_directory', array() );

	if ( ! is_array( $branches ) || empty( $branches ) ) {
		return partsmall_branch_seed_data();
	}

	return $branches;
}

function partsmall_branch_default_gallery(): array {
	return array();
}

function partsmall_normalize_phone( string $phone ): string {
	return preg_replace( '/[^0-9+]/', '', $phone );
}

function partsmall_whatsapp_number( string $phone ): string {
	$number = preg_replace( '/[^0-9]/', '', $phone );
	if ( 0 === strpos( $number, '0' ) ) {
		$number = '27' . substr( $number, 1 );
	}

	return $number;
}

function partsmall_prepare_branch( array $branch, string $province = '' ): array {
	$coords = partsmall_branch_coordinates();
	$branch['province'] = $province;
	$branch['slug']     = isset( $branch['slug'] ) ? sanitize_title( $branch['slug'] ) : sanitize_title( isset( $branch['name'] ) ? $branch['name'] : '' );
	$branch['country']  = ! empty( $branch['country'] ) ? $branch['country'] : 'South Africa';
	$branch['hours']    = ! empty( $branch['hours'] ) ? $branch['hours'] : __( 'Monday to Friday, 08:00-17:00 SAST', 'parts-mall' );
	$branch['email']    = isset( $branch['email'] ) ? $branch['email'] : '';
	$branch['phone']    = isset( $branch['phone'] ) ? $branch['phone'] : '';
	$branch['address']  = isset( $branch['address'] ) ? $branch['address'] : '';
	$branch['whatsapp'] = ! empty( $branch['whatsapp'] ) ? $branch['whatsapp'] : partsmall_whatsapp_number( $branch['phone'] );
	$branch['map_query'] = ! empty( $branch['map_query'] )
		? $branch['map_query']
		: trim( implode( ', ', array_filter( array( 'Parts-Mall ' . ( isset( $branch['name'] ) ? $branch['name'] : '' ), $branch['address'], $branch['country'] ) ) ) );
	$branch['gallery'] = ! empty( $branch['gallery'] ) && is_array( $branch['gallery'] ) ? $branch['gallery'] : partsmall_branch_default_gallery();
	if ( isset( $coords[ $branch['slug'] ] ) ) {
		$branch['lat'] = $coords[ $branch['slug'] ]['lat'];
		$branch['lng'] = $coords[ $branch['slug'] ]['lng'];
	}

	return $branch;
}

function partsmall_branch_coordinates(): array {
	return array(
		'alberton'            => array( 'lat' => -26.2669894, 'lng' => 28.1220546 ),
		'benoni'              => array( 'lat' => -26.1930356, 'lng' => 28.3082376 ),
		'boksburg'            => array( 'lat' => -26.2124639, 'lng' => 28.2617471 ),
		'edenvale'            => array( 'lat' => -26.1366667, 'lng' => 28.1511111 ),
		'joburg-cbd-booysens' => array( 'lat' => -26.2291667, 'lng' => 28.0247222 ),
		'joburg-cbd-main-str' => array( 'lat' => -26.2054009, 'lng' => 28.0543050 ),
		'pretoria-cbd'        => array( 'lat' => -25.7516420, 'lng' => 28.1884978 ),
		'pretoria-gezina'     => array( 'lat' => -25.7215085, 'lng' => 28.2030066 ),
		'randburg'            => array( 'lat' => -26.0897342, 'lng' => 28.0068242 ),
		'randfontein'         => array( 'lat' => -26.1736110, 'lng' => 27.6941670 ),
		'roodepoort'          => array( 'lat' => -26.1438628, 'lng' => 27.8768199 ),
		'soweto'              => array( 'lat' => -26.2227778, 'lng' => 27.8900000 ),
		'wynberg'             => array( 'lat' => -26.1069723, 'lng' => 28.0816219 ),
		'bela-bela'           => array( 'lat' => -24.8806014, 'lng' => 28.2904774 ),
		'brits'               => array( 'lat' => -25.6297222, 'lng' => 27.7841667 ),
		'burgersfort'         => array( 'lat' => -24.6736110, 'lng' => 30.3283330 ),
		'polokwane'           => array( 'lat' => -23.9058333, 'lng' => 29.4613889 ),
		'thohoyandou'         => array( 'lat' => -22.9676429, 'lng' => 30.4596582 ),
		'tzaneen'             => array( 'lat' => -23.8319444, 'lng' => 30.1611111 ),
		'bethlehem'           => array( 'lat' => -28.2308333, 'lng' => 28.3088889 ),
		'bloemfontein'        => array( 'lat' => -29.1113020, 'lng' => 26.2074010 ),
		'welkom'              => array( 'lat' => -27.9822980, 'lng' => 26.7379690 ),
		'mahikeng'            => array( 'lat' => -25.8636110, 'lng' => 25.6586110 ),
		'potchefstroom'       => array( 'lat' => -26.7077780, 'lng' => 27.0958330 ),
		'rustenburg'          => array( 'lat' => -25.6656550, 'lng' => 27.2414480 ),
		'middelburg'          => array( 'lat' => -25.7678012, 'lng' => 29.4555234 ),
		'nelspruit'           => array( 'lat' => -25.4729094, 'lng' => 30.9772719 ),
		'cape-town'           => array( 'lat' => -33.9114112, 'lng' => 18.5539550 ),
		'durban-north'        => array( 'lat' => -29.7965216, 'lng' => 31.0154196 ),
		'port-shepstone'      => array( 'lat' => -30.7427780, 'lng' => 30.4505560 ),
		'richards-bay'        => array( 'lat' => -28.7707857, 'lng' => 32.0577775 ),
		'port-elizabeth'      => array( 'lat' => -33.9400604, 'lng' => 25.6054930 ),
		'kuruman'             => array( 'lat' => -27.4601585, 'lng' => 23.4347857 ),
		'botswana'            => array( 'lat' => -24.6581357, 'lng' => 25.9088474 ),
		'eswatini'            => array( 'lat' => -26.4944820, 'lng' => 31.3083510 ),
		'mozambique'          => array( 'lat' => -25.9662130, 'lng' => 32.5674500 ),
		'namibia'             => array( 'lat' => -22.5198897, 'lng' => 17.0744236 ),
		'zimbabwe'            => array( 'lat' => -17.8614534, 'lng' => 31.0230739 ),
	);
}

function partsmall_flatten_branches(): array {
	$flat = array();
	foreach ( partsmall_branches() as $province => $items ) {
		if ( ! is_array( $items ) ) {
			continue;
		}
		foreach ( $items as $branch ) {
			if ( ! is_array( $branch ) || empty( $branch['slug'] ) ) {
				continue;
			}
			$prepared                  = partsmall_prepare_branch( $branch, (string) $province );
			$flat[ $prepared['slug'] ] = $prepared;
		}
	}

	return $flat;
}

function partsmall_get_branch_by_slug( string $slug ) {
	$slug     = sanitize_title( $slug );
	$branches = partsmall_flatten_branches();

	return isset( $branches[ $slug ] ) ? $branches[ $slug ] : null;
}

function partsmall_branch_url( array $branch ): string {
	if ( empty( $branch['slug'] ) ) {
		return home_url( '/find-a-branch' );
	}

	return home_url( user_trailingslashit( 'branches/' . sanitize_title( $branch['slug'] ) ) );
}

function partsmall_branch_map_url( array $branch ): string {
	$query = ! empty( $branch['map_query'] ) ? $branch['map_query'] : ( isset( $branch['address'] ) ? $branch['address'] : '' );
	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $query );
}

function partsmall_branch_directions_url( array $branch ): string {
	$query = ! empty( $branch['map_query'] ) ? $branch['map_query'] : ( isset( $branch['address'] ) ? $branch['address'] : '' );
	return 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( $query );
}

function partsmall_branch_whatsapp_url( array $branch ): string {
	$number = ! empty( $branch['whatsapp'] ) ? partsmall_whatsapp_number( $branch['whatsapp'] ) : partsmall_whatsapp_number( isset( $branch['phone'] ) ? $branch['phone'] : '' );
	$text   = sprintf(
		/* translators: %s: branch name. */
		__( 'Hi Parts-Mall %s, I need help sourcing a part.', 'parts-mall' ),
		isset( $branch['name'] ) ? $branch['name'] : ''
	);

	return 'https://wa.me/' . rawurlencode( $number ) . '?text=' . rawurlencode( $text );
}

function partsmall_cloudia_store_locator_locations( $locations ): array {
	$items = array();
	foreach ( partsmall_flatten_branches() as $branch ) {
		$items[] = array(
			'slug'       => $branch['slug'],
			'name'       => $branch['name'],
			'province'   => $branch['province'],
			'country'    => $branch['country'],
			'address'    => $branch['address'],
			'phone'      => partsmall_normalize_phone( $branch['phone'] ),
			'email'      => $branch['email'],
			'url'        => partsmall_branch_url( $branch ),
			'directions' => partsmall_branch_directions_url( $branch ),
			'whatsapp'   => partsmall_branch_whatsapp_url( $branch ),
			'lat'        => isset( $branch['lat'] ) ? (float) $branch['lat'] : 0,
			'lng'        => isset( $branch['lng'] ) ? (float) $branch['lng'] : 0,
		);
	}

	return $items;
}
add_filter( 'cloudia_store_locator_locations', 'partsmall_cloudia_store_locator_locations' );

function partsmall_branch_rewrite_rules(): void {
	add_rewrite_rule( '^branches/([^/]+)/?$', 'index.php?partsmall_branch=$matches[1]', 'top' );
}
add_action( 'init', 'partsmall_branch_rewrite_rules' );

function partsmall_branch_query_vars( array $vars ): array {
	$vars[] = 'partsmall_branch';
	return $vars;
}
add_filter( 'query_vars', 'partsmall_branch_query_vars' );

function partsmall_branch_template( string $template ): string {
	$slug = get_query_var( 'partsmall_branch' );
	if ( '' === $slug ) {
		return $template;
	}

	$branch = partsmall_get_branch_by_slug( (string) $slug );
	if ( ! $branch ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		return get_404_template();
	}

	$GLOBALS['partsmall_current_branch'] = $branch;
	$branch_template = get_theme_file_path( 'single-branch.php' );
	return file_exists( $branch_template ) ? $branch_template : $template;
}
add_filter( 'template_include', 'partsmall_branch_template' );

function partsmall_part_badges( WC_Product $p ): array {
	$badges = array();
	$brand  = sanitize_title( (string) partsmall_meta( $p->get_id(), '_part_private_brand' ) );

	if ( 'oem-genuine' === $brand || 'oem/genuine' === strtolower( (string) partsmall_meta( $p->get_id(), '_part_private_brand' ) ) ) {
		$badges[] = array(
			'label' => __( 'OEM/Genuine', 'parts-mall' ),
			'tone'  => 'navy',
		);
	} elseif ( '' !== $brand ) {
		$badges[] = array(
			'label' => __( 'Private Brand', 'parts-mall' ),
			'tone'  => 'signal',
		);
	}

	if ( $p->is_featured() ) {
		$badges[] = array(
			'label' => __( 'Featured', 'parts-mall' ),
			'tone'  => 'warm',
		);
	}

	return $badges;
}

function partsmall_primary_product_category( int $product_id ) {
	$terms = get_the_terms( $product_id, 'product_cat' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return null;
	}

	usort(
		$terms,
		static function ( $a, $b ) {
			return (int) $a->parent <=> (int) $b->parent;
		}
	);

	return $terms[0];
}

function partsmall_product_image_html( WC_Product $product, string $size = 'partsmall-card', string $class = '' ): string {
	if ( $product->get_image_id() ) {
		return $product->get_image( $size, array( 'class' => $class ) );
	}

	return sprintf(
		'<img src="%1$s" alt="%2$s" class="%3$s" loading="lazy" decoding="async" width="640" height="480">',
		esc_url( get_theme_file_uri( 'images/placeholders/part-default.svg' ) ),
		esc_attr( $product->get_name() ),
		esc_attr( $class )
	);
}

/* -------------------------------------------------------------------------
 * 3. Taxonomies and meta
 * ---------------------------------------------------------------------- */

function partsmall_register_taxonomies() {
	register_taxonomy(
		'part_make',
		'product',
		array(
			'labels'            => array(
				'name'          => __( 'Vehicle Makes', 'parts-mall' ),
				'singular_name' => __( 'Vehicle Make', 'parts-mall' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'make' ),
		)
	);

	register_taxonomy(
		'part_brand',
		'product',
		array(
			'labels'            => array(
				'name'          => __( 'Private Brands', 'parts-mall' ),
				'singular_name' => __( 'Private Brand', 'parts-mall' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'brand' ),
		)
	);
}
add_action( 'init', 'partsmall_register_taxonomies' );

function partsmall_meta_definitions(): array {
	return array(
		'_part_number'            => 'string',
		'_part_oem_reference'     => 'string',
		'_part_category_group'    => 'string',
		'_part_compatible_makes'  => 'string',
		'_part_compatible_models' => 'string',
		'_part_private_brand'     => 'string',
		'_part_warranty'          => 'string',
		'_part_availability'      => 'string',
	);
}

function partsmall_meta_auth_callback() {
	return true;
}

function partsmall_register_meta() {
	foreach ( partsmall_meta_definitions() as $key => $type ) {
		register_post_meta(
			'product',
			$key,
			array(
				'single'        => true,
				'type'          => $type,
				'show_in_rest'  => true,
				'auth_callback' => 'partsmall_meta_auth_callback',
			)
		);
	}
}
add_action( 'init', 'partsmall_register_meta' );

function partsmall_seed_term( string $taxonomy, string $name, string $slug = '', int $parent = 0 ): int {
	if ( '' === $slug ) {
		$slug = sanitize_title( $name );
	}

	$existing = get_term_by( 'slug', $slug, $taxonomy );
	if ( $existing instanceof WP_Term ) {
		return (int) $existing->term_id;
	}

	$result = wp_insert_term(
		$name,
		$taxonomy,
		array(
			'slug'   => $slug,
			'parent' => $parent,
		)
	);

	if ( is_wp_error( $result ) ) {
		$retry = get_term_by( 'slug', $slug, $taxonomy );
		return $retry instanceof WP_Term ? (int) $retry->term_id : 0;
	}

	return (int) $result['term_id'];
}

function partsmall_seed_default_terms() {
	$groups = partsmall_category_groups();
	foreach ( $groups as $parent_slug => $group ) {
		$parent_id = partsmall_seed_term( 'product_cat', $group['label'], $parent_slug );
		foreach ( $group['children'] as $child_slug => $child_label ) {
			partsmall_seed_term( 'product_cat', $child_label, $child_slug, $parent_id );
		}
	}

	foreach ( partsmall_makes() as $slug => $label ) {
		partsmall_seed_term( 'part_make', $label, $slug );
	}

	foreach ( partsmall_private_brands() as $slug => $brand ) {
		partsmall_seed_term( 'part_brand', $brand['label'], $slug );
	}

	if ( ! get_option( 'partsmall_branch_directory', false ) ) {
		update_option( 'partsmall_branch_directory', partsmall_branch_seed_data() );
	}

	update_option( 'partsmall_terms_seeded', 1 );
}

function partsmall_after_switch_theme() {
	partsmall_register_taxonomies();
	partsmall_branch_rewrite_rules();
	partsmall_seed_default_terms();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'partsmall_after_switch_theme' );

function partsmall_seed_terms_on_init() {
	if ( get_option( 'partsmall_terms_seeded' ) ) {
		return;
	}

	partsmall_seed_default_terms();
}
add_action( 'init', 'partsmall_seed_terms_on_init', 30 );

/* -------------------------------------------------------------------------
 * 4. Disabled commerce
 * ---------------------------------------------------------------------- */

add_filter( 'woocommerce_is_purchasable', '__return_false' );
add_filter( 'woocommerce_variation_is_purchasable', '__return_false' );
add_filter( 'woocommerce_get_price_suffix', '__return_empty_string' );
add_filter( 'woocommerce_show_page_title', '__return_false' );
add_filter( 'woocommerce_sale_flash', '__return_empty_string' );
add_filter( 'woocommerce_loop_add_to_cart_link', '__return_empty_string' );
add_filter( 'woocommerce_add_to_cart_validation', '__return_false' );

function partsmall_strip_add_to_cart() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
}
add_action( 'init', 'partsmall_strip_add_to_cart' );

function partsmall_strip_wc_chrome() {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
add_action( 'init', 'partsmall_strip_wc_chrome' );

function partsmall_block_commerce_pages() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$block = false;
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		$block = true;
	}
	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		$block = true;
	}
	if ( function_exists( 'is_wc_endpoint_url' ) && ( is_wc_endpoint_url( 'order-pay' ) || is_wc_endpoint_url( 'order-received' ) ) ) {
		$block = true;
	}

	if ( $block ) {
		$redirect = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
		wp_safe_redirect( $redirect );
		exit;
	}
}
add_action( 'template_redirect', 'partsmall_block_commerce_pages' );

add_filter(
	'loop_shop_per_page',
	static function () {
		return 16;
	},
	20
);

add_filter(
	'loop_shop_columns',
	static function () {
		return 1;
	}
);

function partsmall_breadcrumb_defaults( $defaults ) {
	$defaults['delimiter'] = ' <span class="breadcrumb-sep">›</span> ';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'partsmall_breadcrumb_defaults' );

/* -------------------------------------------------------------------------
 * 5. Catalogue filters and sorting
 * ---------------------------------------------------------------------- */

function partsmall_is_catalogue_request(): bool {
	if ( is_admin() ) {
		return false;
	}

	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return true;
	}

	if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
		return true;
	}

	return function_exists( 'is_post_type_archive' ) && is_post_type_archive( 'product' );
}

function partsmall_request_array( string $key ): array {
	if ( empty( $_GET[ $key ] ) ) {
		return array();
	}

	$raw = wp_unslash( $_GET[ $key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$raw = is_array( $raw ) ? $raw : array( $raw );
	return array_values( array_filter( array_map( 'sanitize_title', $raw ) ) );
}

function partsmall_apply_catalogue_filters( WP_Query $query ): void {
	if ( ! $query->is_main_query() || ! partsmall_is_catalogue_request() ) {
		return;
	}

	$category_slugs = partsmall_request_array( 'category' );
	$make_slugs     = partsmall_request_array( 'make' );
	$brand_slugs    = partsmall_request_array( 'brand' );
	$availability   = partsmall_request_array( 'availability' );

	$tax_query = array();
	if ( ! empty( $category_slugs ) ) {
		$tax_query[] = array(
			'taxonomy'         => 'product_cat',
			'field'            => 'slug',
			'terms'            => $category_slugs,
			'include_children' => true,
		);
	}
	if ( ! empty( $make_slugs ) ) {
		$tax_query[] = array(
			'taxonomy' => 'part_make',
			'field'    => 'slug',
			'terms'    => $make_slugs,
		);
	}
	if ( ! empty( $brand_slugs ) ) {
		$tax_query[] = array(
			'taxonomy' => 'part_brand',
			'field'    => 'slug',
			'terms'    => $brand_slugs,
		);
	}
	if ( ! empty( $tax_query ) ) {
		$tax_query['relation'] = 'AND';
		$existing_tax_query    = $query->get( 'tax_query' );
		if ( ! empty( $existing_tax_query ) && is_array( $existing_tax_query ) ) {
			$tax_query = array_merge( array( 'relation' => 'AND' ), $existing_tax_query, $tax_query );
		}
		$query->set( 'tax_query', $tax_query );
	}

	if ( ! empty( $availability ) ) {
		$meta_query = array( 'relation' => 'OR' );
		foreach ( $availability as $state ) {
			$meta_query[] = array(
				'key'     => '_part_availability',
				'value'   => $state,
				'compare' => '=',
			);
		}

		$existing_meta_query = $query->get( 'meta_query' );
		if ( ! empty( $existing_meta_query ) && is_array( $existing_meta_query ) ) {
			$meta_query = array(
				'relation' => 'AND',
				$existing_meta_query,
				$meta_query,
			);
		}
		$query->set( 'meta_query', $meta_query );
	}

	$orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( 'title' === $orderby ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
	} elseif ( 'title-desc' === $orderby ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'DESC' );
	} elseif ( 'newest' === $orderby ) {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'DESC' );
	}
}
add_action( 'pre_get_posts', 'partsmall_apply_catalogue_filters' );

/* -------------------------------------------------------------------------
 * 6. AJAX handlers
 * ---------------------------------------------------------------------- */

function partsmall_render_search_cards( array $products ): string {
	if ( empty( $products ) ) {
		return '<p class="catalogue-search__status">' . esc_html__( 'No matching parts yet. Try a broader part name, brand, make or category.', 'parts-mall' ) . '</p>';
	}

	ob_start();
	echo '<div class="catalogue-search-results">';
	foreach ( $products as $product ) {
		if ( ! $product instanceof WC_Product ) {
			continue;
		}
		$product_id = $product->get_id();
		$brand      = (string) partsmall_meta( $product_id, '_part_private_brand' );
		$number     = (string) partsmall_meta( $product_id, '_part_number' );
		$category   = partsmall_primary_product_category( $product_id );
		$makes      = partsmall_parse_csv( (string) partsmall_meta( $product_id, '_part_compatible_makes' ) );
		?>
		<a class="search-card" href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
			<?php echo partsmall_product_image_html( $product, 'thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span>
				<strong><?php echo esc_html( $product->get_name() ); ?></strong>
				<span class="search-card__meta"><?php echo esc_html( $category ? $category->name : __( 'Part', 'parts-mall' ) ); ?></span>
				<span class="search-card__meta"><?php echo esc_html( $number ); ?><?php echo $brand ? ' · ' . esc_html( $brand ) : ''; ?></span>
				<?php if ( ! empty( $makes ) ) : ?>
					<span class="search-card__meta"><?php echo esc_html( implode( ', ', array_slice( $makes, 0, 3 ) ) ); ?></span>
				<?php endif; ?>
			</span>
		</a>
		<?php
	}
	echo '</div>';
	return (string) ob_get_clean();
}

function partsmall_collect_taxonomy_search_ids( string $term ): array {
	$ids = array();
	foreach ( array( 'product_cat', 'part_make', 'part_brand' ) as $taxonomy ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'search'     => $term,
				'number'     => 6,
			)
		);
		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			continue;
		}
		$term_ids = wp_list_pluck( $terms, 'term_id' );
		$query    = get_posts(
			array(
				'post_type'      => 'product',
				'fields'         => 'ids',
				'posts_per_page' => 8,
				'tax_query'      => array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'term_id',
						'terms'    => $term_ids,
					),
				),
			)
		);
		$ids = array_merge( $ids, $query );
	}
	return array_values( array_unique( array_map( 'intval', $ids ) ) );
}

function partsmall_catalogue_search_ids( string $term ): array {
	$ids = array();

	$search_query = new WP_Query(
		array(
			'post_type'              => 'product',
			'post_status'            => 'publish',
			's'                      => $term,
			'posts_per_page'         => 8,
			'fields'                 => 'ids',
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);
	$ids = array_merge( $ids, $search_query->posts );

	$meta_query = array(
		'relation' => 'OR',
		array(
			'key'     => '_part_number',
			'value'   => $term,
			'compare' => 'LIKE',
		),
		array(
			'key'     => '_part_oem_reference',
			'value'   => $term,
			'compare' => 'LIKE',
		),
		array(
			'key'     => '_part_compatible_makes',
			'value'   => $term,
			'compare' => 'LIKE',
		),
		array(
			'key'     => '_part_compatible_models',
			'value'   => $term,
			'compare' => 'LIKE',
		),
	);

	$ids = array_merge(
		$ids,
		get_posts(
			array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'fields'         => 'ids',
				'posts_per_page' => 8,
				'meta_query'     => $meta_query,
			)
		)
	);

	$ids = array_merge( $ids, partsmall_collect_taxonomy_search_ids( $term ) );
	$ids = array_values( array_unique( array_map( 'intval', $ids ) ) );

	return $ids;
}

function partsmall_ajax_catalogue_search() {
	check_ajax_referer( 'partsmall_nonce', 'nonce' );

	$term = isset( $_POST['term'] ) ? sanitize_text_field( wp_unslash( $_POST['term'] ) ) : '';
	if ( function_exists( 'mb_strlen' ) ? mb_strlen( $term ) < 2 : strlen( $term ) < 2 ) {
		wp_send_json(
			array(
				'count'      => 0,
				'ids'        => array(),
				'cards_html' => '',
			)
		);
	}

	$ids      = partsmall_catalogue_search_ids( $term );
	$products = array();
	foreach ( array_slice( $ids, 0, 6 ) as $id ) {
		$product = wc_get_product( $id );
		if ( $product instanceof WC_Product ) {
			$products[] = $product;
		}
	}

	wp_send_json(
		array(
			'count'      => count( $ids ),
			'ids'        => $ids,
			'cards_html' => partsmall_render_search_cards( $products ),
		)
	);
}
add_action( 'wp_ajax_partsmall_catalogue_search', 'partsmall_ajax_catalogue_search' );
add_action( 'wp_ajax_nopriv_partsmall_catalogue_search', 'partsmall_ajax_catalogue_search' );

function partsmall_ajax_enquiry() {
	check_ajax_referer( 'partsmall_nonce', 'nonce' );

	$type         = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : 'general';
	$name         = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email        = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone        = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$company      = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
	$area         = isset( $_POST['area'] ) ? sanitize_text_field( wp_unslash( $_POST['area'] ) ) : '';
	$message      = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$product_id   = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	$product_name = isset( $_POST['product_name'] ) ? sanitize_text_field( wp_unslash( $_POST['product_name'] ) ) : '';
	$branch_slug  = isset( $_POST['branch_slug'] ) ? sanitize_title( wp_unslash( $_POST['branch_slug'] ) ) : '';
	$branch_name  = isset( $_POST['branch_name'] ) ? sanitize_text_field( wp_unslash( $_POST['branch_name'] ) ) : '';

	if ( '' === $name || ( '' === $email && '' === $phone ) ) {
		wp_send_json(
			array(
				'ok'      => false,
				'message' => __( 'Please include your name and either an email address or contact number.', 'parts-mall' ),
			)
		);
	}

	$subject = sprintf( 'Parts-Mall enquiry [%s]', strtoupper( $type ) );
	$lines   = array(
		'Name: ' . $name,
		'Email: ' . $email,
		'Phone: ' . $phone,
		'Company: ' . $company,
		'Area: ' . $area,
		'Product ID: ' . ( $product_id ? (string) $product_id : '' ),
		'Product: ' . $product_name,
		'Branch slug: ' . $branch_slug,
		'Branch: ' . $branch_name,
		'Type: ' . $type,
		'Message: ' . $message,
	);

	wp_mail( get_option( 'admin_email' ), $subject, implode( "\n", array_filter( $lines ) ) );

	wp_send_json(
		array(
			'ok'      => true,
			'message' => __( 'Thanks. A Parts-Mall team member will follow up shortly.', 'parts-mall' ),
		)
	);
}
add_action( 'wp_ajax_partsmall_enquiry', 'partsmall_ajax_enquiry' );
add_action( 'wp_ajax_nopriv_partsmall_enquiry', 'partsmall_ajax_enquiry' );

require get_theme_file_path( 'inc/seo.php' );
