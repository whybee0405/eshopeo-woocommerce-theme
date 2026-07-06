<?php
/**
 * K-BAP demo products and importer.
 *
 * Run with: wp eval-file wp-content/themes/kbap-theme/dummy-products.php
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;

function kbap_dummy_products() {
	return array(
		array(
			'name' => 'K-BAP Kimchi 500g',
			'slug' => 'kbap-kimchi-500g',
			'price' => 85,
			'category' => 'kimchi-banchan',
			'family' => 'Kimchi and Banchan',
			'serves' => '4-6 as a side',
			'heat' => 'medium heat',
			'storage' => 'keep refrigerated',
			'prep' => 'ready to eat',
			'dietary' => 'contains fish sauce',
			'image' => 'images/kimchi-product.png',
			'short' => 'Small-batch napa cabbage kimchi with deep fermentation flavour and crisp texture.',
			'desc' => 'The future hero retail product for K-BAP. Serve with rice, fried chicken, stews, gimbap or use it in kimchi fried rice. Loved by catering clients and regular K-BAP customers.',
		),
		array(
			'name' => 'Korean Fried Chicken Party Tray',
			'slug' => 'korean-fried-chicken-party-tray',
			'price' => 620,
			'category' => 'catering-packs',
			'family' => 'Korean Fried Chicken',
			'serves' => '8-10 guests',
			'heat' => 'choice of mild to medium',
			'storage' => 'serve same day',
			'prep' => 'ready to serve',
			'dietary' => 'contains gluten and sesame',
			'image' => 'images/fried-chicken.png',
			'short' => 'Double-fried chicken tray with original, soy garlic or yangnyeom glaze.',
			'desc' => 'K-BAP Korean fried chicken is built for events: crisp coating, clean seasoning, and sauces that hold well on a catering table. Includes pickled radish and garnish.',
		),
		array(
			'name' => 'Classic Gimbap Platter',
			'slug' => 'classic-gimbap-platter',
			'price' => 540,
			'category' => 'catering-packs',
			'family' => 'Gimbap',
			'serves' => '10-12 guests',
			'heat' => 'mild',
			'storage' => 'serve fresh',
			'prep' => 'ready to serve',
			'dietary' => 'vegetarian option available',
			'image' => 'images/event-table.png',
			'short' => 'Sliced gimbap platter with rice, vegetables, egg and savoury fillings.',
			'desc' => 'A flexible catering staple for office lunches, cultural tables and family events. Choose classic, bulgogi, tuna kimchi or vegetarian fillings.',
		),
		array(
			'name' => 'Kimchi Tuna Samgak Gimbap Box',
			'slug' => 'kimchi-tuna-samgak-gimbap-box',
			'price' => 480,
			'category' => 'market-boxes',
			'family' => 'Samgak Gimbap',
			'serves' => '10 pieces',
			'heat' => 'mild to medium',
			'storage' => 'best same day',
			'prep' => 'ready to eat',
			'dietary' => 'contains fish and sesame',
			'image' => 'images/event-table.png',
			'short' => 'Triangle rice pockets with kimchi tuna filling and seaweed wrap.',
			'desc' => 'A recent K-BAP favourite. Portable, recognisably Korean and easy to sell at markets, office lunches and festival counters.',
		),
		array(
			'name' => 'Tteokbokki Catering Tray',
			'slug' => 'tteokbokki-catering-tray',
			'price' => 590,
			'category' => 'catering-packs',
			'family' => 'Tteokbokki',
			'serves' => '8-10 guests',
			'heat' => 'medium heat',
			'storage' => 'serve warm',
			'prep' => 'reheat gently',
			'dietary' => 'contains fish cake',
			'image' => 'images/hero-catering.png',
			'short' => 'Chewy rice cakes in gochujang sauce with fish cake and spring onion.',
			'desc' => 'Korean street food for events, markets and casual functions. Add cheese or extra egg for richer trays.',
		),
		array(
			'name' => 'Japchae Noodle Tray',
			'slug' => 'japchae-noodle-tray',
			'price' => 560,
			'category' => 'catering-packs',
			'family' => 'Japchae',
			'serves' => '8-12 guests',
			'heat' => 'mild',
			'storage' => 'serve same day',
			'prep' => 'room temp or warm',
			'dietary' => 'vegetarian option available',
			'image' => 'images/event-table.png',
			'short' => 'Sweet potato noodles with vegetables, sesame oil and optional beef.',
			'desc' => 'A strong bridge dish for mixed audiences: familiar noodle comfort with real Korean seasoning and texture.',
		),
		array(
			'name' => 'Bulgogi Beef Meal Kit',
			'slug' => 'bulgogi-beef-meal-kit',
			'price' => 245,
			'category' => 'meal-kits',
			'family' => 'Bulgogi',
			'serves' => '2-3 people',
			'heat' => 'mild',
			'storage' => 'keep refrigerated',
			'prep' => 'cook in 12 minutes',
			'dietary' => 'contains soy and sesame',
			'image' => 'images/hero-catering.png',
			'short' => 'Marinated beef kit with sauce, garnish and serving guide.',
			'desc' => 'Future online meal-kit concept based on one of K-BAPs recent catering hits. Designed for quick home cooking with reliable flavour.',
		),
		array(
			'name' => 'Korean Short Rib Stew Kit',
			'slug' => 'korean-short-rib-stew-kit',
			'price' => 340,
			'category' => 'meal-kits',
			'family' => 'Short Rib Stew',
			'serves' => '2 people',
			'heat' => 'mild',
			'storage' => 'keep refrigerated or freeze',
			'prep' => 'heat and finish',
			'dietary' => 'contains soy',
			'image' => 'images/event-table.png',
			'short' => 'Comforting Korean short rib stew with radish, potato and soy broth.',
			'desc' => 'Premium prepared-food concept for customers who want K-BAP depth at home. Ideal for future market shelves and online drops.',
		),
		array(
			'name' => 'Office Lunch Table Package',
			'slug' => 'office-lunch-table-package',
			'price' => 2775,
			'category' => 'catering-packages',
			'family' => 'Catering Package',
			'serves' => '15 guests',
			'heat' => 'mixed heat levels',
			'storage' => 'event day only',
			'prep' => 'delivered ready',
			'dietary' => 'dietary labels available',
			'image' => 'images/hero-catering.png',
			'short' => 'Starter package with gimbap, fried chicken, japchae, kimchi and banchan.',
			'desc' => 'A quoteable WooCommerce package example for corporate lunches and cultural office events. Final pricing adjusts with guest count, delivery and staffing.',
		),
	);
}

function kbap_import_image( $relative_path, $post_id ) {
	$file = get_theme_file_path( $relative_path );
	if ( ! file_exists( $file ) ) {
		return 0;
	}

	$upload = wp_upload_bits( basename( $file ), null, file_get_contents( $file ) );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$type       = wp_check_filetype( $upload['file'], null );
	$attachment = array(
		'post_mime_type' => $type['type'],
		'post_title'     => sanitize_file_name( basename( $file ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);
	$attach_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );
	if ( ! is_wp_error( $attach_id ) ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$metadata = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
		wp_update_attachment_metadata( $attach_id, $metadata );
		return (int) $attach_id;
	}
	return 0;
}

function kbap_run_import() {
	if ( ! class_exists( 'WooCommerce' ) || ! class_exists( 'WC_Product_Simple' ) ) {
		return new WP_Error( 'no_wc', 'WooCommerce is not active.' );
	}

	foreach ( kbap_dummy_products() as $item ) {
		$term = term_exists( $item['category'], 'product_cat' );
		if ( ! $term ) {
			$term = wp_insert_term( ucwords( str_replace( '-', ' ', $item['category'] ) ), 'product_cat', array( 'slug' => $item['category'] ) );
		}

		$post = get_page_by_path( $item['slug'], OBJECT, 'product' );
		$id   = $post ? (int) $post->ID : 0;

		if ( $id ) {
			$product = wc_get_product( $id );
			if ( ! $product ) {
				$product = new WC_Product_Simple( $id );
			}
		} else {
			$product = new WC_Product_Simple();
		}

		$product->set_name( $item['name'] );
		$product->set_slug( $item['slug'] );
		$product->set_regular_price( (string) $item['price'] );
		$product->set_price( (string) $item['price'] );
		$product->set_short_description( $item['short'] );
		$product->set_description( $item['desc'] );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'visible' );
		$product->set_manage_stock( false );
		$product->set_stock_status( 'instock' );
		$id = $product->save();

		wp_set_object_terms( $id, array( $item['category'] ), 'product_cat' );
		foreach ( array( 'serves', 'heat', 'storage', 'prep', 'dietary', 'family' ) as $field ) {
			$key = 'family' === $field ? '_kbap_menu_family' : '_kbap_' . $field;
			update_post_meta( $id, $key, $item[ $field ] );
		}

		if ( ! has_post_thumbnail( $id ) ) {
			$image_id = kbap_import_image( $item['image'], $id );
			if ( $image_id ) {
				set_post_thumbnail( $id, $image_id );
			}
		}
	}

	return true;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	$result = kbap_run_import();
	if ( is_wp_error( $result ) ) {
		WP_CLI::error( $result->get_error_message() );
	}
	WP_CLI::success( 'K-BAP demo products imported.' );
}
