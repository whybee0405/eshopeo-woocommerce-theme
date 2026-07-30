<?php
/**
 * Structured data.
 *
 * AutoPartsStore markup per branch. This is what earns the hours, phone and
 * address treatment in Google's local results, and it keeps the landing page
 * consistent with the Business Profile the ads point at.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

/**
 * Build the schema node for one branch.
 *
 * @param array $branch Branch record.
 * @return array
 */
function kms_branch_schema( array $branch ) {
	$specs = array();

	$day_names = array(
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday',
		6 => 'Saturday',
		7 => 'Sunday',
	);

	foreach ( $branch['hours'] as $day => $slot ) {
		if ( ! is_array( $slot ) ) {
			continue;
		}

		$specs[] = array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => 'https://schema.org/' . $day_names[ $day ],
			'opens'     => $slot[0],
			'closes'    => $slot[1],
		);
	}

	$node = array(
		'@type'       => 'AutoPartsStore',
		'@id'         => kms_branch_url( $branch['slug'] ) . '#branch',
		'name'        => $branch['full_name'],
		'url'         => kms_branch_url( $branch['slug'] ),
		'telephone'   => $branch['phone'],
		'parentOrganization' => array(
			'@type' => 'Organization',
			'name'  => 'Korean Motor Spares',
			'url'   => 'https://www.koreanmotor.co.za/',
		),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $branch['street'],
			'addressLocality' => $branch['city'],
			'addressRegion'   => $branch['province'],
			'postalCode'      => $branch['postcode'],
			'addressCountry'  => 'ZA',
		),
		'areaServed'  => array_map(
			static function ( $area ) {
				return array(
					'@type' => 'Place',
					'name'  => $area,
				);
			},
			$branch['area_serves']
		),
		'currenciesAccepted' => 'ZAR',
		'openingHoursSpecification' => $specs,
	);

	// Coordinates and the canonical map link. Both help Google tie this page
	// to the right Business Profile rather than to one of the similarly named
	// parts shops nearby.
	if ( ! empty( $branch['lat'] ) && ! empty( $branch['lng'] ) ) {
		$node['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $branch['lat'],
			'longitude' => $branch['lng'],
		);
	}

	if ( ! empty( $branch['cid'] ) ) {
		$node['hasMap'] = kms_branch_maps_url( $branch );
	}

	$logo = kms_img( 'kms-logo.png' );
	if ( $logo ) {
		$node['image'] = $logo;
	}

	return $node;
}

/**
 * Print JSON-LD in the head.
 */
function kms_print_schema() {
	$branch = kms_current_branch();

	if ( $branch ) {
		$graph = array( kms_branch_schema( $branch ) );
	} elseif ( is_front_page() ) {
		$graph = array_values( array_map( 'kms_branch_schema', kms_branch() ) );
	} else {
		return;
	}

	$payload = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( $payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
	);
}
add_action( 'wp_head', 'kms_print_schema', 20 );
