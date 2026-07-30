<?php
/**
 * Theme bootstrap.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

define( 'KMS_VERSION', '1.0.0' );

require_once get_theme_file_path( 'inc/branches.php' );
require_once get_theme_file_path( 'inc/icons.php' );
require_once get_theme_file_path( 'inc/customizer.php' );
require_once get_theme_file_path( 'inc/schema.php' );

/**
 * Theme supports.
 */
function kms_setup() {
	load_theme_textdomain( 'kms-branch', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 950,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary', 'kms-branch' ),
		)
	);
}
add_action( 'after_setup_theme', 'kms_setup' );

/**
 * Styles and scripts.
 *
 * Fonts are self-hosted rather than pulled from Google, so the page has no
 * third-party render-blocking request and no consent problem.
 */
function kms_assets() {
	wp_enqueue_style(
		'kms-main',
		get_theme_file_uri( 'assets/css/main.css' ),
		array(),
		KMS_VERSION
	);

	wp_enqueue_script(
		'kms-main',
		get_theme_file_uri( 'assets/js/main.js' ),
		array(),
		KMS_VERSION,
		true
	);

	wp_localize_script(
		'kms-main',
		'kmsData',
		array(
			'branches' => array_map(
				static function ( $branch ) {
					return array(
						'slug'  => $branch['slug'],
						'hours' => $branch['hours'],
					);
				},
				kms_branch()
			),
			'strings'  => array(
				'openNow'   => __( 'Open now', 'kms-branch' ),
				'closed'    => __( 'Closed', 'kms-branch' ),
				'until'     => __( 'until %s', 'kms-branch' ),
				'opensAt'   => __( 'opens %s today', 'kms-branch' ),
				'opensDay'  => __( 'opens %1$s %2$s', 'kms-branch' ),
				'tomorrow'  => __( 'tomorrow', 'kms-branch' ),
			),
			'timezone' => wp_timezone_string(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'kms_assets' );

/**
 * Preload the typeface and the hero image.
 *
 * One variable font file covers every weight the site uses, so a single
 * preload gets the whole type system in flight. The hero image is the LCP
 * element on the landing page, so it is preloaded with the same responsive
 * sources the markup declares.
 */
function kms_preload_assets() {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_theme_file_uri( 'assets/fonts/instrument-sans-var.woff2' ) )
	);

	if ( is_front_page() ) {
		printf(
			'<link rel="preload" as="image" href="%1$s" imagesrcset="%2$s 800w, %3$s 1600w" imagesizes="100vw" fetchpriority="high">' . "\n",
			esc_url( kms_img( 'hero-portrait.webp' ) ),
			esc_url( kms_img( 'hero-portrait.webp' ) ),
			esc_url( kms_img( 'hero-portrait@1600.webp' ) )
		);
	}
}
add_action( 'wp_head', 'kms_preload_assets', 1 );

/**
 * Strip WordPress cruft this site has no use for.
 */
function kms_dequeue_bloat() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'kms_dequeue_bloat', 100 );

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/**
 * Body classes that templates key off.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function kms_body_class( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-landing';
	}

	$branch = kms_current_branch();
	if ( $branch ) {
		$classes[] = 'is-branch';
		$classes[] = 'is-branch-' . $branch['slug'];
	}

	return $classes;
}
add_filter( 'body_class', 'kms_body_class' );

/**
 * The branch this request is about, if any.
 *
 * Templates set $GLOBALS['kms_branch_slug'] before loading the shared branch
 * partial; everything else infers it from the page slug.
 *
 * @return array|null
 */
function kms_current_branch() {
	if ( ! empty( $GLOBALS['kms_branch_slug'] ) ) {
		return kms_branch( $GLOBALS['kms_branch_slug'] );
	}

	if ( is_page() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			return kms_branch( $post->post_name );
		}
	}

	return null;
}

/**
 * Theme image URL helper.
 *
 * @param string $file Filename inside assets/img.
 * @return string
 */
function kms_img( $file ) {
	return get_theme_file_uri( 'assets/img/' . $file );
}

/**
 * Render a responsive theme image.
 *
 * @param array $args Image arguments.
 */
function kms_image( array $args ) {
	$args = wp_parse_args(
		$args,
		array(
			'file'    => '',
			'alt'     => '',
			'width'   => 0,
			'height'  => 0,
			'class'   => '',
			'loading' => 'lazy',
			'sizes'   => '100vw',
			'fetchpriority' => '',
		)
	);

	if ( '' === $args['file'] ) {
		return;
	}

	printf(
		'<img src="%1$s" alt="%2$s" width="%3$d" height="%4$d" class="%5$s" loading="%6$s" decoding="async" sizes="%7$s"%8$s>',
		esc_url( kms_img( $args['file'] ) ),
		esc_attr( $args['alt'] ),
		(int) $args['width'],
		(int) $args['height'],
		esc_attr( $args['class'] ),
		esc_attr( $args['loading'] ),
		esc_attr( $args['sizes'] ),
		$args['fetchpriority'] ? ' fetchpriority="' . esc_attr( $args['fetchpriority'] ) . '"' : ''
	);
}

/**
 * Excerpt-free, comment-free: this is a brochure site.
 */
function kms_disable_comments() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
add_action( 'init', 'kms_disable_comments' );
