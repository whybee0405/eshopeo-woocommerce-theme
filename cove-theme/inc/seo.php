<?php
/**
 * COVE SEO — structured data and meta tags.
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;

// Document title on product pages.
add_filter( 'document_title_parts', function( $parts ) {
	if ( is_singular( 'product' ) ) {
		global $product;
		if ( ! $product ) { $product = wc_get_product( get_the_ID() ); }
		$cond = function_exists( 'cove_product_condition' ) ? cove_product_condition( $product->get_id() ) : 'new';
		$label= function_exists( 'cove_condition_label' )   ? cove_condition_label( $cond )                 : 'New';
		$parts['title'] = $label . ' — ' . $product->get_name();
	}
	return $parts;
} );

// Open Graph + JSON-LD on product pages.
add_action( 'wp_head', function() {
	if ( ! is_singular( 'product' ) ) { return; }

	global $product;
	if ( ! $product ) { $product = wc_get_product( get_the_ID() ); }
	if ( ! $product ) { return; }

	$pid       = $product->get_id();
	$name      = $product->get_name();
	$desc      = wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() );
	$price     = $product->get_price();
	$img_id    = get_post_thumbnail_id( $pid );
	$img_url   = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : '';
	$permalink = get_permalink( $pid );
	$brand     = function_exists( 'cove_meta' ) ? (string) cove_meta( $pid, '_cove_brand' ) : 'COVE';
	$condition = function_exists( 'cove_product_condition' ) ? cove_product_condition( $pid ) : 'new';
	$sku       = $product->get_sku();

	// Map condition to schema.org ItemCondition.
	$condition_map = array(
		'new'     => 'https://schema.org/NewCondition',
		'grade-a' => 'https://schema.org/RefurbishedCondition',
		'grade-b' => 'https://schema.org/UsedCondition',
		'grade-c' => 'https://schema.org/DamagedCondition',
	);
	$schema_condition = $condition_map[ $condition ] ?? 'https://schema.org/NewCondition';

	// Open Graph.
	echo '<meta property="og:type" content="product">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $name ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( wp_trim_words( $desc, 30 ) ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_attr( $permalink ) . '">' . "\n";
	if ( $img_url ) {
		echo '<meta property="og:image" content="' . esc_attr( $img_url ) . '">' . "\n";
	}

	// JSON-LD Product schema.
	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => $name,
		'description' => wp_trim_words( $desc, 50 ),
		'url'         => $permalink,
		'brand'       => array( '@type' => 'Brand', 'name' => $brand ?: 'COVE' ),
		'offers'      => array(
			'@type'         => 'Offer',
			'price'         => $price,
			'priceCurrency' => 'ZAR',
			'availability'  => $product->is_in_stock()
				? 'https://schema.org/InStock'
				: 'https://schema.org/OutOfStock',
			'url'           => $permalink,
			'itemCondition' => $schema_condition,
		),
	);

	if ( $sku ) { $schema['sku'] = $sku; }
	if ( $img_url ) { $schema['image'] = $img_url; }

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
} );
