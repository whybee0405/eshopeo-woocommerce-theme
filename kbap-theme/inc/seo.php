<?php
/**
 * K-BAP SEO and JSON-LD.
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;

function kbap_seo_description() {
	if ( is_front_page() ) {
		return __( 'K-BAP is a South African Korean catering brand serving Korean fried chicken, gimbap, tteokbokki, bulgogi, japchae, short rib stew and loved K-BAP Kimchi.', 'kbap' );
	}
	if ( is_page_template( 'page-menu.php' ) ) {
		return __( 'Browse the K-BAP Korean catering menu: fried chicken, gimbap, samgak gimbap, tteokbokki, japchae, bulgogi, short rib stew, kimchi and banchan.', 'kbap' );
	}
	if ( is_page_template( 'page-catering.php' ) ) {
		return __( 'Request Korean catering in South Africa from K-BAP for office lunches, cultural events, private tables, festivals and institutional receptions.', 'kbap' );
	}
	if ( kbap_wc_active() && function_exists( 'is_product' ) && is_product() ) {
		$product = wc_get_product( get_the_ID() );
		if ( $product ) {
			return wp_trim_words( wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ), 28, '' );
		}
	}
	return __( 'Authentic Korean catering and future K-BAP Kimchi, meal kit and market products for South African tables.', 'kbap' );
}

function kbap_current_url() {
	if ( is_singular() ) {
		return get_permalink();
	}
	return home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
}

function kbap_og_image() {
	if ( kbap_wc_active() && function_exists( 'is_product' ) && is_product() && has_post_thumbnail() ) {
		$src = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
		if ( $src ) {
			return $src;
		}
	}
	return get_theme_file_uri( 'images/hero-catering.png' );
}

function kbap_meta_tags() {
	$title = wp_get_document_title();
	$desc  = kbap_seo_description();
	$url   = kbap_current_url();
	$image = kbap_og_image();

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( kbap_wc_active() && function_exists( 'is_product' ) && is_product() ? 'product' : 'website' ) );
	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
}
add_action( 'wp_head', 'kbap_meta_tags', 1 );

function kbap_jsonld_print( $data ) {
	if ( empty( $data ) ) {
		return;
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

function kbap_schema_organization() {
	return array(
		'@context'          => 'https://schema.org',
		'@type'             => 'FoodEstablishment',
		'name'              => 'K-BAP',
		'url'               => home_url( '/' ),
		'image'             => get_theme_file_uri( 'images/hero-catering.png' ),
		'logo'              => get_theme_file_uri( 'images/logo.svg' ),
		'servesCuisine'     => array( 'Korean', 'Korean fried chicken', 'Kimchi', 'Gimbap' ),
		'areaServed'        => 'ZA',
		'address'           => array(
			'@type'           => 'PostalAddress',
			'addressLocality' => 'Johannesburg',
			'addressCountry'  => 'ZA',
		),
		'availableLanguage' => array( 'English', 'Korean' ),
	);
}

function kbap_schema_website() {
	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'WebSite',
		'name'            => get_bloginfo( 'name' ),
		'url'             => home_url( '/' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => home_url( '/?s={search_term_string}' ),
			'query-input' => 'required name=search_term_string',
		),
	);
}

function kbap_schema_menu() {
	$sections = array();
	foreach ( kbap_menu_sections() as $section ) {
		$items = array();
		foreach ( $section['items'] as $item ) {
			$items[] = array(
				'@type'       => 'MenuItem',
				'name'        => $item['name'],
				'description' => $item['desc'],
			);
		}
		$sections[] = array(
			'@type'       => 'MenuSection',
			'name'        => $section['title'],
			'description' => $section['intro'],
			'hasMenuItem' => $items,
		);
	}
	return array(
		'@context'       => 'https://schema.org',
		'@type'          => 'Menu',
		'name'           => 'K-BAP Korean Catering Menu',
		'hasMenuSection' => $sections,
	);
}

function kbap_schema_product() {
	if ( ! kbap_wc_active() || ! function_exists( 'is_product' ) || ! is_product() ) {
		return array();
	}
	$product = wc_get_product( get_the_ID() );
	if ( ! $product ) {
		return array();
	}
	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => $product->get_name(),
		'description' => wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ),
		'url'         => get_permalink( $product->get_id() ),
		'image'       => kbap_og_image(),
		'brand'       => array( '@type' => 'Brand', 'name' => 'K-BAP' ),
		'offers'      => array(
			'@type'         => 'Offer',
			'price'         => $product->get_price(),
			'priceCurrency' => function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : 'ZAR',
			'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
			'url'           => get_permalink( $product->get_id() ),
		),
	);
	if ( $product->get_sku() ) {
		$schema['sku'] = $product->get_sku();
	}
	return $schema;
}

function kbap_schema_faq() {
	$entities = array();
	foreach ( kbap_faq_items() as $item ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $item['q'],
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['a'] ),
		);
	}
	return array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $entities );
}

function kbap_jsonld() {
	kbap_jsonld_print( kbap_schema_organization() );
	kbap_jsonld_print( kbap_schema_website() );
	if ( is_page_template( 'page-menu.php' ) ) {
		kbap_jsonld_print( kbap_schema_menu() );
	}
	if ( is_page_template( 'page-faq.php' ) ) {
		kbap_jsonld_print( kbap_schema_faq() );
	}
	$product = kbap_schema_product();
	if ( $product ) {
		kbap_jsonld_print( $product );
	}
}
add_action( 'wp_head', 'kbap_jsonld', 2 );
