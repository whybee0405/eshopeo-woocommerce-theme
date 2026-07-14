<?php
/**
 * Parts-Mall SEO meta and schema layer.
 *
 * PERSONA 1 — The independent mechanic / workshop owner (trade buyer, time-pressured)
 * Searches: brake pads for Hyundai i20 Johannesburg, Kia alternator supplier South Africa.
 * Served by: fast catalogue discovery, branch stock-checks, rapid part enquiry.
 *
 * PERSONA 2 — The fleet / parts procurement manager (volume buyer)
 * Searches: bulk auto parts supplier South Africa, Parts-Mall become a distributor.
 * Served by: agent page, branch scale, quality-backed private brands.
 *
 * PERSONA 3 — The car owner sourcing a specific part (part-number led)
 * Searches: Kia Sportage brake pads price, genuine vs aftermarket Hyundai parts.
 * Served by: product pages, make/category search, branch finder.
 *
 * PERSONA 4 — The prospective agent / branch partner (business-opportunity seeker)
 * Searches: become a Parts-Mall agent, auto parts distributorship South Africa.
 * Served by: agent page, about page, footprint proof.
 *
 * @package PartsMall
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function partsmall_faq_items(): array {
	return array(
		array(
			'q' => __( 'How do I check whether a branch can supply a specific part?', 'parts-mall' ),
			'a' => __( 'Open the part, click “Find a branch”, and send an enquiry with the part number or OEM reference. The Parts-Mall team checks the nearest branch or agent and confirms availability, alternatives, or order-in lead time.', 'parts-mall' ),
		),
		array(
			'q' => __( 'Do you only supply Parts-Mall branded parts?', 'parts-mall' ),
			'a' => __( 'No. Parts-Mall carries its private brands such as PMC, NT, Car-Dex, Pomax, MX, Ex-Trim, Vichura, Pro-Tec and Dashi, plus OEM/Genuine options where available. Every private-brand line is positioned around dependable trade supply and warranty support.', 'parts-mall' ),
		),
		array(
			'q' => __( 'Can workshops and fleet buyers open a trade relationship?', 'parts-mall' ),
			'a' => __( 'Yes. Use the Become an Agent page to tell Parts-Mall about your business, buying volumes, and region. The team will respond with the right branch contact and next steps for supply or distributor discussions.', 'parts-mall' ),
		),
		array(
			'q' => __( 'Which vehicle makes does Parts-Mall support?', 'parts-mall' ),
			'a' => __( 'The catalogue is led by Korean and related vehicle applications including Kia, Hyundai, Chevrolet, Ssangyong, Suzuki, Daewoo, GWM/Haval, Ford, Daihatsu, Nissan and Toyota. Use make chips and part compatibility notes on every product to narrow quickly.', 'parts-mall' ),
		),
		array(
			'q' => __( 'Do you sell online with checkout and delivery?', 'parts-mall' ),
			'a' => __( 'No. Parts-Mall is a wholesale branch-and-agent network, not a retail webshop. The site is designed for browsing, stock checking, quoting, and connecting you to the right branch or trade contact.', 'parts-mall' ),
		),
	);
}

function partsmall_seo_current_url(): string {
	if ( function_exists( 'is_singular' ) && is_singular() ) {
		$link = get_permalink();
		if ( $link ) {
			return $link;
		}
	}

	if ( function_exists( 'is_tax' ) && is_tax() ) {
		$obj = get_queried_object();
		if ( $obj instanceof WP_Term ) {
			$link = get_term_link( $obj );
			if ( ! is_wp_error( $link ) ) {
				return $link;
			}
		}
	}

	if ( function_exists( 'is_shop' ) && is_shop() && function_exists( 'wc_get_page_permalink' ) ) {
		return wc_get_page_permalink( 'shop' );
	}

	return home_url( '/' );
}

function partsmall_seo_default_image(): string {
	return get_theme_file_uri( 'images/logo.svg' );
}

function partsmall_seo_build_meta(): array {
	$site_name = get_bloginfo( 'name' );
	if ( '' === trim( $site_name ) ) {
		$site_name = 'Parts-Mall Africa';
	}

	$data = array(
		'title'       => $site_name,
		'description' => __( 'Parts-Mall Africa supplies automotive parts across Southern Africa through a large branch and agent network. Search by part, make, or brand and enquire directly with the team.', 'parts-mall' ),
		'keywords'    => 'Parts-Mall Africa, auto parts supplier South Africa, Korean vehicle parts, branch stock check, wholesale auto parts',
		'og_type'     => 'website',
		'image'       => partsmall_seo_default_image(),
		'url'         => partsmall_seo_current_url(),
	);

	if ( is_front_page() ) {
		$data['title']       = __( 'Korea’s #1 Automotive Parts Supplier | Parts-Mall Africa', 'parts-mall' );
		$data['description'] = __( 'Search Parts-Mall Africa’s catalogue by part, category or make. Built for workshops, fleet buyers and car owners who need a reliable branch-and-agent supply network across Southern Africa.', 'parts-mall' );
		$data['keywords']    = 'brake pads Hyundai Johannesburg, Kia parts supplier South Africa, Parts-Mall Africa catalogue, Korean spare parts supplier';
	}

	if ( function_exists( 'is_product' ) && is_product() ) {
		$product = wc_get_product( get_the_ID() );
		if ( $product instanceof WC_Product ) {
			$product_id = $product->get_id();
			$number     = (string) partsmall_meta( $product_id, '_part_number' );
			$make_list  = partsmall_parse_csv( (string) partsmall_meta( $product_id, '_part_compatible_makes' ) );
			$make_text  = ! empty( $make_list ) ? implode( ', ', array_slice( $make_list, 0, 3 ) ) : __( 'multiple applications', 'parts-mall' );
			$category   = partsmall_primary_product_category( $product_id );
			$brand      = (string) partsmall_meta( $product_id, '_part_private_brand' );
			$data['title']       = $product->get_name() . ' | Parts-Mall Africa';
			$data['description'] = sprintf(
				/* translators: 1: part name, 2: makes list, 3: part number. */
				__( '%1$s for %2$s. Request branch availability, OEM cross-reference and trade pricing from Parts-Mall Africa. Part number: %3$s.', 'parts-mall' ),
				$product->get_name(),
				$make_text,
				$number ? $number : __( 'Available on request', 'parts-mall' )
			);
			$data['keywords'] = trim( implode( ', ', array_filter( array( $product->get_name(), $number, $brand, $category ? $category->name : '', $make_text ) ) ), ', ' );
			$data['og_type']  = 'product';
			if ( $product->get_image_id() ) {
				$data['image'] = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
			}
		}
	}

	if ( is_tax( 'product_cat' ) || ( function_exists( 'is_shop' ) && is_shop() ) ) {
		$term_name = '';
		if ( is_tax( 'product_cat' ) ) {
			$term = get_queried_object();
			if ( $term instanceof WP_Term ) {
				$term_name = $term->name;
			}
		}
		$data['title']       = $term_name ? $term_name . ' | Parts catalogue | Parts-Mall Africa' : __( 'Parts catalogue | Parts-Mall Africa', 'parts-mall' );
		$data['description'] = __( 'Browse the Parts-Mall catalogue by category, make, private brand and availability. Built for mechanics and trade buyers who need the right part fast.', 'parts-mall' );
		$data['keywords']    = 'auto parts catalogue South Africa, branch stock check, Korean spare parts, wholesale parts supplier';
	}

	if ( is_page_template( 'page-agent.php' ) ) {
		$data['title']       = __( 'Become an Agent | Parts-Mall Africa', 'parts-mall' );
		$data['description'] = __( 'Partner with Parts-Mall Africa as an agent, distributor or trade account. See the network footprint, private-brand support and branch-backed supply coverage across Southern Africa.', 'parts-mall' );
		$data['keywords']    = 'become a Parts-Mall agent, auto parts distributorship South Africa, bulk parts supplier';
	}

	if ( is_page_template( 'page-about.php' ) ) {
		$data['title']       = __( 'About Parts-Mall Africa', 'parts-mall' );
		$data['description'] = __( 'Learn how Parts-Mall Africa built a branch-and-agent network around Korean vehicle parts, dependable private brands and long-term trade relationships across Southern Africa.', 'parts-mall' );
		$data['keywords']    = 'about Parts-Mall Africa, Korean automotive parts supplier, auto parts branch network';
	}

	if ( is_page_template( 'page-contact.php' ) ) {
		$data['title']       = __( 'Contact Parts-Mall Africa', 'parts-mall' );
		$data['description'] = __( 'Talk to Parts-Mall Africa about branch support, stock checks, account enquiries or private-brand supply. Use the branch locator for your nearest outlet or contact head office directly.', 'parts-mall' );
	}

	return $data;
}

function partsmall_meta_tags(): void {
	$data = partsmall_seo_build_meta();
	?>
	<meta name="description" content="<?php echo esc_attr( $data['description'] ); ?>">
	<meta name="keywords" content="<?php echo esc_attr( $data['keywords'] ); ?>">
	<meta property="og:title" content="<?php echo esc_attr( $data['title'] ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $data['description'] ); ?>">
	<meta property="og:type" content="<?php echo esc_attr( $data['og_type'] ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $data['url'] ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $data['image'] ); ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr( $data['title'] ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $data['description'] ); ?>">
	<meta name="twitter:image" content="<?php echo esc_url( $data['image'] ); ?>">
	<?php
}
add_action( 'wp_head', 'partsmall_meta_tags', 1 );

function partsmall_seo_print_json_ld( array $schema ): void {
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

function partsmall_seo_organization(): array {
	$branches        = partsmall_branches();
	$locations       = array();
	$area_served     = array( 'South Africa', 'Botswana', 'Eswatini', 'Mozambique', 'Namibia', 'Zimbabwe' );
	$known_countries = array();

	foreach ( $branches as $province => $items ) {
		foreach ( $items as $branch ) {
			$country           = ! empty( $branch['country'] ) ? $branch['country'] : 'South Africa';
			$known_countries[] = $country;
			$locations[]       = array(
				'@type'     => 'AutoPartsStore',
				'name'      => 'Parts-Mall ' . $branch['name'],
				'telephone' => $branch['phone'],
				'email'     => isset( $branch['email'] ) ? $branch['email'] : '',
				'address'   => array(
					'@type'          => 'PostalAddress',
					'streetAddress'  => $branch['address'],
					'addressRegion'  => 'Pan-Africa' === $province ? '' : $province,
					'addressCountry' => $country,
				),
			);
		}
	}

	return array(
		'@context'       => 'https://schema.org',
		'@type'          => 'Organization',
		'additionalType' => 'https://schema.org/AutoPartsStore',
		'name'           => 'Parts-Mall Africa',
		'url'            => home_url( '/' ),
		'logo'           => get_theme_file_uri( 'images/logo.svg' ),
		'image'          => partsmall_seo_default_image(),
		'slogan'         => "Korea's #1 Automotive Parts Supplier.",
		'email'          => 'info@partsmall.co.za',
		'telephone'      => '+27 11 000 0000',
		'address'        => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => '400 Voortrekker Road',
			'addressLocality' => 'Parow',
			'addressRegion'   => 'Western Cape',
			'addressCountry'  => 'ZA',
		),
		'areaServed'     => array_values( array_unique( array_merge( $area_served, $known_countries ) ) ),
		'department'     => $locations,
		'location'       => $locations,
	);
}

function partsmall_seo_website(): array {
	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'WebSite',
		'name'            => 'Parts-Mall Africa',
		'url'             => home_url( '/' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => home_url( '/?s={search_term_string}&post_type=product' ),
			'query-input' => 'required name=search_term_string',
		),
	);
}

function partsmall_seo_product_schema( WC_Product $product ): array {
	$product_id       = $product->get_id();
	$brand            = (string) partsmall_meta( $product_id, '_part_private_brand' );
	$category         = partsmall_primary_product_category( $product_id );
	$availability     = (string) partsmall_meta( $product_id, '_part_availability' );
	$availability_map = array(
		'in_stock'     => 'https://schema.org/InStock',
		'order_in'     => 'https://schema.org/PreOrder',
		'check_branch' => 'https://schema.org/LimitedAvailability',
	);

	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'Product',
		'name'          => $product->get_name(),
		'sku'           => (string) partsmall_meta( $product_id, '_part_number' ),
		'category'      => $category ? $category->name : '',
		'brand'         => $brand ? array( '@type' => 'Brand', 'name' => $brand ) : null,
		'description'   => wp_strip_all_tags( $product->get_short_description() ? $product->get_short_description() : $product->get_description() ),
		'itemCondition' => 'https://schema.org/NewCondition',
		'image'         => $product->get_image_id() ? wp_get_attachment_image_url( $product->get_image_id(), 'full' ) : get_theme_file_uri( 'images/placeholders/part-default.svg' ),
	);

	if ( '' !== $availability ) {
		$schema['offers'] = array(
			'@type'         => 'Offer',
			'priceCurrency' => 'ZAR',
			'availability'  => isset( $availability_map[ $availability ] ) ? $availability_map[ $availability ] : 'https://schema.org/InStock',
			'url'           => get_permalink( $product_id ),
		);
		if ( '' !== $product->get_price() ) {
			$schema['offers']['price'] = wc_format_decimal( $product->get_price(), 2 );
		}
	}

	return array_filter( $schema );
}

function partsmall_seo_breadcrumb_schema(): ?array {
	$items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => 'Home',
			'item'     => home_url( '/' ),
		),
	);

	if ( function_exists( 'is_shop' ) && is_shop() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Catalogue',
			'item'     => wc_get_page_permalink( 'shop' ),
		);
	} elseif ( is_tax( 'product_cat' ) ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => 'Catalogue',
				'item'     => wc_get_page_permalink( 'shop' ),
			);
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => $term->name,
				'item'     => get_term_link( $term ),
			);
		}
	} elseif ( function_exists( 'is_product' ) && is_product() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Catalogue',
			'item'     => wc_get_page_permalink( 'shop' ),
		);
		$category = partsmall_primary_product_category( get_the_ID() );
		$position = 3;
		if ( $category instanceof WP_Term ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => $category->name,
				'item'     => get_term_link( $category ),
			);
			++$position;
		}
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	}

	if ( count( $items ) < 2 ) {
		return null;
	}

	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);
}

function partsmall_seo_faq_schema(): array {
	$items = array();
	foreach ( partsmall_faq_items() as $faq ) {
		$items[] = array(
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $faq['a'],
			),
		);
	}

	return array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $items,
	);
}

function partsmall_json_ld(): void {
	partsmall_seo_print_json_ld( partsmall_seo_organization() );
	partsmall_seo_print_json_ld( partsmall_seo_website() );

	if ( function_exists( 'is_product' ) && is_product() ) {
		$product = wc_get_product( get_the_ID() );
		if ( $product instanceof WC_Product ) {
			partsmall_seo_print_json_ld( partsmall_seo_product_schema( $product ) );
		}
	}

	$breadcrumb = partsmall_seo_breadcrumb_schema();
	if ( $breadcrumb ) {
		partsmall_seo_print_json_ld( $breadcrumb );
	}

	if ( is_page_template( 'page-about.php' ) || is_page_template( 'page-contact.php' ) ) {
		partsmall_seo_print_json_ld( partsmall_seo_faq_schema() );
	}
}
add_action( 'wp_head', 'partsmall_json_ld', 2 );
