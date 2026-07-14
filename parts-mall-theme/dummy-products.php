<?php
/**
 * Parts-Mall demo parts importer.
 *
 * Run with:
 * wp eval-file wp-content/themes/parts-mall-theme/dummy-products.php
 */

if ( ! function_exists( 'wp_insert_post' ) || ! function_exists( 'wc_get_product' ) ) {
	echo "Parts-Mall importer requires WordPress + WooCommerce.\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

if ( ! function_exists( 'partsmall_seed_log' ) ) {
	function partsmall_seed_log( string $message ): void {
		if ( defined( 'WP_CLI' ) && WP_CLI && class_exists( '\WP_CLI' ) ) {
			\WP_CLI::log( $message );
		} else {
			echo $message . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

if ( ! function_exists( 'partsmall_resolve_term_id' ) ) {
	function partsmall_resolve_term_id( string $taxonomy, string $slug, string $label, int $parent = 0 ): int {
		$term = get_term_by( 'slug', $slug, $taxonomy );
		if ( $term instanceof WP_Term ) {
			return (int) $term->term_id;
		}
		$created = wp_insert_term( $label, $taxonomy, array( 'slug' => $slug, 'parent' => $parent ) );
		if ( is_wp_error( $created ) ) {
			$retry = get_term_by( 'slug', $slug, $taxonomy );
			return $retry instanceof WP_Term ? (int) $retry->term_id : 0;
		}
		return (int) $created['term_id'];
	}
}

$groups = function_exists( 'partsmall_category_groups' ) ? partsmall_category_groups() : array();
$makes  = function_exists( 'partsmall_makes' ) ? partsmall_makes() : array();
$brands = function_exists( 'partsmall_private_brands' ) ? partsmall_private_brands() : array();

$demo_parts = array(
	array( 'part_number' => 'PM-BRK-1001', 'name' => 'PMC Front Brake Pad Set', 'group' => 'braking', 'child' => 'brake-pads', 'makes' => 'Kia, Hyundai', 'models' => 'Rio, Cerato, i20, Accent', 'brand' => 'Parts-Mall/PMC', 'warranty' => '12-month Parts-Mall Corporation warranty', 'availability' => 'in_stock', 'price' => 485 ),
	array( 'part_number' => 'PM-BRK-1002', 'name' => 'NT Rear Brake Shoe Kit', 'group' => 'braking', 'child' => 'brake-shoes', 'makes' => 'Chevrolet, Daewoo', 'models' => 'Spark, Aveo', 'brand' => 'NT', 'warranty' => '12-month private-brand warranty', 'availability' => 'order_in', 'price' => 365 ),
	array( 'part_number' => 'PM-BRK-1003', 'name' => 'Car-Dex Brake Calliper', 'group' => 'braking', 'child' => 'callipers', 'makes' => 'Hyundai, Kia', 'models' => 'H-1, Sportage', 'brand' => 'Car-Dex', 'warranty' => 'Branch-confirmed warranty support', 'availability' => 'check_branch', 'price' => 1320 ),
	array( 'part_number' => 'PM-ENG-2001', 'name' => 'Pomax Engine Piston Kit', 'group' => 'engine', 'child' => 'pistons', 'makes' => 'Hyundai, Kia', 'models' => '1.6 Gamma applications', 'brand' => 'Pomax', 'warranty' => '12-month private-brand warranty', 'availability' => 'order_in', 'price' => 2150 ),
	array( 'part_number' => 'PM-ENG-2002', 'name' => 'OEM Cylinder Head Assembly', 'group' => 'engine', 'child' => 'cylinder-heads', 'makes' => 'Kia, Hyundai', 'models' => '2.0 CRDi applications', 'brand' => 'OEM/Genuine', 'warranty' => 'OEM warranty subject to supplying branch', 'availability' => 'check_branch', 'price' => 6890 ),
	array( 'part_number' => 'PM-ENG-2003', 'name' => 'Vichura Timing Chain Set', 'group' => 'engine', 'child' => 'timing-chains', 'makes' => 'Chevrolet, Ssangyong', 'models' => '2.0 diesel applications', 'brand' => 'Vichura', 'warranty' => '12-month Parts-Mall Corporation warranty', 'availability' => 'in_stock', 'price' => 1495 ),
	array( 'part_number' => 'PM-ELS-3001', 'name' => 'PMC Alternator 90A', 'group' => 'electrical-sensors', 'child' => 'alternators', 'makes' => 'Suzuki, Daihatsu', 'models' => 'Swift, Gran Max', 'brand' => 'Parts-Mall/PMC', 'warranty' => '12-month private-brand warranty', 'availability' => 'in_stock', 'price' => 2790 ),
	array( 'part_number' => 'PM-ELS-3002', 'name' => 'MX Crankshaft Sensor', 'group' => 'electrical-sensors', 'child' => 'sensors', 'makes' => 'Kia, Hyundai, Chevrolet', 'models' => 'Picanto, i10, Aveo', 'brand' => 'MX', 'warranty' => 'Warranty confirmed at branch dispatch', 'availability' => 'in_stock', 'price' => 420 ),
	array( 'part_number' => 'PM-ELS-3003', 'name' => 'Dashi Distributor Cap', 'group' => 'electrical-sensors', 'child' => 'distributors', 'makes' => 'Daewoo, Chevrolet', 'models' => 'Cielo, Spark Lite', 'brand' => 'Dashi', 'warranty' => 'Parts-Mall Corporation warranty support', 'availability' => 'check_branch', 'price' => 295 ),
	array( 'part_number' => 'PM-SUS-4001', 'name' => 'Pro-Tec Suspension Bushing Set', 'group' => 'suspension-steering', 'child' => 'bushings', 'makes' => 'Ford, Nissan', 'models' => 'Ranger, NP200', 'brand' => 'Pro-Tec', 'warranty' => '12-month private-brand warranty', 'availability' => 'in_stock', 'price' => 580 ),
	array( 'part_number' => 'PM-SUS-4002', 'name' => 'PMC CV Joint Outer', 'group' => 'suspension-steering', 'child' => 'cv-joints', 'makes' => 'Kia, Hyundai', 'models' => 'Sportage, Tucson', 'brand' => 'Parts-Mall/PMC', 'warranty' => 'Branch-backed warranty support', 'availability' => 'order_in', 'price' => 960 ),
	array( 'part_number' => 'PM-SUS-4003', 'name' => 'NT Steering Column Coupler', 'group' => 'suspension-steering', 'child' => 'steering-columns', 'makes' => 'Hyundai, Kia', 'models' => 'Elantra, Cerato', 'brand' => 'NT', 'warranty' => '12-month warranty', 'availability' => 'check_branch', 'price' => 740 ),
	array( 'part_number' => 'PM-FIL-5001', 'name' => 'Car-Dex Air Filter', 'group' => 'filters', 'child' => 'air-filters', 'makes' => 'Toyota, Nissan', 'models' => 'Corolla, Almera', 'brand' => 'Car-Dex', 'warranty' => 'Quality-backed supply line', 'availability' => 'in_stock', 'price' => 145 ),
	array( 'part_number' => 'PM-FIL-5002', 'name' => 'Pomax Cabin Filter', 'group' => 'filters', 'child' => 'cabin-filters', 'makes' => 'Kia, Hyundai', 'models' => 'Sonet, Venue', 'brand' => 'Pomax', 'warranty' => 'Private-brand warranty support', 'availability' => 'in_stock', 'price' => 185 ),
	array( 'part_number' => 'PM-FIL-5003', 'name' => 'OEM Oil Filter', 'group' => 'filters', 'child' => 'oil-filters', 'makes' => 'Ssangyong, GWM/Haval', 'models' => 'Korando, H6', 'brand' => 'OEM/Genuine', 'warranty' => 'OEM supply subject to branch stock', 'availability' => 'check_branch', 'price' => 210 ),
	array( 'part_number' => 'PM-TRN-6001', 'name' => 'PMC Clutch Kit', 'group' => 'transmission-clutch', 'child' => 'clutch-kits', 'makes' => 'Ford, Nissan', 'models' => 'Ranger 2.2, NP300', 'brand' => 'Parts-Mall/PMC', 'warranty' => '12-month Parts-Mall Corporation warranty', 'availability' => 'order_in', 'price' => 3450 ),
	array( 'part_number' => 'PM-TRN-6002', 'name' => 'Ex-Trim Clutch Cable', 'group' => 'transmission-clutch', 'child' => 'clutch-cables', 'makes' => 'Suzuki, Daewoo', 'models' => 'Swift, Cielo', 'brand' => 'Ex-Trim', 'warranty' => 'Branch-backed warranty support', 'availability' => 'in_stock', 'price' => 255 ),
	array( 'part_number' => 'PM-TRN-6003', 'name' => 'Pro-Tec Release Bearing', 'group' => 'transmission-clutch', 'child' => 'clutch-release-bearings', 'makes' => 'Hyundai, Kia', 'models' => 'H100, K2700', 'brand' => 'Pro-Tec', 'warranty' => '12-month private-brand warranty', 'availability' => 'check_branch', 'price' => 420 ),
	array( 'part_number' => 'PM-COO-7001', 'name' => 'PMC Aluminium Radiator', 'group' => 'cooling-system', 'child' => 'radiators', 'makes' => 'Chevrolet, Hyundai', 'models' => 'Utility, H100', 'brand' => 'Parts-Mall/PMC', 'warranty' => 'Private-brand radiator warranty', 'availability' => 'in_stock', 'price' => 2980 ),
	array( 'part_number' => 'PM-COO-7002', 'name' => 'NT Radiator Cap', 'group' => 'cooling-system', 'child' => 'radiator-caps', 'makes' => 'Kia, Hyundai, Toyota', 'models' => 'Multi-application cap', 'brand' => 'NT', 'warranty' => 'Warranty confirmed by supplying branch', 'availability' => 'in_stock', 'price' => 110 ),
	array( 'part_number' => 'PM-COO-7003', 'name' => 'Vichura Condenser', 'group' => 'cooling-system', 'child' => 'condensers', 'makes' => 'Ford, Nissan', 'models' => 'Fiesta, Navara', 'brand' => 'Vichura', 'warranty' => '12-month private-brand warranty', 'availability' => 'order_in', 'price' => 1980 ),
	array( 'part_number' => 'PM-FUE-8001', 'name' => 'Car-Dex Fuel Pump Module', 'group' => 'fuel-system', 'child' => 'fuel-pumps', 'makes' => 'Hyundai, Kia', 'models' => 'Getz, Picanto', 'brand' => 'Car-Dex', 'warranty' => 'Parts-Mall-backed supply line', 'availability' => 'in_stock', 'price' => 895 ),
	array( 'part_number' => 'PM-FUE-8002', 'name' => 'OEM Fuel Sender Unit', 'group' => 'fuel-system', 'child' => 'fuel-senders', 'makes' => 'Toyota, Nissan', 'models' => 'Hilux, NP200', 'brand' => 'OEM/Genuine', 'warranty' => 'OEM warranty where supplied', 'availability' => 'check_branch', 'price' => 1540 ),
	array( 'part_number' => 'PM-BDY-9001', 'name' => 'Ex-Trim Door Handle Assembly', 'group' => 'body-trim', 'child' => 'door-handles', 'makes' => 'Kia, Hyundai', 'models' => 'Sorento, Santa Fe', 'brand' => 'Ex-Trim', 'warranty' => '12-month private-brand warranty', 'availability' => 'in_stock', 'price' => 360 ),
	array( 'part_number' => 'PM-BDY-9002', 'name' => 'PMC Body Moulding Set', 'group' => 'body-trim', 'child' => 'body-mouldings', 'makes' => 'Chevrolet, Ford', 'models' => 'Trailblazer, Everest', 'brand' => 'Parts-Mall/PMC', 'warranty' => 'Branch-backed warranty support', 'availability' => 'order_in', 'price' => 1290 ),
	array( 'part_number' => 'PM-BDG-10001', 'name' => 'MX Wheel Bearing Kit', 'group' => 'bearings', 'child' => 'wheel-bearings', 'makes' => 'Toyota, Hyundai', 'models' => 'Hiace, H1', 'brand' => 'MX', 'warranty' => '12-month private-brand warranty', 'availability' => 'in_stock', 'price' => 650 ),
	array( 'part_number' => 'PM-BDG-10002', 'name' => 'Pomax Starter Bearing', 'group' => 'bearings', 'child' => 'starter-bearings', 'makes' => 'Suzuki, Daihatsu', 'models' => 'Carry, Sirion', 'brand' => 'Pomax', 'warranty' => 'Warranty supported at branch level', 'availability' => 'check_branch', 'price' => 195 ),
	array( 'part_number' => 'PM-GSK-11001', 'name' => 'Pro-Tec Cylinder Head Gasket', 'group' => 'gaskets-seals', 'child' => 'cylinder-head-gaskets', 'makes' => 'Ssangyong, Chevrolet', 'models' => 'Rexton 2.7, Cruze 1.8', 'brand' => 'Pro-Tec', 'warranty' => '12-month private-brand warranty', 'availability' => 'order_in', 'price' => 520 ),
	array( 'part_number' => 'PM-GSK-11002', 'name' => 'Dashi Intake Gasket Set', 'group' => 'gaskets-seals', 'child' => 'intake-exhaust-gaskets', 'makes' => 'Kia, Hyundai', 'models' => '1.4 and 1.6 petrol applications', 'brand' => 'Dashi', 'warranty' => 'Parts-Mall Corporation warranty support', 'availability' => 'in_stock', 'price' => 280 ),
	array( 'part_number' => 'PM-BLT-12001', 'name' => 'NT Timing Chain Assembly', 'group' => 'belts-chains', 'child' => 'timing-chains-assemblies', 'makes' => 'Nissan, Ford', 'models' => 'Qashqai, EcoSport', 'brand' => 'NT', 'warranty' => '12-month private-brand warranty', 'availability' => 'order_in', 'price' => 1240 ),
	array( 'part_number' => 'PM-BLT-12002', 'name' => 'Car-Dex Belt Cover', 'group' => 'belts-chains', 'child' => 'belt-covers', 'makes' => 'Daewoo, Chevrolet', 'models' => 'Matiz, Spark', 'brand' => 'Car-Dex', 'warranty' => 'Warranty confirmed by branch on dispatch', 'availability' => 'check_branch', 'price' => 315 ),
	array( 'part_number' => 'PM-ACC-13001', 'name' => 'PMC General Accessory Kit', 'group' => 'accessories', 'child' => 'general-accessories', 'makes' => 'Kia, Hyundai, Ford', 'models' => 'Mixed branch accessory applications', 'brand' => 'Parts-Mall/PMC', 'warranty' => 'Accessory supply backed by branch team', 'availability' => 'in_stock', 'price' => 540 ),
);

foreach ( $demo_parts as $index => $part ) {
	$title = $part['name'];
	$post  = get_posts(
		array(
			'post_type'      => 'product',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_part_number',
			'meta_value'     => $part['part_number'],
		)
	);

	$product_id = ! empty( $post ) ? (int) $post[0] : 0;
	$post_args  = array(
		'post_title'   => $title,
		'post_type'    => 'product',
		'post_status'  => 'publish',
		'post_content' => 'Seeded demo part for the Parts-Mall catalogue. The site template falls back to images/placeholders/part-default.svg when no featured image is attached.',
		'post_excerpt' => 'Use this part detail to test category, make, brand and enquiry flows.',
	);

	if ( $product_id ) {
		$post_args['ID'] = $product_id;
		$product_id      = wp_update_post( $post_args, true );
	} else {
		$product_id = wp_insert_post( $post_args, true );
	}

	if ( is_wp_error( $product_id ) || ! $product_id ) {
		partsmall_seed_log( 'Failed: ' . $title );
		continue;
	}

	$group     = $groups[ $part['group'] ];
	$parent_id = partsmall_resolve_term_id( 'product_cat', $part['group'], $group['label'] );
	$child_id  = partsmall_resolve_term_id( 'product_cat', $part['child'], $group['children'][ $part['child'] ], $parent_id );
	wp_set_object_terms( $product_id, array( $parent_id, $child_id ), 'product_cat' );

	$make_terms = array_map( 'trim', explode( ',', $part['makes'] ) );
	$make_ids   = array();
	foreach ( $makes as $make_slug => $make_label ) {
		if ( in_array( $make_label, $make_terms, true ) ) {
			$make_ids[] = partsmall_resolve_term_id( 'part_make', $make_slug, $make_label );
		}
	}
	if ( $make_ids ) {
		wp_set_object_terms( $product_id, $make_ids, 'part_make' );
	}

	$brand_slug = sanitize_title( $part['brand'] );
	$brand_id   = partsmall_resolve_term_id( 'part_brand', $brand_slug, $part['brand'] );
	wp_set_object_terms( $product_id, array( $brand_id ), 'part_brand' );
	wp_set_object_terms( $product_id, 'simple', 'product_type' );

	update_post_meta( $product_id, '_part_number', $part['part_number'] );
	update_post_meta( $product_id, '_part_oem_reference', 'OEM-' . substr( $part['part_number'], -4 ) );
	update_post_meta( $product_id, '_part_category_group', $group['label'] );
	update_post_meta( $product_id, '_part_compatible_makes', $part['makes'] );
	update_post_meta( $product_id, '_part_compatible_models', $part['models'] );
	update_post_meta( $product_id, '_part_private_brand', $part['brand'] );
	update_post_meta( $product_id, '_part_warranty', $part['warranty'] );
	update_post_meta( $product_id, '_part_availability', $part['availability'] );
	update_post_meta( $product_id, '_price', (string) $part['price'] );
	update_post_meta( $product_id, '_regular_price', (string) $part['price'] );
	update_post_meta( $product_id, '_stock_status', 'instock' );
	update_post_meta( $product_id, '_featured', $index < 8 ? 'yes' : 'no' );

	partsmall_seed_log( sprintf( 'Seeded %s (%s)', $title, $part['part_number'] ) );
}

partsmall_seed_log( 'Parts-Mall dummy products complete.' );
