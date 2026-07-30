<?php
/**
 * Branch data: the single source of truth for the whole theme.
 *
 * Every template reads from here. Nothing hardcodes an address or a phone
 * number anywhere else. Trading hours and phone numbers are overridable from
 * Appearance > Customize > Branch details, so the shop can correct them
 * without touching PHP.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

/**
 * Canonical branch definitions.
 *
 * Hours are stored as 24h "HH:MM" pairs, or null for closed. Day keys follow
 * PHP's date('N'): 1 = Monday through 7 = Sunday.
 *
 * @return array<string, array<string, mixed>>
 */
function kms_branches_raw() {
	return array(
		'lenasia'     => array(
			'slug'       => 'lenasia',
			'name'       => 'Lenasia',
			'full_name'  => 'Korean Motor Spares Lenasia',
			'street'     => '117 Robin Avenue',
			'suburb'     => 'Lenasia',
			'city'       => 'Johannesburg',
			'province'   => 'Gauteng',
			'postcode'   => '1827',
			'phone'      => '+27 63 423 6491',
			'whatsapp'   => '27634236491',
			// Google Business Profile identity. Never link to this branch by
			// name or address: several unrelated businesses in both areas trade
			// as "Korean Motor Spares", and a text query lets Google pick one
			// of them. The CID addresses one specific listing and nothing else.
			// Verified 2026-07-28: cid resolves to "Korean Motor Spares Lenasia"
			// and matches the ludocid published on koreanmotor.co.za.
			'cid'        => '16895247867629069469',
			'place_fid'  => '0x1e95a5293ce30067:0xea77fa6bb634e49d',
			// Optional "ChIJ..." Place ID. Cosmetic only: it makes the
			// directions destination read as the trading name rather than
			// the street address. Routing is already exact without it.
			'place_id'   => '',
			'lat'        => '-26.3170716',
			'lng'        => '27.8300876',
			'is_new'     => true,
			'lede'       => 'Our newest counter, on Robin Avenue in the middle of Lenasia. Same stock backing as the rest of the group, five minutes off the R553.',
			'area_serves' => array( 'Lenasia', 'Lenasia South', 'Eldorado Park', 'Ennerdale', 'Devland', 'Nancefield', 'Protea Glen' ),
			'hours'      => array(
				1 => array( '08:00', '17:00' ),
				2 => array( '08:00', '17:00' ),
				3 => array( '08:00', '17:00' ),
				4 => array( '08:00', '17:00' ),
				5 => array( '08:00', '17:00' ),
				6 => array( '08:00', '13:00' ),
				7 => null,
			),
		),
		'vereeniging' => array(
			'slug'       => 'vereeniging',
			'name'       => 'Vereeniging',
			'full_name'  => 'Korean Motor Spares Vereeniging',
			'street'     => '28 De Villiers Avenue',
			'suburb'     => 'Vereeniging Central',
			'city'       => 'Vereeniging',
			'province'   => 'Gauteng',
			'postcode'   => '1939',
			'phone'      => '+27 61 939 8617',
			'whatsapp'   => '27619398617',
			// Verified 2026-07-28: this is the listing at 28 De Villiers Ave,
			// and its coordinates match the ones koreanmotor.co.za links to.
			// A second listing also called "KOREAN MOTOR SPARES" sits nearby at
			// 3 Voortrekker St with its own website; it is a different business
			// and is exactly what a name-based search was resolving to.
			'cid'        => '4891259578967332818',
			'place_fid'  => '0x1e94f716eb1daaa7:0x43e13eac0c9317d2',
			'place_id'   => '',
			'lat'        => '-26.6661716',
			'lng'        => '27.930438',
			'is_new'     => false,
			'lede'       => 'On De Villiers Avenue in Vereeniging Central, a block off the main drag. The Vaal\'s counter for Hyundai, Kia, Daewoo and SsangYong parts.',
			'area_serves' => array( 'Vereeniging', 'Vanderbijlpark', 'Sasolburg', 'Meyerton', 'Three Rivers', 'Sharpeville', 'Duncanville' ),
			'hours'      => array(
				1 => array( '08:00', '17:00' ),
				2 => array( '08:00', '17:00' ),
				3 => array( '08:00', '17:00' ),
				4 => array( '08:00', '17:00' ),
				5 => array( '08:00', '17:00' ),
				6 => array( '08:00', '13:00' ),
				7 => null,
			),
		),
	);
}

/**
 * Branch data with Customizer overrides applied.
 *
 * @param string|null $slug Optional branch slug. Omit for all branches.
 * @return array<string, mixed>|array<string, array<string, mixed>>|null
 */
function kms_branch( $slug = null ) {
	static $cache = null;

	if ( null === $cache ) {
		$cache = kms_branches_raw();

		foreach ( $cache as $key => $branch ) {
			$phone = trim( (string) get_theme_mod( "kms_{$key}_phone", '' ) );
			if ( '' !== $phone ) {
				$cache[ $key ]['phone'] = $phone;
			}

			$wa = preg_replace( '/\D/', '', (string) get_theme_mod( "kms_{$key}_whatsapp", '' ) );
			if ( '' !== $wa ) {
				$cache[ $key ]['whatsapp'] = $wa;
			}

			foreach ( array_keys( $branch['hours'] ) as $day ) {
				$mod = trim( (string) get_theme_mod( "kms_{$key}_hours_{$day}", '' ) );
				if ( '' === $mod ) {
					continue;
				}
				if ( 0 === strcasecmp( $mod, 'closed' ) ) {
					$cache[ $key ]['hours'][ $day ] = null;
					continue;
				}
				if ( preg_match( '/^\s*(\d{1,2}:\d{2})\s*[-\x{2013}]\s*(\d{1,2}:\d{2})\s*$/u', $mod, $m ) ) {
					$cache[ $key ]['hours'][ $day ] = array( $m[1], $m[2] );
				}
			}
		}
	}

	if ( null === $slug ) {
		return $cache;
	}

	return isset( $cache[ $slug ] ) ? $cache[ $slug ] : null;
}

/**
 * Single-line postal address.
 *
 * @param array $branch Branch record.
 * @return string
 */
function kms_branch_address( array $branch ) {
	return sprintf(
		'%s, %s, %s, %s',
		$branch['street'],
		$branch['suburb'],
		$branch['city'],
		$branch['postcode']
	);
}

/**
 * Front-end URL for a branch page.
 *
 * Resolves the real permalink when a page with the matching slug exists,
 * so the site keeps working if someone renames or nests the page. Falls
 * back to /slug/ before the pages have been created.
 *
 * @param string $slug Branch slug.
 * @return string
 */
function kms_branch_url( $slug ) {
	$page = get_page_by_path( $slug );

	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}

	return home_url( '/' . $slug . '/' );
}

/**
 * The site's timezone-aware "now", used for open/closed calculations.
 *
 * @return DateTimeImmutable
 */
function kms_now() {
	return new DateTimeImmutable( 'now', wp_timezone() );
}

/**
 * Work out whether a branch is trading right now.
 *
 * Returns the state plus the next meaningful time, so templates can render
 * "Open until 17:00" or "Closed, opens Monday 08:00" without recomputing.
 *
 * @param array $branch Branch record.
 * @return array{open:bool,label:string,detail:string}
 */
function kms_branch_status( array $branch ) {
	$now     = kms_now();
	$weekday = (int) $now->format( 'N' );
	$minutes = ( (int) $now->format( 'G' ) * 60 ) + (int) $now->format( 'i' );

	$to_minutes = static function ( $hhmm ) {
		list( $h, $m ) = array_map( 'intval', explode( ':', $hhmm ) );
		return ( $h * 60 ) + $m;
	};

	$today = $branch['hours'][ $weekday ];

	if ( is_array( $today ) ) {
		$opens  = $to_minutes( $today[0] );
		$closes = $to_minutes( $today[1] );

		if ( $minutes >= $opens && $minutes < $closes ) {
			return array(
				'open'   => true,
				'label'  => __( 'Open now', 'kms-branch' ),
				/* translators: %s: closing time, e.g. 17:00 */
				'detail' => sprintf( __( 'until %s', 'kms-branch' ), $today[1] ),
			);
		}

		if ( $minutes < $opens ) {
			return array(
				'open'   => false,
				'label'  => __( 'Closed', 'kms-branch' ),
				/* translators: %s: opening time, e.g. 08:00 */
				'detail' => sprintf( __( 'opens %s today', 'kms-branch' ), $today[0] ),
			);
		}
	}

	// Walk forward to the next trading day.
	for ( $i = 1; $i <= 7; $i++ ) {
		$day  = ( ( $weekday + $i - 1 ) % 7 ) + 1;
		$slot = $branch['hours'][ $day ];

		if ( ! is_array( $slot ) ) {
			continue;
		}

		$day_name = 1 === $i
			? __( 'tomorrow', 'kms-branch' )
			: $now->modify( "+{$i} days" )->format( 'l' );

		return array(
			'open'   => false,
			'label'  => __( 'Closed', 'kms-branch' ),
			/* translators: 1: day name, 2: opening time */
			'detail' => sprintf( __( 'opens %1$s %2$s', 'kms-branch' ), $day_name, $slot[0] ),
		);
	}

	return array(
		'open'   => false,
		'label'  => __( 'Closed', 'kms-branch' ),
		'detail' => '',
	);
}

/**
 * Trading hours collapsed into readable rows.
 *
 * Consecutive days that share the same hours are grouped, so the table reads
 * "Mon to Fri  08:00 - 17:00" rather than five near-identical lines.
 *
 * @param array $branch Branch record.
 * @return array<int, array{days:string,hours:string,today:bool}>
 */
function kms_branch_hours_rows( array $branch ) {
	$labels  = array(
		1 => __( 'Mon', 'kms-branch' ),
		2 => __( 'Tue', 'kms-branch' ),
		3 => __( 'Wed', 'kms-branch' ),
		4 => __( 'Thu', 'kms-branch' ),
		5 => __( 'Fri', 'kms-branch' ),
		6 => __( 'Sat', 'kms-branch' ),
		7 => __( 'Sun', 'kms-branch' ),
	);
	$today   = (int) kms_now()->format( 'N' );
	$rows    = array();
	$current = null;

	for ( $day = 1; $day <= 7; $day++ ) {
		$slot = $branch['hours'][ $day ];
		$key  = is_array( $slot ) ? implode( '-', $slot ) : 'closed';

		if ( null !== $current && $current['key'] === $key ) {
			$current['end']    = $day;
			$current['today'] = $current['today'] || $day === $today;
			continue;
		}

		if ( null !== $current ) {
			$rows[] = $current;
		}

		$current = array(
			'key'   => $key,
			'start' => $day,
			'end'   => $day,
			'hours' => is_array( $slot )
				? $slot[0] . ' – ' . $slot[1]
				: __( 'Closed', 'kms-branch' ),
			'today' => $day === $today,
		);
	}

	if ( null !== $current ) {
		$rows[] = $current;
	}

	return array_map(
		static function ( $row ) use ( $labels ) {
			return array(
				'days'  => $row['start'] === $row['end']
					? $labels[ $row['start'] ]
					: $labels[ $row['start'] ] . ' – ' . $labels[ $row['end'] ],
				'hours' => $row['hours'],
				'today' => $row['today'],
			);
		},
		$rows
	);
}

/**
 * Build a wa.me link with a pre-filled enquiry.
 *
 * @param array  $branch  Branch record.
 * @param string $context Optional extra context appended to the message.
 * @return string
 */
function kms_whatsapp_url( array $branch, $context = '' ) {
	$message = sprintf(
		/* translators: %s: branch name */
		__( 'Hi Korean Motor Spares %s, I\'m looking for a part.', 'kms-branch' ),
		$branch['name']
	);

	if ( '' !== $context ) {
		$message .= ' ' . $context;
	}

	$message .= "\n\n" . __( 'Vehicle: ', 'kms-branch' ) . "\n" . __( 'Year: ', 'kms-branch' ) . "\n" . __( 'Part needed: ', 'kms-branch' );

	return 'https://wa.me/' . rawurlencode( $branch['whatsapp'] ) . '?text=' . rawurlencode( $message );
}

/**
 * Digits-only tel: href.
 *
 * @param array $branch Branch record.
 * @return string
 */
function kms_tel_url( array $branch ) {
	return 'tel:+' . preg_replace( '/\D/', '', $branch['phone'] );
}

/**
 * Link to the branch's Google Business Profile.
 *
 * Addressed by CID, which identifies one specific listing. A name or address
 * query would let Google choose between the several similarly named parts
 * shops in both areas, which is how customers end up at a competitor.
 *
 * @param array $branch Branch record.
 * @return string
 */
function kms_branch_maps_url( array $branch ) {
	if ( ! empty( $branch['cid'] ) ) {
		return 'https://www.google.com/maps?cid=' . rawurlencode( $branch['cid'] );
	}

	// Fallback for a branch added without a CID yet: coordinates still beat
	// a name search, because they cannot resolve to somebody else's shop.
	if ( ! empty( $branch['lat'] ) ) {
		return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $branch['lat'] . ',' . $branch['lng'] );
	}

	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $branch['full_name'] . ', ' . kms_branch_address( $branch ) );
}

/**
 * Turn-by-turn directions to the branch.
 *
 * The destination is the branch's own coordinates, so the route cannot be
 * re-resolved to a different shop with a similar name. Google still labels
 * the destination with the business at that point.
 *
 * @param array $branch Branch record.
 * @return string
 */
function kms_branch_directions_url( array $branch ) {
	if ( empty( $branch['lat'] ) || empty( $branch['lng'] ) ) {
		return kms_branch_maps_url( $branch );
	}

	$url = 'https://www.google.com/maps/dir/?api=1&destination='
		. rawurlencode( $branch['lat'] . ',' . $branch['lng'] );

	// Optional. With a real Place ID (the "ChIJ..." form, from the Google
	// Business Profile or Google's Place ID Finder) Maps labels the
	// destination with the trading name instead of the street address. The
	// route is already exact without it, so this is presentation only.
	// Note the 0x...:0x... form is NOT a Place ID and Maps ignores it.
	if ( ! empty( $branch['place_id'] ) && 0 === strpos( $branch['place_id'], 'ChI' ) ) {
		$url .= '&destination_place_id=' . rawurlencode( $branch['place_id'] );
	}

	return $url;
}

/**
 * Google Maps embed src for a branch. No API key required.
 *
 * Also keyed on the CID so the pin in the page is the same listing the
 * buttons point at.
 *
 * @param array $branch Branch record.
 * @return string
 */
function kms_map_embed( array $branch ) {
	if ( ! empty( $branch['cid'] ) ) {
		return 'https://www.google.com/maps?cid=' . rawurlencode( $branch['cid'] ) . '&output=embed';
	}

	$query = ! empty( $branch['lat'] )
		? $branch['lat'] . ',' . $branch['lng']
		: 'Korean Motor Spares, ' . kms_branch_address( $branch );

	return 'https://www.google.com/maps?q=' . rawurlencode( $query ) . '&output=embed';
}

/**
 * The part categories the group stocks.
 *
 * @return array<int, array{slug:string,label:string,blurb:string}>
 */
function kms_part_categories() {
	return array(
		array(
			'slug'  => 'engine',
			'label' => __( 'Engine', 'kms-branch' ),
			'blurb' => __( 'Gaskets, water pumps, timing kits, mountings.', 'kms-branch' ),
		),
		array(
			'slug'  => 'brakes',
			'label' => __( 'Brakes', 'kms-branch' ),
			'blurb' => __( 'Discs, drums, pads, shoes, cylinders, hoses.', 'kms-branch' ),
		),
		array(
			'slug'  => 'suspension',
			'label' => __( 'Suspension', 'kms-branch' ),
			'blurb' => __( 'Shocks, struts, control arms, bushes, links.', 'kms-branch' ),
		),
		array(
			'slug'  => 'service-kits',
			'label' => __( 'Service kits', 'kms-branch' ),
			'blurb' => __( 'Oil, air, fuel and cabin filters, plugs, in one box.', 'kms-branch' ),
		),
		array(
			'slug'  => 'electrical',
			'label' => __( 'Electrical', 'kms-branch' ),
			'blurb' => __( 'Alternators, starters, sensors, coils, switches.', 'kms-branch' ),
		),
		array(
			'slug'  => 'transmission',
			'label' => __( 'Transmission', 'kms-branch' ),
			'blurb' => __( 'Clutch kits, CV joints, driveshafts, mountings.', 'kms-branch' ),
		),
		array(
			'slug'  => 'body',
			'label' => __( 'Body & trim', 'kms-branch' ),
			'blurb' => __( 'Bumpers, grilles, lamps, mirrors, panels.', 'kms-branch' ),
		),
	);
}

/**
 * The makes carried, exactly as they appear on the shopfront boards.
 *
 * @return array<int, string>
 */
function kms_makes() {
	return array( 'Hyundai', 'Kia', 'Daewoo', 'SsangYong' );
}
